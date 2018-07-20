<?php
//extendemos CI_Model
class Novedades_model extends CI_Model{
    public function __construct() {
        //llamamos al constructor de la clase padre
        parent::__construct(); 
         
        //cargamos la base de datos
        $this->load->database();
    }
     
    public function ver(){
        //Hacemos una consulta
        $consulta=$this->db->query("SELECT * FROM noticias;");
         
        //Devolvemos el resultado de la consulta
        return $consulta->result();
    }
     
    public function add($foto,$titulo,$texto){
      $consulta=$this->db->query("INSERT INTO noticias (fecha,foto,titulo,texto) VALUES (NOW(),'$foto','$titulo','$texto');");
      if($consulta==true){
        return true;
      }else{
          return false;
      }
    }
     
    public function mod($id_usuario,$modificar="NULL",$email="NULL",$nombre="NULL"){
        if($modificar=="NULL"){
            $consulta=$this->db->query("SELECT * FROM usuarios WHERE id=$id_usuario");
            return $consulta->result();
        }else{
          $consulta=$this->db->query("
              UPDATE usuarios SET email='$email', nombre='$nombre' WHERE id=$id_usuario;
                  ");
          if($consulta==true){
              return true;
          }else{
              return false;
          }
        }
    }
     
    public function eliminar($id_usuario){
       $consulta=$this->db->query("DELETE FROM usuarios WHERE id=$id_usuario");
       if($consulta==true){
           return true;
       }else{
           return false;
       }
    }
 
 
}
?>