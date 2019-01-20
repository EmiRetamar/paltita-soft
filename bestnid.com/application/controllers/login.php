<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('login_model');
		$this->load->model('listar_subastas_model');
	}

	function index() {
		if(!isset($this->session->userdata['login'])) {
			$this->load->view('login_view');
		}
		else {
			redirect(base_url(index_page().'/index'));
		}
	}

	function verificar_datos() {
		// Obtengo los datos ingresados en los inputs mediante el metodo post
		$datos = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
			);
		/* Se realiza un llamado a una funcion del model para obtener la consulta,
		solo con el email es suficiente para conseguir los datos del usuario ya que
		este campo es unico y no puede repetirse */
		$query = $this->login_model->buscarUsuario($datos['email']); // La consulta retorna un objeto de tipo query lo cual tiene sus propias funciones o metodos
		if($query) {
			/* Obtengo la tupla correspondiente al email del usuario en cuestion (como el email no puede repetirse, la consulta solo retorna una sola tupla) */
			$usuario = $query->result(); // result() es una funcion del objeto query que devuelve un arreglo de tuplas (en este caso devuelve una sola tupla)
			if($usuario[0]->activo == true) {
				if($usuario[0]->password == $datos['password']) { // $usuario[0] accede a la primera tupla del arreglo y ->password accede al valor que se encuentra en el campo password
					$user = array('email' => $usuario[0]->email,
						'nombre' => $usuario[0]->nombre,
						'apellido' => $usuario[0]->apellido,
						'idUsuario' => $usuario[0]->idUsuario,
						'userAdmin' => $usuario[0]->userAdmin,
						'login' => true);
					$this->session->set_userdata($user);
					redirect(base_url(index_page().'/index'));
				}
				else {
					$mensaje['datos_error'] = 'Los datos ingresados son incorrectos';
					$this->load->view('login_view', $mensaje);
				}
			}
			else {
				$mensaje['cuenta_desactivada'] = 'No se pudo iniciar sesión debido a que su cuenta se encuentra desactivada';
				$this->load->view('login_view', $mensaje);
			}
		}
		else {
			$mensaje['datos_error'] = 'Los datos ingresados son incorrectos';
			$this->load->view('login_view', $mensaje);	
		}
	}
}

?>