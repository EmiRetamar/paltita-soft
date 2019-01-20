<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	function buscarUsuario($emailUser) {
		$this->db->where('email', $emailUser);
		$query = $this->db->get('usuario');
		if($query->num_rows() > 0)
			return ($query);
		else
			return (false);
	}
}

?>