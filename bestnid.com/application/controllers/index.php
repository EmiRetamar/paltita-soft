<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('session');
		$this->load->model('subasta_model');
		$this->load->model('listar_subastas_model');
	}

	function index() {
		if(isset($this->session->userdata['login'])) {
			$idUsuario = $this->session->userdata['idUsuario'];
			$datos['notificacionGanador'] = $this->subasta_model->verificarSubastasGanadas($idUsuario);
			$datos['notificacionFinalizadas'] = $this->subasta_model->verificarSubastasFinalizadas($idUsuario);
		}
		$datos['subastas'] = $this->listar_subastas_model->obtenerSubastas(); // En $datos['subastas'] se guarda el resultado de la consulta que genera obtenerSubastas()
		$this->load->view('index_view', $datos);
	}

}

?>