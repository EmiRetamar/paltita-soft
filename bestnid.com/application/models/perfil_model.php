<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Perfil_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	function verificarSubastasPublicadas($idUsuario) {
		$formato = "%Y-%m-%d";
		$fechaActual = mdate($formato); // mdate retorna la fecha actual con el formato especificado
		$this->db->where('idUsuario', $idUsuario);
		$this->db->where('fechaFin >', $fechaActual);
		$this->db->order_by('fechaFin', 'asc'); // Ordena las subastas de forma ascendente (por fecha de vencimiento, de las que estas mas proximas a vencer a las que estan mas lejanas a vencer)
		$query = $this->db->get('subasta'); // En $query almacena el resultado de la consulta
		if($query->num_rows() > 0)
			return (true);
		else
			return (false);
	}

	function verificarSubastasOfertadas($idUsuario) { // La diferencia con obtenerOfertasPendientes es que esta funcion solo retorna ofertas de subastas vigentes, esto sirve para desactivar la cuenta en caso de que el usuario no tenga ofertas en subastas vigentes puede desactivarla
		$formato = "%Y-%m-%d";
		$fechaActual = mdate($formato);
		$this->db->from('subasta');
		$this->db->join('oferta', 'subasta.idSubasta = oferta.idSubasta');
		$this->db->where('oferta.idUsuario', $idUsuario);
		$this->db->where('subasta.fechaFin >', $fechaActual);
		$this->db->order_by('subasta.fechaFin', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return (true);
		else
			return (false);
	}

	function obtenerUsuario($idUsuario) {
		$this->db->where('idUsuario', $idUsuario);
		$query = $this->db->get('usuario');
		if($query->num_rows() > 0)
			return ($query->result());
		else
			return (false);
	}

	function obtenerSubastasVigentes($idUsuario) {
		$formato = "%Y-%m-%d";
		$fechaActual = mdate($formato); // mdate retorna la fecha actual con el formato especificado
		$this->db->where('idUsuario', $idUsuario);
		$this->db->where('fechaFin >', $fechaActual);
		$this->db->order_by('fechaFin', 'asc'); // Ordena las subastas de forma ascendente (por fecha de vencimiento, de las que estas mas proximas a vencer a las que estan mas lejanas a vencer)
		$query = $this->db->get('subasta'); // En $query almacena el resultado de la consulta
		if($query->num_rows() > 0)
			return ($query);
		else
			return (false);
	}

	function obtenerSubastasFinalizadas($idUsuario) {
		$formato = "%Y-%m-%d";
		$fechaActual = mdate($formato); // mdate retorna la fecha actual con el formato especificado
		$this->db->where('idUsuario', $idUsuario);
		$this->db->where('fechaFin <=', $fechaActual);
		$this->db->order_by('fechaFin', 'desc'); // Ordena las subastas de forma descendente (por fecha de vencimiento, de las que vencieron mas recientes a las menos recientes)
		$query = $this->db->get('subasta');
		if($query->num_rows() > 0)
			return ($query);
		else
			return (false);
	}

	function obtenerSubastasVendidas($idUsuario) { // Devuelve las subastas vendidas por el usuario con su respectiva oferta
		$formato = "%Y-%m-%d";
		$fechaActual = mdate($formato);
		$query = $this->db->query("select * from subasta inner join oferta on (subasta.ganador = oferta.idUsuario) where subasta.pagada != 0 and subasta.idSubasta = oferta.idSubasta and subasta.idUsuario =".$idUsuario);
		/*$this->db->from('subasta');
		$this->db->join('oferta', 'subasta.idSubasta = oferta.idSubasta');
		$this->db->where('fechaFin <=', $fechaActual);
		$this->db->where('subasta.idUsuario', $idUsuario);
		$this->db->where('ganador <>', 'NULL');
		$this->db->where('pagada', '1');
		$this->db->order_by('fechaFin', 'desc');
		$query = $this->db->get();*/
		if($query->num_rows() > 0) {
			return ($query->result());
		}
		else {
			return (false);
		}
	}

	function obtenerOfertas($idSubasta) {
		$this->db->where('idSubasta', $idSubasta);
		$query = $this->db->get('oferta');
		if($query->num_rows() > 0)
			return ($query);
		else
			return (false);
	}

	function guardarGanador($idSubasta, $idUsuario) {
		$this->db->where('idSubasta', $idSubasta);
		$this->db->update('subasta', array('ganador' => $idUsuario));
	}

	function obtenerOfertasPendientes($idUsuario) { // Trae todas las ofertas del usuario y en la vista se cargan solo las que no tengan ganador (pueden estar vigentes, o finalizadas esperando a que se seleccione un ganador)
		$this->db->from('subasta');
		$this->db->join('oferta', 'subasta.idSubasta = oferta.idSubasta');
		$this->db->where('oferta.idUsuario', $idUsuario);
		$this->db->where('ganador', null);
		$this->db->order_by('subasta.fechaFin', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return ($query);
		else
			return (false);
	}

	function obtenerOfertasGanadas($idUsuario) { // Trae las subastas ganadas por el usuario con su respectiva oferta y su subastador
		$fechaActual = mdate("%Y-%m-%d");
		$this->db->from('subasta');
		$this->db->join('oferta', 'subasta.idSubasta = oferta.idSubasta');
		$this->db->join('usuario', 'subasta.idUsuario = usuario.idUsuario');
		$this->db->where('oferta.idUsuario', $idUsuario);
		$this->db->where('subasta.ganador', $idUsuario);
		$this->db->where('subasta.fechaFin <=', $fechaActual);
		$this->db->order_by('subasta.fechaFin', 'desc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return ($query);
		else
			return (false);
	}

	function obtenerOfertasPerdidas($idUsuario) { // Trae las subastas perdidas por el usuario con su respectiva oferta
		$fechaActual = mdate("%Y-%m-%d");
		$this->db->from('subasta');
		$this->db->join('oferta', 'subasta.idSubasta = oferta.idSubasta');
		$this->db->where('oferta.idUsuario', $idUsuario);
		$this->db->where('subasta.ganador <>', 'NULL');
		$this->db->where('subasta.ganador <>', $idUsuario);
		$this->db->where('subasta.fechaFin <=', $fechaActual);
		$this->db->order_by('subasta.fechaFin', 'desc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return ($query);
		else
			return (false);
	}

	function pagarSubasta($idSubasta) {
		$this->db->where('idSubasta', $idSubasta);
		$this->db->update('subasta', array('pagada' => true));
	}

	function verificarEmail($idUsuario, $email) {
		$this->db->where('idUsuario <>', $idUsuario);
		$this->db->where('email', $email);
		$query = $this->db->get('usuario');
		if($query->num_rows() > 0) {
			return (true);
		}
		else {
			return (false);
		}
	}

	function verificarDNI($idUsuario, $DNI) {
		$this->db->where('idUsuario <>', $idUsuario);
		$this->db->where('DNI', $DNI);
		$query = $this->db->get('usuario');
		if($query->num_rows() > 0) {
			return (true);
		}
		else {
			return (false);
		}
	}

	function modificarDatosPersonales($idUsuario, $datosPersonales) {
		$this->db->where('idUsuario', $idUsuario);
		$this->db->update('usuario', $datosPersonales);
	}

	function verificarPasswordActual($idUsuario, $passwordActual) {
		$this->db->where('idUsuario', $idUsuario);
		$this->db->where('password', $passwordActual);
		$query = $this->db->get('usuario');
		if($query->num_rows() > 0) {
			return (true);
		}
		else {
			return (false);
		}
	}

	function cambiarPassword($idUsuario, $passwordNuevo) {
		$this->db->where('idUsuario', $idUsuario);
		$this->db->update('usuario', array('password' => $passwordNuevo));
	}

	function desactivarCuenta($idUsuario) {
		$this->db->where('idUsuario', $idUsuario);
		$this->db->update('usuario', array('activo' => false));
	}

}

?>