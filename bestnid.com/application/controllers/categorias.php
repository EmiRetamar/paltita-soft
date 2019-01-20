<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Categorias extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('session');
		$this->load->model('categorias_model');
	}

	function index() {
		$datos['categorias'] = $this->categorias_model->obtenerCategorias();
		if($datos['categorias']) {
			$this->load->view('categorias_view', $datos);
		}
	}

	function listado() {
		$idCategoria = $this->input->get('id');
		$datos['categoria'] = $this->categorias_model->obtenerCategoriaPorId($idCategoria);
		$datos['subastas'] = $this->categorias_model->obtenerSubastasCategoria($idCategoria);
		$this->load->view('listado_categoria_view', $datos);	
	}
	
}

?>