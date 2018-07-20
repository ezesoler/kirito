<?php
use App\Model\ProdeModel;

$app->group('/prode/', function () {

	$this->post('predicciones', function ($req, $res) {
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

});