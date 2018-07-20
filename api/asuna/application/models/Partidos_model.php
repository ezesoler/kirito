<?php
//extendemos CI_Model
class Partidos_model extends CI_Model{
    public function __construct() {
        //llamamos al constructor de la clase padre
        parent::__construct(); 
         
        //cargamos la base de datos
        $this->load->database();
    }
     
    public function ver(){
        //Hacemos una consulta
        $consulta=$this->db->query("SELECT id,
                                              LOWER(local) AS local,
                                              LOWER(visitante) AS visitante,
                                              marcadorLocal,
                                              marcadorVisitante,
                                              jugado,
                                              DATE_FORMAT(fecha,'%d %M') AS fecha,
                                              (SELECT nombre FROM selecciones WHERE partidos.local = selecciones.id ) AS nombreLocal,
                                              (SELECT nombre FROM selecciones WHERE partidos.visitante = selecciones.id ) AS nombreVisitante
                                            FROM partidos ORDER BY fecha ASC");
         
        //Devolvemos el resultado de la consulta
        return $consulta->result();
    }
     
     
    public function mod($id_partido,$modificar="NULL",$marcadorLocal="NULL",$marcadorVisitante="NULL"){
    if($modificar=="NULL"){
    	$consulta=$this->db->query("SELECT id,
                                              LOWER(local) AS local,
                                              LOWER(visitante) AS visitante,
                                              marcadorLocal,
                                              marcadorVisitante,
                                              jugado,
                                              DATE_FORMAT(fecha,'%d %M') AS fecha,
                                              (SELECT nombre FROM selecciones WHERE partidos.local = selecciones.id ) AS nombreLocal,
                                              (SELECT nombre FROM selecciones WHERE partidos.visitante = selecciones.id ) AS nombreVisitante
                                            FROM partidos WHERE id = $id_partido");
        return $consulta->result();
    }else{
	      $consulta=$this->db->query("
	          UPDATE partidos SET marcadorLocal=$marcadorLocal, marcadorVisitante=$marcadorVisitante, jugado = 1 WHERE id=$id_partido;
	              ");
	      if($consulta==true){
	          return true;
	      }else{
	          return false;
	      }
  		}
    }
 
}
?>