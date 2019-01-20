<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Administrador extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('session');
		$this->load->model('categorias_model');
		$this->load->model('administrador_model');
	}

	function index() {
		if(isset($this->session->userdata['userAdmin']) && $this->session->userdata['userAdmin']) {
				$this->load->view('administrador_view');
		}
		else {
			redirect(base_url(index_page().'/index'));
		}
	}

	function consultar_usuarios() {
		$datos['opcion'] = 'consultar_usuarios';
		$datos['fechaActual'] = mdate('%Y-%m-%d');
		$this->load->view('administrador_view', $datos);
	}

	function usuarios_registrados() {
		$datos['fecha1'] = $this->input->post('fecha1');
		$datos['fecha2'] = $this->input->post('fecha2');
		if($datos['fecha1'] <= $datos['fecha2']) {
			$datos['opcion'] = 'usuarios_registrados';
			$datos['usuariosRegistrados'] = $this->administrador_model->obtenerUsuariosRegistrados($datos['fecha1'], $datos['fecha2']);
			$this->load->view('administrador_view', $datos);
		}
		else {
			$datos['opcion'] = 'consultar_usuarios';
			$datos['fechaActual'] = mdate('%Y-%m-%d');
			$datos['error'] = 'Los datos ingresados son incorrectos. La primera fecha debe ser menor o igual a la segunda';
			$this->load->view('administrador_view', $datos);
		}
	}

	function consultar_subastas() {
		$datos['opcion'] = 'consultar_subastas';
		$datos['fechaActual'] = mdate('%Y-%m-%d');
		$this->load->view('administrador_view', $datos);
	}

	function subastas_vendidas() {
		$datos['fecha1'] = $this->input->post('fecha1');
		$datos['fecha2'] = $this->input->post('fecha2');
		if($datos['fecha1'] <= $datos['fecha2']) {
			$datos['opcion'] = 'subastas_vendidas';
			$datos['subastadores'] = $this->administrador_model->obtenerSubastasVendidas($datos['fecha1'], $datos['fecha2']);
			$datos['ganadores'] = $this->administrador_model->obtenerOfertasGanadoras($datos['fecha1'], $datos['fecha2']);
			$this->load->view('administrador_view', $datos);
		}
		else {
			$datos['opcion'] = 'consultar_subastas';
			$datos['fechaActual'] = mdate('%Y-%m-%d');
			$datos['error'] = 'Los datos ingresados son incorrectos. La primera fecha debe ser menor o igual a la segunda';
			$this->load->view('administrador_view', $datos);
		}
	}

	function crear_categoria() {
		$datos['opcion'] = 'crear_categoria';
		$this->load->view('administrador_view', $datos);
	}

	function agregarCategoria() {
		$datos['nombreCategoria'] = $this->input->post('nombreCategoria');
		$datos['nombreImagen'] = date('dmYHis').'.jpg';
		$config['upload_path'] = FCPATH.'images';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= 10*1024;
		$config['max_width']  = '5000';
		$config['max_height']  = '5000';
		$config['file_name']  = $datos['nombreImagen'];
		$this->load->library('upload', $config);
		$existeNombreCategoria = $this->administrador_model->verificarNombreCategoria($datos['nombreCategoria']);
		if($existeNombreCategoria && $this->upload->do_upload()) {
			$this->administrador_model->agregarCategoria($datos);
			$this->session->set_userdata(array('categoriaCreada' => true));
			redirect(base_url(index_page().'/administrador'));
		}
		else {
			print "<script type=\"text/javascript\">alert('El nombre de categoria ya existe o el archivo es inválido. Por favor, elija uno válido');</script>"; 
			$datos['opcion'] = 'crear_categoria';
			$this->load->view('administrador_view', $datos);
		}
	}

	function eliminar_categoria() {
		$datos['opcion'] = 'eliminar_categoria';
		$datos['categorias'] = $this->categorias_model->obtenerCategorias();
		if($datos['categorias']) {
			$this->load->view('administrador_view', $datos);
		}
	}

	function eliminarDatosCategoria() {
		$idCategoria = $this->input->get('idCategoria');
		$this->administrador_model->eliminarCategoria($idCategoria);
		redirect(base_url(index_page().'/administrador'));
	}

}

?>