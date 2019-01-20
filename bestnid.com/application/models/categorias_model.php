<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categorias_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	function obtenerCategorias() {
		$this->db->where('eliminada', false); // Trae las categorias que no estan eliminadas
		$this->db->order_by('nombreCategoria', 'asc');
		$query = $this->db->get('categoria');
		if($query->num_rows() > 0) {
			return ($query);
		}
		else {
			return (false);
		}
	}

	function obtenerSubastasCategoria($idCategoria) {
		$formato = "%Y-%m-%d";
		$fechaActual = mdate($formato); // mdate retorna la fecha actual con el formato especificado
		$this->db->from('categoria');
		$this->db->join('subasta', 'subasta.idCategoria = categoria.idCategoria');
		$this->db->where('subasta.idCategoria', $idCategoria);
		$this->db->where('fechaFin >', $fechaActual);
		$this->db->order_by('fechaFin', 'asc'); // Ordena las subastas de forma ascendente (por fecha de vencimiento, de las que estas mas proximas a vencer a las que estan mas lejanas a vencer)
		$query = $this->db->get();
		if($query->num_rows > 0) {
			return ($query);
		}
		else {
			return (false);
		}
	}

	function obtenerCategoriaPorId($idCategoria) {
		$this->db->where('idCategoria', $idCategoria);
		$query = $this->db->get('categoria');
		return ($query->result());
	}

}

?>