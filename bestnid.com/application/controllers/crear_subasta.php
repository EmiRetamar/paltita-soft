<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crear_subasta extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->library('session');
        $this->load->model('categorias_model');
        $this->load->model('subasta_model');
    }

    function index() {
    	if(isset($this->session->userdata['login'])) {
    		$datos['categorias'] = $this->categorias_model->obtenerCategorias();
        	$this->load->view('crear_subasta_view', $datos);
        }
        else {
        	redirect(base_url(index_page().'/login'));
        }
    }

	function agregarSubasta() {
    	$formato = '%Y-%m-%d';
    	$fechaActual = mdate($formato);
    	$cantDias = $this->input->post('cantDias');
    	$nuevafecha = strtotime ('+'.$cantDias.' day', strtotime($fechaActual));
    	$fechaFin = date('Y-m-d', $nuevafecha);
    	$datos = array(
			'nombreSubasta' => $this->input->post('nombreSubasta'),
			'descripcion' => $this->input->post('descripcion'),
			'idUsuario' => $this->session->userdata('idUsuario'),
			'idCategoria' => $this->input->post('categoria'),
			'fechaInicio' => $fechaActual,
			'fechaFin' => $fechaFin,
			'nombreImagen' => $this->input->post('userfile')
			);
    	$nombreImagen = date('dmYHis').'.jpg';
		$config['upload_path'] = FCPATH.'images';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= 10*1024;
		$config['max_width']  = '5000';
		$config['max_height']  = '5000';
		$config['file_name']  = $nombreImagen;
		$this->load->library('upload', $config);
		if($this->upload->do_upload()) {
			$datos['nombreImagen'] = $nombreImagen;
			$this->subasta_model->agregarSubasta($datos);
			$this->session->set_userdata(array('subastaCreada' => true));
			redirect(base_url(index_page().'/index'));
		}
		else {
			print "<script type=\"text/javascript\">alert('Archivo inválido. Por favor, seleccione una imagen');</script>";
			$datos['categorias'] = $this->categorias_model->obtenerCategorias();
			$this->load->view('crear_subasta_view', $datos);
		}
	}

}

?>