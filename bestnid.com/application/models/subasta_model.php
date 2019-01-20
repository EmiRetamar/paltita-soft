<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subasta_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	function obtenerSubastaPorId($idSubasta) {
		$this->db->where('idSubasta', $idSubasta);
		$query = $this->db->get('subasta');
		if($query->num_rows() > 0) {
			return ($query->result());
		}
		else {
			return (false);
		}
	}

	function agregarSubasta($subasta) {
		$this->db->insert('subasta', $subasta);
	}

	function modificarSubasta($subasta) {
		$this->db->where('idSubasta', $subasta['idSubasta']);
		$this->db->update('subasta', array('nombreSubasta' => $subasta['nombreSubasta'], 'descripcion' => $subasta['descripcion'], 'idCategoria' => $subasta['idCategoria'], 'nombreImagen' => $subasta['nombreImagen']));
	}

	function verificarSubastasGanadas($idUsuario) {
		$this->db->where('ganador', $idUsuario);
		$this->db->where('pagada', false);
		$query = $this->db->get('subasta');
		if($query->num_rows() > 0) {
			return (true);
		}
		else {
			return (false);
		}
	}

	function verificarSubastasFinalizadas($idUsuario) {
		$fechaActual = mdate('%Y-%m-%d');
		$this->db->where('idUsuario', $idUsuario);
		$this->db->where('ganador', null); // Nose porque me deja poner null sin comillas aca y en otros lados no
		$this->db->where('fechaFin <=', $fechaActual);
		$query = $this->db->get('subasta');
		if($query->num_rows() > 0) {
			return (true);
		}
		else {
			return (false);
		}
	}

	function agregarOferta($oferta) {
		$this->db->insert('oferta', $oferta);
	}

	function modificarOferta($oferta) {
		$this->db->where('idUsuario', $oferta['idUsuario']);
		$this->db->where('idSubasta', $oferta['idSubasta']);
		$this->db->update('oferta', array('argumento' => $oferta['argumento'], 'monto' => $oferta['monto']));
	}

	function obtenerOfertaDelUsuario($idUsuario, $idSubasta) {
		$this->db->where('idUsuario', $idUsuario);
		$this->db->where('idSubasta', $idSubasta);
		$query = $this->db->get('oferta');
		if($query->num_rows() > 0) {
			return ($query->result());
		}
		else {
			return (false);
		}
	}
	
	function agregarComentario($datos) {
		$this->db->insert('comentario', $datos); 
	}

	function agregarRespuesta($respuesta, $idComentario) {
		$this->db->where('idComentario', $idComentario);
		$this->db->update('comentario', array('respuesta' => $respuesta)); 
	}

	function obtenerComentarios($idSubasta)  {
		$this->db->select('idComentario, texto, respuesta, comentario.idUsuario, comentario.idSubasta, fecha, hora');
		$this->db->from('comentario');
		$this->db->join('subasta', 'subasta.idSubasta = comentario.idSubasta');
		$this->db->where('subasta.idSubasta', $idSubasta);
		$query = $this->db->get();
		if($query->num_rows > 0) {
			return ($query);
		}
		else {
			return (false);
		}
	}

	function eliminarComentario($idComentario) {
		$this->db->where('idComentario', $idComentario);
		$this->db->delete('comentario');
	}

	function eliminarSubasta($idSubasta) {
		$this->db->where('idSubasta', $idSubasta);
		$this->db->delete('subasta');
	}

	function obtenerOfertas($idSubasta) {
		$this->db->from('subasta');
		$this->db->join('oferta', 'subasta.idSubasta = oferta.idSubasta');
		$this->db->where('subasta.idSubasta', $idSubasta);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return ($query->result());
		}
		else {
			return (false);
		}
	}

	function obtenerCategoriaPorId($idSubasta) {
		$this->db->from('categoria');
		$this->db->join('subasta', 'categoria.idCategoria = subasta.idCategoria');
		$this->db->where('idSubasta', $idSubasta);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return ($query->result());
		}
		else {
			return (false);
		}
	}

}

?>