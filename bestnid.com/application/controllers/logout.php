<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
	}

	function index() {
		$this->session->sess_destroy();
		redirect(base_url(index_page().'/index'));
	}
}

?>