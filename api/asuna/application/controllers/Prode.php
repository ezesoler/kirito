<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Prode extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// Load database
		$this->load->model("Usuarios_model");
		$this->load->model("Partidos_model");
		$this->load->model("Novedades_model");
	}

	public function index()
	{
		if(isset($this->session->userdata['logged_in'])){
			$data["controller_name"] = "dashboard";
			$this->load->view('dashboard',$data);
		}else{
			$this->load->view('login_form');
		}
	}

	public function dashboard()
	{
		$data["controller_name"] = "dashboard";
		$this->load->view('dashboard',$data);
	}

	public function usuarios_list()
	{
		$usuarios["ver"]=$this->Usuarios_model->ver();
		$usuarios["controller_name"] = "usuarios";

		$this->load->view('usuarios_list',$usuarios);
	}

	public function partidos_list()
	{
		$partidos["ver"]=$this->Partidos_model->ver();
		$partidos["controller_name"] = "partidos";

		$this->load->view('partidos_list',$partidos);
	}

	public function novedades_list()
	{
		$novedades["ver"]=$this->Novedades_model->ver();
		$novedades["controller_name"] = "novedades";

		$this->load->view('novedades_list',$novedades);
	}

	 public function mod_partido($id_partido){
        if(is_numeric($id_partido)){
          $datos["mod"]=$this->Partidos_model->mod($id_partido);
          $datos["controller_name"] = "partidos";
          $this->load->view("partido_mod",$datos);
          if($this->input->post("submit")){
                $mod=$this->Partidos_model->mod(
                        $id_partido,
                        $this->input->post("submit"),
                        $this->input->post("marcadorLocal"),
                        $this->input->post("marcadorVisitante")
                        );
                if($mod==true){
                    //Sesion de una sola ejecución
                    $this->session->set_flashdata('correcto', 'Usuario modificado correctamente');
                }else{
                    $this->session->set_flashdata('incorrecto', 'Usuario modificado correctamente');
                }
                redirect(base_url('prode/partidos_list'));
            }
        }else{
            redirect(base_url()); 
        }
    }

	public function usuario_add()
	{
		$usuarios["controller_name"] = "usuarios";
		$this->load->view('usuario_add',$usuarios);
	}

	public function addUser(){
        $add = $this->Usuarios_model->add($this->input->post("email"));
    	if($add == true){
    		redirect(base_url('prode/usuarios_list'));
        }else{
        	die("Error");
        }
    }

    public function novedad_add()
	{
		$novedades["controller_name"] = "novedades";
		$this->load->view('novedad_add',$novedades);
	}

    public function addNovedad(){
        $add = $this->Novedades_model->add($this->input->post("foto"),$this->input->post("titulo"),$this->input->post("texto"));
    	if($add == true){
    		redirect(base_url('prode/novedades_list'));
        }else{
        	die("Error");
        }
    }

    public function notificaciones_send()
	{
		$data["usuarios"]=$this->Usuarios_model->ver();
		$data["controller_name"] = "notificaciones";

		$this->load->view('notificaciones_send',$data);
	}

	function sendNotificacion(){
		$mensaje = $this->input->post("texto");

	    $headers = [
	        'Authorization:key=AIzaSyCoa2f2DK3G2FoUDiYYOdEmvEEDLK8qQw0',
	        'Content-Type: application/json'
	    ];

	    $data = [
	        'to' => $this->input->post("destino"),
	        'android_channel_id' => 'kirito',
	        'data' => [
	            'type' => $this->input->post("tipo"),
	            'title' => 'Prode 2018',
	            'message' => $mensaje,
	            'image' => 'http://ezesoler.com/kirito/imgs/'.$this->input->post("icono")
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

	    redirect(base_url('prode/notificaciones_send'));
	}

	public function process(){
		$user = $this->input->post('user');
		$password = $this->input->post('password');
		if(($user == "kirito") && (hash('sha256', $password) == '4fcd6371b6e94d096bfe38ea1ee06c3511d5e6081ab8d063286c84e96a115bd5')){
			$session_data = array(
			'username' => $user
			);
			$this->session->set_userdata('logged_in', $session_data);
			redirect('/prode/dashboard');
		}else {
			$data = array(
			'error_message' => 'Usuario o Password Michetti'
			);
			$this->load->view('login_form', $data);
		}
	}
}
