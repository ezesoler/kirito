<?php
use App\Model\UserModel;

$app->group('/user/', function () {
    
    $this->get('test', function ($req, $res, $args) {
        return $res->getBody()
                   ->write('Hello Users');
    });
    
    $this->get('getAll', function ($req, $res, $args) {
        $um = new UserModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });
    
    $this->get('get/{email}', function ($req, $res, $args) {
        $um = new UserModel();
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Get($args['email'])
            )
        );
    });

    $this->post('check', function ($req, $res) {
        $data = json_decode(file_get_contents("php://input"));
        $um = new UserModel();
        $rs = $um->Status($data->email);
        if($rs->result){
          $code = '';

          for($i = 0; $i < 5; $i++) {
              $code .= mt_rand(0, 9);
          }

          $um->GenerateCode($data->email,$code);
          //$mailer = new Mailer();
          //$mailer->send($data->email,$code);
          $respond = array('status' => 1);
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
        $um = new UserModel();
        $rs = $um->Get($data->email);
        $respond;
        if($rs->result){
          if(intval($rs->result->code) == intval($data->code)){
              $um->SaveName($data->email,$data->name);
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
        $um = new UserModel();
        $rs = $um->Predicciones($data->email);
        $respond;
        if($rs->result){
          if(intval($rs->result->code) == intval($data->code)){
              $um->SaveName($data->email,$data->name);
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
    
    $this->post('save', function ($req, $res) {
        $um = new UserModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->InsertOrUpdate(
                    $req->getParsedBody()
                )
            )
        );
    });
    
    $this->post('delete/{id}', function ($req, $res, $args) {
        $um = new UserModel();
        
        return $res
           ->withHeader('Content-type', 'application/json')
           ->getBody()
           ->write(
            json_encode(
                $um->Delete($args['id'])
            )
        );
    });
    
});