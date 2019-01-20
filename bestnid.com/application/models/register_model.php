<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Register_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database(); // Se carga la base de datos configurada en el archivo config/database.php
	}

	function verificarEmail($email) {
		$this->db->where('email', $email);
		$query = $this->db->get('usuario');
		if($query->num_rows == 0) // Si no obtiene ningun resultado significa que el Email no esta registrado
			return (true);
		else
			return (false);
	}

	function verificarDNI($DNI) {
		$this->db->where('DNI', $DNI);
		$query = $this->db->get('usuario');
		if($query->num_rows == 0) // Si no obtiene ningun resultado significa que el DNI no esta registrado
			return (true);
		else
			return (false);
	}

	function agregarUsuario($usuario) {
		$this->db->insert('usuario', $usuario); 
	}

	function obtenerIdUsuario($email) {
		$this->db->where('email', $email);
		$query = $this->db->get('usuario');
		return ($query->result()[0]->idUsuario); // Devuelve el id del usuario
	}

}

?>