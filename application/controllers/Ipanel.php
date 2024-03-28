<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ipanel extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        // Carga el helper url
        $this->load->helper('url');
        $this->load->library('session');
    }

	public function index()
	{	
        if($this->session->userdata('usuario')):
            redirect('index.php/ipanel/dashboard');
        endif;

		// Carga la vista del panel de inicio
        $title = 'Login - Panel de control';
        $fecha_actual = date("dmY:H:i:s");
        $this->load->view('headers/header_admin', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('footers/footer_admin');
	}

    function verifySession() {
        if(!$this->session->userdata('usuario')):
            redirect('index.php/ipanel');
        endif;
    }

    function login() {
        $datos = array(
            'username' => $this->input->get('username'),
            'password' => $this->input->get('password')
        );

        $this->load->model('usuarios_model');

        $users = $this->usuarios_model->getUsers($datos);
        if($users):
            foreach($users as $user):
                if($datos['username'] == $user['usuario']):
                    if(password_verify($datos['password'], $user['clave'])):
                        $this->session->set_userdata('usuario', $user['usuario']);
                        $this->session->set_userdata('type', $user['tipusu']);
                        echo json_encode(true);
                        return;
                    endif;
                    
                    echo json_encode(false);
                    return;
                endif;
            endforeach;
        endif;
    }

    function dashboard(){
        $this->verifySession();
        $title = 'Dashboard - Panel de control';

        $this->load->model('productos_model');
        $datos = $this->productos_model->getCountCatSubCatPro();

        $catidades = array(
            'categorias' => $datos[0]['cantidad_catpadre'],
            'subcategorias' => $datos[0]['cantidad_categorias'],
            'productos' => $datos[0]['cantidad_productos'],
            'usuarios' => $datos[0]['cantidad_usuarios']
        );

        $this->load->view('admin/header/admin_header', array('title' => $title));
        $this->load->view('admin/setup/admin_menu');
        $this->load->view('admin/bodys/admin_dashboard', array('user' => $this->session->userdata('usuario'), 'cantidades' => $catidades));
        $this->load->view('admin/setup/admin_profile', array('user' => $this->session->userdata('usuario')));
        $this->load->view('admin/alerts/myAlerts');
        $this->load->view('admin/footer/admin_footer');
    }
    
    function store(){
        $this->verifySession();

        $title = 'Bodega - Panel de control';
        $this->load->view('admin/header/admin_header', array('title' => $title));
        $this->load->view('admin/setup/admin_menu');
        $this->load->view('admin/bodys/admin_store', array('user' => $this->session->userdata('usuario')));
        $this->load->view('admin/setup/admin_profile', array('user' => $this->session->userdata('usuario')));
        $this->load->view('admin/alerts/myAlerts');
        $this->load->view('admin/footer/admin_footer');
    }
    
    
    function logOut(){
        $this->verifySession();
        $this->session->sess_destroy();
        redirect('index.php/ipanel');
    }
}