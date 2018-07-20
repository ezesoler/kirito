<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class Model
{
    private $db;
    private $tableUser = 'usuarios';
    private $tablePartidos = 'partidos';
    private $tablePredicciones = 'predicciones';
    private $tableNews = "noticias";
    private $tableMessages = "mensajeria";
    
    private $response;
    
    public function __CONSTRUCT()
    {
        $this->db = Database::StartUp();
        $this->response = new Response();
    }
      

    public function StatusUser($email)
    {
        try
        {
            $result = array();
            $stm = $this->db->prepare("SELECT activo FROM $this->tableUser WHERE email = ?");
            $stm->execute(array($email));

            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }  
    }

    public function GenerateCode($email,$code){
        try
        {
            $sql = "UPDATE $this->tableUser SET 
                            code = ?
                        WHERE email = ?";
            $this->db->prepare($sql)
                     ->execute(
                        array(
                            $code, 
                            $email
                        )
                    );

            $this->response->setResponse(true);
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function SaveName($email,$name,$tfcm){
        try
        {
            $sql = "UPDATE $this->tableUser SET 
                            nombre = ?,
                            activo = 1,
                            tfcm = ?
                        WHERE email = ?";
            $this->db->prepare($sql)
                     ->execute(
                        array(
                            $name,
                            $tfcm, 
                            $email
                        )
                    );

            $this->response->setResponse(true);
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }


    public function GetUser($email)
    {
		try
		{
			$result = array();
			$stm = $this->db->prepare("SELECT * FROM $this->tableUser WHERE email = ?");
			$stm->execute(array($email));

			$this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            
            return $this->response;
		}
		catch(Exception $e)
		{
			$this->response->setResponse(false, $e->getMessage());
            return $this->response;
		}  
    }

    public function PrediccionesUser($email,$fase)
    {
        try
        {
            $result = array();
            $this->db->query("SET lc_time_names = 'es_ES';");
            $filter = "= 'grupo'";
            if($fase != "grupo"){
                $filter = "<> 'grupo'";
            }
            $stm = $this->db->prepare("SELECT id,
                                              grupo,
                                              fase,
                                              LOWER(local) AS local,
                                              LOWER(visitante) AS visitante,
                                              marcadorLocal,
                                              marcadorVisitante,
                                              DATE_FORMAT(fecha,'%d %M') AS fecha,
                                              (fecha > NOW()) AS habilitado,
                                              hora,
                                              LOWER((SELECT nombre FROM selecciones WHERE partidos.local = selecciones.id )) AS nombreLocal,
                                              LOWER((SELECT nombre FROM selecciones WHERE partidos.visitante = selecciones.id )) AS nombreVisitante,
                                              (SELECT marcadorLocal FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ? ) AS prediccionLocal,
                                            (SELECT marcadorVisitante FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ? ) AS prediccionVisitante
                                            FROM $this->tablePartidos WHERE fase $filter ORDER BY grupo ASC, id ASC");
            $stm->execute(array($email,$email));

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }  
    }


    public function PrediccionesDay($email,$day)
    {
        try
        {
            $result = array();
            $this->db->query("SET lc_time_names = 'es_ES';");
            $filter = "DATE(fecha) = CURDATE()";
            if($day == 1){
                $filter = "DATE(fecha) = CURDATE() + INTERVAL 1 DAY";
            }
            $stm = $this->db->prepare("SELECT id,
                                              grupo,
                                              fase,
                                              LOWER(local) AS local,
                                              LOWER(visitante) AS visitante,
                                              marcadorLocal,
                                              marcadorVisitante,
                                              DATE_FORMAT(fecha,'%d %M') AS fecha,
                                              (fecha > NOW()) AS habilitado,
                                              hora,
                                              jugado,
                                              LOWER((SELECT nombre FROM selecciones WHERE partidos.local = selecciones.id )) AS nombreLocal,
                                              LOWER((SELECT nombre FROM selecciones WHERE partidos.visitante = selecciones.id )) AS nombreVisitante,
                                              (SELECT marcadorLocal FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ? ) AS prediccionLocal,
                                            (SELECT marcadorVisitante FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ? ) AS prediccionVisitante
                                            FROM $this->tablePartidos WHERE $filter ORDER BY id ASC");
            $stm->execute(array($email,$email));

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }  
    }

    public function PrediccionesPartido($idPartido)
    {
    	try
        {
            $stm = $this->db->prepare("SELECT usuarios.nombre,  predicciones.marcadorLocal, usuarios.email, predicciones.marcadorVisitante FROM $this->tableUser INNER JOIN $this->tablePredicciones ON usuarios.email = predicciones.email WHERE predicciones.idPartido = ? ORDER BY usuarios.id ASC");
            $stm->execute(array($idPartido));

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }  
    }

    public function GetPartido($idPartido)
    {
		try
		{
			$result = array();
			$stm = $this->db->prepare("SELECT id,
                                              grupo,
                                              fase,
                                              jugado,
                                              LOWER(local) AS local,
                                              LOWER(visitante) AS visitante,
                                              marcadorLocal,
                                              marcadorVisitante,
                                              DATE_FORMAT(fecha,'%d %M') AS fecha,
                                              LOWER((SELECT nombre FROM selecciones WHERE partidos.local = selecciones.id )) AS nombreLocal,
                                              LOWER((SELECT nombre FROM selecciones WHERE partidos.visitante = selecciones.id )) AS nombreVisitante
											FROM partidos WHERE id = ?");
			$stm->execute(array($idPartido));

			$this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            
            return $this->response;
		}
		catch(Exception $e)
		{
			$this->response->setResponse(false, $e->getMessage());
            return $this->response;
		}  
    }



    public function Resultados($email)
    {
        try
        {
            $result = array();
            $this->db->query("SET lc_time_names = 'es_ES';");
            $stm = $this->db->prepare("SELECT id,
                                            fase,
                                              LOWER(local) AS local,
                                              LOWER(visitante) AS visitante,
                                              marcadorLocal,
                                              marcadorVisitante,
                                              DATE_FORMAT(fecha,'%d %M') AS fecha,
                                              LOWER((SELECT nombre FROM selecciones WHERE partidos.local = selecciones.id )) AS nombreLocal,
                                              LOWER((SELECT nombre FROM selecciones WHERE partidos.visitante = selecciones.id )) AS nombreVisitante,
                                              (IFNULL((SELECT marcadorLocal FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ?),-1) ) AS prediccionLocal,
                                            (IFNULL((SELECT marcadorVisitante FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ?),-1) ) AS prediccionVisitante
                                            FROM $this->tablePartidos WHERE jugado = 1 ORDER BY id ASC");
            $stm->execute(array($email,$email));

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }  
    }

    public function savePrediccion($email,$data){
        if($data->local != ""){
            try
            {
                $stmd = $this->db->prepare("SELECT (fecha > NOW()) AS habilitado FROM $this->tablePartidos WHERE id = ?");
                $stmd->execute(array($data->id));
                $check = $stmd->fetch();
                if(intval($check->habilitado) > 0){
                    $stm = $this->db->prepare("SELECT * FROM $this->tablePredicciones WHERE email = ? AND idPartido = ?");
                    $stm->execute(array($email,$data->id));

                    $this->response->setResponse(true);
                    if($stm->fetch()){
                        $stm = $this->db->prepare("UPDATE predicciones SET marcadorLocal=?, marcadorVisitante = ? WHERE email=? AND idPartido = ?");
                        $stm->execute(array($data->local,$data->visitante,$email,$data->id));
                    }else{
                        $stm = $this->db->prepare("INSERT INTO predicciones (email,idPartido, marcadorLocal, marcadorVisitante) VALUES(?,?,?,?)");
                        $stm->execute(array($email,$data->id,$data->local,$data->visitante));
                    }
                    
                    $this->response;
                } 
            }
            catch(Exception $e)
            {
                $this->response->setResponse(false, $e->getMessage());
                return $this->response;
            }
        }
    }

    public function saveMessege($email,$message){
        try
            {
            	$message = htmlemoji($message);
                $stm = $this->db->prepare("INSERT INTO mensajeria (email,fecha, mensaje) VALUES(?,NOW(),?)");
                $stm->execute(array($email,$message));

                $this->response;
            }
            catch(Exception $e)
            {
                $this->response->setResponse(false, $e->getMessage());
                return $this->response;
            }
    }

    public function getAllUserActives()
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT * FROM $this->tableUser where activo = 1");
            $stm->execute();
            
            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
    
    public function getScoreUser($email){
        try
        {
            $score = 0;
            $result = array();

            $stm = $this->db->prepare("SELECT id,
                                      grupo,
                                      LOWER(local) AS local,
                                      LOWER(visitante) AS visitante,
                                      marcadorLocal,
                                      marcadorVisitante,
                                      (SELECT nombre FROM selecciones WHERE partidos.local = selecciones.id ) AS nombreLocal,
                                      (SELECT nombre FROM selecciones WHERE partidos.visitante = selecciones.id ) AS nombreVisitante,
                                      (SELECT marcadorLocal FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ? ) AS prediccionLocal,
                                    (SELECT marcadorVisitante FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ? ) AS prediccionVisitante
                                    FROM $this->tablePartidos WHERE jugado = 1");

            $stm->execute(array($email,$email));
            
            $this->response->setResponse(true);

            foreach ($stm->fetchAll() as $partido) {
            
            if(!is_null($partido->prediccionLocal) && !is_null($partido->prediccionVisitante)){
            	
	              if((intval($partido->marcadorLocal) == intval($partido->prediccionLocal)) && (intval($partido->marcadorVisitante) == intval($partido->prediccionVisitante))){
	                $score += 2;
	              }
	              else if ((intval($partido->marcadorLocal) > intval($partido->marcadorVisitante)) && (intval($partido->prediccionLocal) > intval($partido->prediccionVisitante))){
	                $score += 1;
	              }
	              else if ((intval($partido->marcadorLocal) < intval($partido->marcadorVisitante)) && (intval($partido->prediccionLocal) < intval($partido->prediccionVisitante))){
	                $score += 1;
	              }
	              else if ((intval($partido->marcadorLocal) == intval($partido->marcadorVisitante)) && (intval($partido->prediccionLocal) == intval($partido->prediccionVisitante))){
	                $score += 1;
	              }
              }
            }
            
            return $score;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

     public function getStatUser($email){
        try
        {
            $goles = 0;
            $resultados = 0;
            $partidos = 0;
            $result = array();

            $stm = $this->db->prepare("SELECT id,
                                      marcadorLocal,
                                      marcadorVisitante,
                                      (SELECT nombre FROM selecciones WHERE partidos.local = selecciones.id ) AS nombreLocal,
                                      (SELECT nombre FROM selecciones WHERE partidos.visitante = selecciones.id ) AS nombreVisitante,
                                      (SELECT marcadorLocal FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ? ) AS prediccionLocal,
                                    (SELECT marcadorVisitante FROM predicciones WHERE partidos.id = predicciones.idPartido AND predicciones.email = ? ) AS prediccionVisitante
                                    FROM $this->tablePartidos WHERE jugado = 1");

            $stm->execute(array($email,$email));
            
            $this->response->setResponse(true);

            $rs = $stm->fetchAll();

            $partidos = count($rs);

            foreach ($rs as $partido) {
	            if(!is_null($partido->prediccionLocal) && !is_null($partido->prediccionVisitante)){
		              if((intval($partido->marcadorLocal) == intval($partido->prediccionLocal)) && (intval($partido->marcadorVisitante) == intval($partido->prediccionVisitante))){
		                $goles += 1;
		                $resultados += 1;
		              }

		              else if ((intval($partido->marcadorLocal) > intval($partido->marcadorVisitante)) && (intval($partido->prediccionLocal) > intval($partido->prediccionVisitante))){
		                $resultados += 1;
		              }

		              else if ((intval($partido->marcadorLocal) < intval($partido->marcadorVisitante)) && (intval($partido->prediccionLocal) < intval($partido->prediccionVisitante))){
		                $resultados += 1;

		              }

		              else if ((intval($partido->marcadorLocal) == intval($partido->marcadorVisitante)) && (intval($partido->prediccionLocal) == intval($partido->prediccionVisitante))){
		                $resultados += 1;
		              }
	          	}
            }
            
            return array('partidos'=>$partidos,'goles'=>$goles,'resultados'=>$resultados);
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function GetNews(){
        try
        {
            $result = array();
            $this->db->query("SET lc_time_names = 'es_ES';");
            $stm = $this->db->prepare("SELECT DATE_FORMAT(fecha,'%d %M') AS fecha, foto, titulo, texto FROM $this->tableNews ORDER BY id DESC");
            $stm->execute();
            
            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function GetMessages(){
        try
        {
            $result = array();
            $this->db->query("SET lc_time_names = 'es_ES';");
            $stm = $this->db->prepare("SELECT mensajeria.email, DATE_FORMAT(mensajeria.fecha,'%d %M %H:%i') AS fecha, mensajeria.fecha AS idmsg,  mensajeria.mensaje, usuarios.nombre FROM $this->tableMessages INNER JOIN $this->tableUser ON mensajeria.email = usuarios.email ORDER BY mensajeria.id ASC");
            $stm->execute();
            
            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            
            return $this->response;
        }
        catch(Exception $e)
        {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function unreadMesseges($date){
    	$result = array();
    	$stm = $this->db->prepare("SELECT count(id) AS notifications FROM $this->tableMessages WHERE fecha > ?");
        $stm->execute(array($date));

        $this->response->setResponse(true);
        $this->response->result = $stm->fetch();
            
        return $this->response;

    }


}