<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Subasta extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->model('categorias_model');
		$this->load->model('subasta_model');
	}

	function index() {
		$idSubasta = $this->input->get('idSubasta');
		$datos['subasta'] = $this->subasta_model->obtenerSubastaPorId($idSubasta);
		$datos['comentarios'] = $this->subasta_model->obtenerComentarios($idSubasta);
		$datos['ofertas'] = $this->subasta_model->obtenerOfertas($idSubasta);
		$datos['categoria'] = $this->subasta_model->obtenerCategoriaPorId($idSubasta);
		if(isset($this->session->userdata['login'])) {
			$datos['ofertaDelUsuario'] = $this->subasta_model->obtenerOfertaDelUsuario($this->session->userdata('idUsuario'), $idSubasta);
			if($datos['ofertaDelUsuario']) {
				$datos['oferto'] = true;
			}
			else {
				$datos['oferto'] = false;
			}
		}
		$this->load->view('subasta_view', $datos);
	}
	
	function agregarOferta() {
		$datos = array(
			'argumento' => $this->input->post('argumento'),
			'monto' => $this->input->post('monto'),
			'idUsuario' => $this->session->userdata('idUsuario'),
			'idSubasta' => $this->input->get('idSubasta')
			);
		$this->subasta_model->agregarOferta($datos);
		redirect(base_url(index_page().'/subasta?idSubasta='.$datos['idSubasta']));
	}

	function modificarOferta() {
		$datos = array(
			'argumento' => $this->input->post('argumento'),
			'monto' => $this->input->post('monto'),
			'idUsuario' => $this->session->userdata('idUsuario'),
			'idSubasta' => $this->input->get('idSubasta')
			);
		$this->subasta_model->modificarOferta($datos);
		redirect(base_url(index_page().'/subasta?idSubasta='.$datos['idSubasta']));
	}

	function comentario() {
		$datos = array(
			'texto' => $this->input->post('comentario'),
			'idUsuario' => $this->session->userdata['idUsuario'],
			'idSubasta' => $this->input->get('idSubasta'),
			'fecha' => mdate('%Y-%m-%d'),
			'hora' => time()
			);
		$this->subasta_model->agregarComentario($datos);
		redirect(base_url(index_page().'/subasta?idSubasta='.$datos['idSubasta']));
	}

	function respuesta() {
		$datos['idSubasta'] = $this->input->get('idSubasta');
		$datos['idComentario'] = $this->input->get('idComentario');
		$datos['respuesta'] = $this->input->post('respuesta'.$datos['idComentario']);
		$this->subasta_model->agregarRespuesta($datos['respuesta'], $datos['idComentario']); 
		redirect(base_url(index_page().'/subasta?idSubasta='.$datos['idSubasta']));
	}

	function modificar_subasta() {
		$idSubasta = $this->input->get('idSubasta');
		$datos['subasta'] = $this->subasta_model->obtenerSubastaPorId($idSubasta);
		$datos['categorias'] = $this->categorias_model->obtenerCategorias();
		$this->load->view('modificar_subasta_view', $datos);
	}

	function actualizarDatosSubasta() {
    	$subasta = array(
    		'idSubasta' => $this->input->get('idSubasta'),
			'nombreSubasta' => $this->input->post('nombreSubasta'),
			'descripcion' => $this->input->post('descripcion'),
			'idCategoria' => $this->input->post('categoria'),
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
			$subasta['nombreImagen'] = $nombreImagen;
			$this->subasta_model->modificarSubasta($subasta);
			$this->session->set_userdata(array('subastaModificada' => true));
    		redirect(base_url(index_page().'/index'));
		}
		else {
			print "<script type=\"text/javascript\">alert('Archivo inválido. Por favor, seleccione una imagen');</script>"; 
			$datos['subasta'] = $this->subasta_model->obtenerSubastaPorId($subasta['idSubasta']);
			$datos['categorias'] = $this->categorias_model->obtenerCategorias();
			$this->load->view('modificar_subasta_view', $datos);
		}
	}

	function eliminarSubasta() {
		$idSubasta = $this->input->get('idSubasta');
		$this->subasta_model->eliminarSubasta($idSubasta);
		redirect(base_url(index_page().'/index'));
	}

	function eliminarComentario() {
		$idSubasta = $this->input->get('idSubasta');
		$idComentario = $this->input->get('idComentario');
		$this->subasta_model->eliminarComentario($idComentario);
		redirect(base_url(index_page().'/subasta?idSubasta='.$idSubasta));
	}

}

?>