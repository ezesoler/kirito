<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$pdo = new PDO('mysql:host=localhost;dbname=[DB_NAME];charset=utf8', '[DB_USER]', '[DB_PASSWORD]');
        
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$db = $pdo;

$stm = $db->prepare("SELECT * FROM usuarios WHERE activo = 1");
$stm->execute();

$usuarios = $stm->fetchAll();

foreach ($usuarios as $usuario) {
    $count = 0;
    $stmp = $db->prepare("SELECT id,
                                    (SELECT marcadorLocal FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ? ) AS prediccionLocal,
                                    (SELECT marcadorVisitante FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ? ) AS prediccionVisitante
                                    FROM partidos WHERE fecha = DATE(NOW() + INTERVAL 1 DAY)");
    $stmp->execute(array($usuario->email,$usuario->email));
    $partidos = $stmp->fetchAll();
    foreach ($partidos as $partido) {
        if(is_null($partido->prediccionLocal) || is_null($partido->prediccionVisitante)){
            $count++;
        }
    }
    if($count > 0){
        sendNotification($usuario->nombre,$usuario->tfcm,$count);
    }
}


function sendNotification($nombre,$tfcm,$numero){
    $data = null;

    $mensaje = $nombre.'! tenés '.$numero.' de partidos que se jugarán mañana y aún no les cargaste tu predicción, apurate!';

    if($numero == 1){
        $mensaje = $nombre.'! tenés '.$numero.' partido que se jugará mañana y aún no le cargaste tu predicción, apurate!';
    }
    
    $headers = [
        'Authorization:key=[KEY_AUTHORIZATION]',
        'Content-Type: application/json'
    ];

    $data = [
        'to' => $tfcm,
        'android_channel_id' => 'kirito',
        'data' => [
            'type' => 'reminder',
            'title' => 'Prode 2018',
            'message' => $mensaje,
            'image' => '[HOST]/kirito/imgs/icon.png'
        ]
    ];

    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $data ) );
    curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
    $result = curl_exec($ch);
    curl_close( $ch );
    print_r($result);
}
?>