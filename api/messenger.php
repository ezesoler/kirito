<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

if(date('H') > 23 || date('H') < 9){
    die();    
}

$datefile = fopen("date.txt", "r");
$date = fread($datefile,filesize("date.txt"));
fclose($datefile);

$pdo = new PDO('mysql:host=localhost;dbname=[DB_NAME];charset=utf8', '[DB_USER]', '[DB_PASSWORD]');
        
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$db = $pdo;

$stm = $db->prepare("SELECT * FROM mensajeria WHERE fecha > '$date'");
$stm->execute();

$mensajes = $stm->fetchAll();

if(count($mensajes) > 0){
    $emails = array();
    $users = array();
    foreach ($mensajes as $mensaje) {
        if(!in_array($mensaje->email, $emails, true)){
            array_push($emails, $mensaje->email);
        }
    }
    foreach ($emails as $email){
        $stmu = $db->prepare("SELECT nombre FROM usuarios WHERE email = ?");
        $stmu->execute(array($email));
        $usuarios = $stmu->fetchAll();
        foreach ($usuarios as $usuario) {
            array_push($users, $usuario->nombre);
        }
    }
    //echo implode( ',', $users );
    sendNotification(implode(', ', $users ),count($mensajes));
    $datefile = fopen("date.txt", "w");
    fwrite($datefile, $mensajes[count($mensajes)-1]->fecha);
    fclose($datefile);  
}

function sendNotification($users,$numero){
    $data = null;

    $mensaje = "Hay $numero de mensajes nuevos de $users en el Forobardo del Prode, entrá a ver si te están sacando el cuero a vos!";

    if($numero == 1){
        $mensaje = "Hay un mensaje nuevo de $users en el Forobardo del Prode, entrá a ver si te está sacando el cuero a vos!";
    }
    
    $headers = [
        'Authorization:key=[KEY_AUTHORIZATION]',
        'Content-Type: application/json'
    ];

    $data = [
        'to' => "/topics/kirito",
        'android_channel_id' => 'kirito',
        'data' => [
            'type' => 'menssage',
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