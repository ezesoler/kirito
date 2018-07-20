<?php
use App\Model\Model;


$app->add(function ($request, $response, $next) {
  if($request->getUri()->getPath() == "user/check" || $request->getUri()->getPath() == "prode/version"){
    $response = $next($request, $response);
  }else{
    $token = $request->getHeader("Authorization");
    $data = json_decode(file_get_contents("php://input"));
    $um = new Model();
    $rs = $um->GetUser($data->email);
    if($rs->result){
      if(hash('sha256',$data->email.$rs->result->code) == $token[0]){
        $response = $next($request, $response);
      }else{
        $respond = array('status' => 0);
        $response->getBody()->write(json_encode($respond));
      }
    }else{
      $respond = array('status' => 0);
      $response->getBody()->write(json_encode($respond));
    }
  }
  return $response;
});


$app->group('/user/', function () {
      

    $this->post('check', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $rs = $um->StatusUser($data->email);
        if($rs->result){
          $code = '';

          for($i = 0; $i < 5; $i++) {
              $code .= mt_rand(0, 9);
          }

          $um->GenerateCode($data->email,$code);
          $mailer = new Mailer();
          $mailer->send($data->email,$code);
          $respond = array('status' => 1,'token' => hash('sha256',$data->email.$code));
        }else{
          $respond = array('status' => 0);
        }

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });

    $this->post('activate', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $rs = $um->GetUser($data->email);
        $respond;
        if($rs->result){
          if(intval($rs->result->code) == intval($data->code)){
              $um->SaveName($data->email,$data->name,$data->tfcm);
              $respond = array('status' => 1);
          }else{
            $respond = array('status' => 0);
          }
        }else{
          $respond = array('status' => 0);
        }

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });

    $this->post('predicciones', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $rs = $um->PrediccionesUser($data->email,$data->fase);
        $respond;
        if($rs->result){
          $respond = array('status' => 1,'predicciones' => $rs->result); 
        }else{
          $respond = array('status' => 1,'predicciones' => $rs->result);
        }

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });

    $this->post('today', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $rsh = $um->PrediccionesDay($data->email,0);
        $today = $rsh->result;
        $rsm = $um->PrediccionesDay($data->email,1);
        $tomorrow = $rsm->result;
        $respond;
        if($rs->result){
          $respond = array('status' => 1,'today' => $today, 'tomorrow' => $tomorrow); 
        }else{
          $respond = array('status' => 1,'today' => $today, 'tomorrow' => $tomorrow);
        }

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });

    $this->post('save', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $partidos = $data->predicciones;

        foreach ($partidos as $partido) {
        	$um->savePrediccion($data->email,$partido);
        }
        
        $respond = array('status' => 1); 
       
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    }); 

    $this->post('stats', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $usuario = $um->GetUser($data->idUser);
        $stats = $um->getStatUser($data->idUser);
        $respond;
        $respond = array('status' => 1,'nombre'=>$usuario->result->nombre,'stats' => $stats); 


        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });

    $this->post('message', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new Model();
       	$um->saveMessege($data->email,$data->message);

       	$respond = array('status' => 1); 

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });

    $this->post('unread', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $unread = $um->unreadMesseges($data->date);

        $respond = array('status' => 1, 'number' => $unread->result->notifications); 

        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });
    
});


$app->group('/prode/', function () {

  $this->post('version', function ($req, $res) {
    $respond = array('version' => "6");
    return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
  });

  $this->post('ranking', function ($req, $res) {
        //$data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $usuarios = $um->getAllUserActives();
        $ranking = array();

        foreach ($usuarios->result as $usuario) {
          $user = new \stdClass();
          $user->email = $usuario->email;
          $user->name = $usuario->nombre;
          $user->score = $um->getScoreUser($usuario->email);
          $user->stats = $um->getStatUser($usuario->email);
          array_push($ranking, $user);
        }
        
        $respond = array('status' => 1,'ranking'=>$ranking); 
       
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });

    $this->post('news', function ($req, $res) {
        //$data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $rs = $um->GetNews();

        $respond;
        if($rs->result){
          $respond = array('status' => 1,'news' => $rs->result); 
        }else{
          $respond = array('status' => 0);
        }
       
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });

    $this->post('messages', function ($req, $res) {
        //$data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $rs = $um->GetMessages();

        $respond;
        if($rs->result){
          $respond = array('status' => 1,'messages' => $rs->result); 
        }else{
          $respond = array('status' => 0);
        }
       
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });

    $this->post('resultados', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $rs = $um->Resultados($data->email);

        $respond;
        if($rs->result){
          $respond = array('status' => 1,'resultados' => $rs->result); 
        }else{
          $respond = array('status' => 1,'resultados' => '');
        }
       
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });

    $this->post('prediccionesusers', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new Model();
        $rsp = $um->GetPartido($data->idPartido);

        $respond;
        if($rsp->result){
          $dataPartido = $rsp->result;
          $rsu = $um->PrediccionesPartido($data->idPartido);
          $respond = array('status' => 1,'partido' => $dataPartido, 'predicciones' => $rsu->result); 
        }else{
          $respond = array('status' => 0);
        }
       
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $respond
            )
        );
    });
});