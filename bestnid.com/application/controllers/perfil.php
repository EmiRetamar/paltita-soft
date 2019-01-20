<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Perfil extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->library('session');
        $this->load->model('perfil_model');
    }

    function index() {
        if(isset($this->session->userdata['login'])) {
            $idUsuario = $this->session->userdata('idUsuario');
            $datos['subastasPublicadas'] = $this->perfil_model->verificarSubastasPublicadas($idUsuario); // Retorna las subastas publicadas vigentes del usuario actualmente logueado
            $datos['subastasOfertadas'] =  $this->perfil_model->verificarSubastasOfertadas($idUsuario); // Retorna las subastas vigentes con la oferta correspondiente del usuario actualmente logueado
            $this->session->set_userdata($datos);
            $this->load->view('perfil_view', $datos);
        }
        else {
            redirect(base_url(index_page().'/login'));
        }
    }

    function informacion() {
        $datos['opcion'] = 'informacion_personal';
        $idUsuario = $this->session->userdata('idUsuario');
        $datos['usuario'] = $this->perfil_model->obtenerUsuario($idUsuario);
        $this->load->view('perfil_view', $datos);
    }

    function subastas_vigentes() {
        $datos['opcion'] = 'subastas_vigentes';
        $idUsuario = $this->session->userdata('idUsuario');
        $datos['subastasVigentes'] = $this->perfil_model->obtenerSubastasVigentes($idUsuario); // Retorna las subastas publicadas vigentes del usuario actualmente logueado
        $this->load->view('perfil_view', $datos);
    }

    function subastas_finalizadas() {
        $datos['opcion'] = 'subastas_finalizadas';
        $idUsuario = $this->session->userdata('idUsuario');
        $datos['subastasFinalizadas'] = $this->perfil_model->obtenerSubastasFinalizadas($idUsuario);
        $datos['subastasVendidas'] = $this->perfil_model->obtenerSubastasVendidas($idUsuario);
        $this->load->view('perfil_view', $datos);
    }

    function elegir_ganador() {
        $datos['opcion'] = 'elegir_ganador';
        $idSubasta = $this->input->get('idSubasta');
        $datos['ofertas'] = $this->perfil_model->obtenerOfertas($idSubasta);
        $this->load->view('perfil_view', $datos);
    }

    function guardarGanador() {
        $idSubasta = $this->input->get('idSubasta');
        $idUsuario = $this->input->get('idUsuario');
        $this->perfil_model->guardarGanador($idSubasta, $idUsuario);
        redirect(base_url(index_page().'/perfil'));
    }

    function ofertas_pendientes() {
        $datos['opcion'] = 'ofertas_pendientes';
        $idUsuario = $this->session->userdata('idUsuario');
        $datos['ofertasPendientes'] = $this->perfil_model->obtenerOfertasPendientes($idUsuario);
        $this->load->view('perfil_view', $datos);
    }

    function ofertas_ganadas() {
        $datos['opcion'] = 'ofertas_ganadas';
        $idUsuario = $this->session->userdata('idUsuario');
        $datos['ofertasGanadas'] = $this->perfil_model->obtenerOfertasGanadas($idUsuario);
        $this->load->view('perfil_view', $datos);
    }

    function ofertas_perdidas() {
        $datos['opcion'] = 'ofertas_perdidas';
        $idUsuario = $this->session->userdata('idUsuario');
        $datos['ofertasPerdidas'] = $this->perfil_model->obtenerOfertasPerdidas($idUsuario);
        $this->load->view('perfil_view', $datos);
    }

    function pagarSubasta() {
        $idSubasta = $this->input->get('idSubasta');
        $this->perfil_model->pagarSubasta($idSubasta);
        redirect(base_url(index_page().'/perfil/ofertas_ganadas'));
    }

    function modificar_datos_personales() {
        $datos['opcion'] = 'modificar_datos_personales';
        $idUsuario = $this->session->userdata('idUsuario');
        $datos['usuario'] = $this->perfil_model->obtenerUsuario($idUsuario);
        $this->load->view('perfil_view', $datos);
    }

    function verificar_datos() {
        $idUsuario = $this->session->userdata('idUsuario');
        $datos = array(
            'email' => $this->input->post('email'),
            'DNI' => $this->input->post('DNI'),
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'direccion' => $this->input->post('direccion'),
            'telefono' => $this->input->post('telefono')
            );
        $existeEmail = $this->perfil_model->verificarEmail($idUsuario, $datos['email']);
        $existeDNI = $this->perfil_model->verificarDNI($idUsuario, $datos['DNI']);
        if(!$existeEmail && !$existeDNI) {
            $this->perfil_model->modificarDatosPersonales($idUsuario, $datos);
            $user = array(
                'email' => $datos['email'],
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],   
                'idUsuario' => $idUsuario,
                'login' => true);
            $this->session->set_userdata($user); // Se actualizan los datos de la sesion
            $datos['datos_modificados'] = true;
            $this->load->view('perfil_view', $datos);
        }
        else {
            $datos['opcion'] = 'modificar_datos_personales';
            $datos['usuario'] = $this->perfil_model->obtenerUsuario($idUsuario);
            if($existeEmail && $existeDNI) { // Si existe Email y DNI en la base de datos informa un error diciendo que existen ambos
                $datos['datos_error'] = 'No es posible modificar el Email y el DNI debido a que ya existen en el sistema';
                $this->load->view('perfil_view', $datos);
            }
            else {
                if($existeEmail) { // Si existe el email lo informa
                    $datos['datos_error'] = 'No es posible modificar el Email debido a que ya existe en el sistema';
                    $this->load->view('perfil_view', $datos);
                }
                else { // Caso contrario, si existe DNI lo informa
                    $datos['datos_error'] = 'No es posible modificar el DNI debido a que ya existe en el sistema';
                    $this->load->view('perfil_view', $datos);
                }
            }
        }
    }

    function cambiar_password() {
        $datos['opcion'] = 'cambiar_contraseña';
        $this->load->view('perfil_view', $datos);
    }

    function verificar_passwords() {
        $idUsuario = $this->session->userdata('idUsuario');
        $datos = array(
            'passwordActual' => $this->input->post('password1'),
            'passwordNuevo' => $this->input->post('password2'),
            'passwordNuevo2' => $this->input->post('password3')
            );
        $coincidePassActual = $this->perfil_model->verificarPasswordActual($idUsuario, $datos['passwordActual']);
        $coincidePassNueva = ($datos['passwordNuevo'] == $datos['passwordNuevo2']);
        if($coincidePassActual && $coincidePassNueva) {
            $this->perfil_model->cambiarPassword($idUsuario, $datos['passwordNuevo']);
            $datos['password_cambiado'] = true;
            $this->load->view('perfil_view', $datos);
        }
        else {
            if(!$coincidePassActual) {
                $datos['opcion'] = 'cambiar_contraseña';
                $datos['datos_error'] = 'La contraseña actual ingresada es incorrecta';
                $this->load->view('perfil_view', $datos);
            }
            else {
                $datos['opcion'] = 'cambiar_contraseña';
                $datos['datos_error'] = 'Las contraseñas nuevas no coinciden';
                $this->load->view('perfil_view', $datos);
            }
        }
    }

    function desactivarCuenta() {
        $idUsuario = $this->session->userdata('idUsuario');
        $this->perfil_model->desactivarCuenta($idUsuario);
        redirect(base_url(index_page().'/logout'));
    }

}

?>