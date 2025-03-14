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

        $title = 'Login - Panel de control';
        $fecha_actual = date("dmY:H:i:s");
        
		// Carga la vista del panel de inicio
        $this->load->view('headers/header_admin_login', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('bodys/login');
        $this->load->view('components/alerts');
        $this->load->view('footers/footer_admin_login');
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
        

        $users = $this->usuarios_model->getUsers();
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
        $fecha_actual = date("dmY:H:i:s");

        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $arrayUrl = explode('/', $currentURL);

        if ($_SERVER['HTTP_HOST'] == 'localhost'):
            if($arrayUrl[5] == 'Ipanel' || $arrayUrl[5] == 'ipanel'):
                $url = $arrayUrl[6];
            endif;
        else:
            if($arrayUrl[4] == 'Ipanel' || $arrayUrl[4] == 'ipanel'):
                $url = $arrayUrl[5];
            endif;
        endif;

        $this->load->view('headers/header_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/admin_menu', array('url' => $url));
        $this->load->view('bodys/dashboard');
        $this->load->view('components/alerts');
        $this->load->view('footers/footer_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
    }    
    
    function inform(){
        $this->verifySession();
        $title = 'Dashboard - Panel de control';
        $fecha_actual = date("dmY:H:i:s");

        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $arrayUrl = explode('/', $currentURL);

        if ($_SERVER['HTTP_HOST'] == 'localhost'):
            if($arrayUrl[5] == 'Ipanel' || $arrayUrl[5] == 'ipanel'):
                $url = $arrayUrl[6];
            endif;
        else:
            if($arrayUrl[4] == 'Ipanel' || $arrayUrl[4] == 'ipanel'):
                $url = $arrayUrl[5];
            endif;
        endif;

        $this->load->model('categorias_model');
        $categorias = $this->categorias_model->getCategorias();

        $this->load->view('headers/header_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/admin_menu', array('url' => $url));
        $this->load->view('bodys/inform', array('categorias' => $categorias));
        $this->load->view('components/alerts');
        $this->load->view('footers/footer_admin_inform', array('title' => $title, 'fecha_actual' => $fecha_actual));
    }
    
    function account(){
        $this->verifySession();
        $title = 'Dashboard - Panel de control';
        $fecha_actual = date("dmY:H:i:s");
    
        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $arrayUrl = explode('/', $currentURL);
        if ($_SERVER['HTTP_HOST'] == 'localhost'):
            if($arrayUrl[5] == 'Ipanel' || $arrayUrl[5] == 'ipanel'):
                $url = $arrayUrl[6];
            endif;
        else:
            if($arrayUrl[4] == 'Ipanel' || $arrayUrl[4] == 'ipanel'):
                $url = $arrayUrl[5];
            endif;
        endif;

        $this->load->model('usuarios_model');
        $user = $this->usuarios_model->getUserfromUser($this->session->userdata('usuario'));

        $this->load->view('headers/header_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/admin_menu', array('url' => $url));
        $this->load->view('bodys/account', array('user' => $user[0]));
        $this->load->view('components/alerts');
        $this->load->view('footers/footer_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
    }

    function changeDataForUser(){
        $this->verifySession();
        $this->load->model('usuarios_model');
        $user = $this->usuarios_model->getUserfromUser($this->session->userdata('usuario'));

        $data = $this->input->get();
        $data['usuario'] = $user[0]['usuario'];

        if(isset($data['usuario'])):
            if(!empty($data['password']) && !empty($data['repassword'])):
                if($data['password'] == $data['repassword']):
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $this->usuarios_model->changeDataForUser($data);
                    echo json_encode(true);
                else:
                    echo json_encode(false);
                endif;
            else:
                $this->usuarios_model->changeDataForUser($data);
                echo json_encode(true);
            endif;
        endif;
    }

    function categories(){
        $this->verifySession();
        $title = 'Dashboard - Categorías';
        $fecha_actual = date("dmY:H:i:s");

        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $arrayUrl = explode('/', $currentURL);
        if ($_SERVER['HTTP_HOST'] == 'localhost'):
            if($arrayUrl[5] == 'Ipanel' || $arrayUrl[5] == 'ipanel'):
                $url = $arrayUrl[6];
            endif;
        else:
            if($arrayUrl[4] == 'Ipanel' || $arrayUrl[4] == 'ipanel'):
                $url = $arrayUrl[5];
            endif;
        endif;

        $this->load->model('categorias_model');

        $categorias = $this->categorias_model->getCategorias();

        $this->load->view('headers/header_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/admin_menu', array('url' => $url));
        $this->load->view('bodys/categories', array('categorias' => $categorias));
        $this->load->view('components/alerts');
        $this->load->view('footers/footer_admin_categories', array('title' => $title, 'fecha_actual' => $fecha_actual));
    }

    function searchCategories(){
        $this->verifySession();
        $data = $this->input->post();
        $this->load->model('categorias_model');
        $categorias = $this->categorias_model->searchCategories($data['searchCategory']);
        echo json_encode($categorias);
    }
    
    function searchSubCategories(){
        $this->verifySession();
        $data = $this->input->post();
        $this->load->model('subcategorias_model');
        $subCategorias = $this->subcategorias_model->searchSubCategories($data['searchCategory']);
        echo json_encode($subCategorias);
    }
    
    function searchAllSubCategories(){
        $this->verifySession();
        $data = $this->input->post();
        $this->load->model('subcategorias_model');
        $subCategorias = $this->subcategorias_model->searchAllSubCategories();
        echo json_encode($subCategorias);
    }

    function getAllCategories(){
        $this->verifySession();
        $this->load->model('categorias_model');
        $categorias = $this->categorias_model->getCategorias();
        echo json_encode($categorias);
    }

    function newCategory(){
        $this->verifySession();
        // Leer los datos JSON de la entrada
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        $this->load->model('categorias_model');
        $result = $this->categorias_model->newCategory($data);
        if($result):
            echo json_encode(true);
        else:
            echo json_encode(false);
        endif;
    }
    
    function newSubcategory(){
        $this->verifySession();
        // Leer los datos JSON de la entrada
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        $this->load->model('subcategorias_model');
        $result = $this->subcategorias_model->newSubcategory($data);
        echo json_encode($result);
    }
    
    function editCategory(){
        $this->verifySession();
        // Leer los datos JSON de la entrada
        $data = $this->input->get();

        $title = 'Dashboard - Categorías';
        $fecha_actual = date("dmY:H:i:s");

        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $arrayUrl = explode('/', $currentURL);
        if ($_SERVER['HTTP_HOST'] == 'localhost'):
            if($arrayUrl[5] == 'Ipanel' || $arrayUrl[5] == 'ipanel'):
                $url = $arrayUrl[6];
            endif;
        else:
            if($arrayUrl[4] == 'Ipanel' || $arrayUrl[4] == 'ipanel'):
                $url = $arrayUrl[5];
            endif;
        endif;

        $this->load->model('categorias_model');

        $categorias = $this->categorias_model->getCategorias();

        $this->load->view('headers/header_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/admin_menu', array('url' => $url));
        $this->load->view('bodys/editCategories', array('data' => $data));
        $this->load->view('components/alerts');
        $this->load->view('footers/footer_admin_categories', array('title' => $title, 'fecha_actual' => $fecha_actual));
    }

    function editSubcategory(){
        $this->verifySession();
        // Leer los datos JSON de la entrada
        $data = $this->input->get();

        $title = 'Dashboard - Categorías';
        $fecha_actual = date("dmY:H:i:s");

        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $arrayUrl = explode('/', $currentURL);
        if ($_SERVER['HTTP_HOST'] == 'localhost'):
            if($arrayUrl[5] == 'Ipanel' || $arrayUrl[5] == 'ipanel'):
                $url = $arrayUrl[6];
            endif;
        else:
            if($arrayUrl[4] == 'Ipanel' || $arrayUrl[4] == 'ipanel'):
                $url = $arrayUrl[5];
            endif;
        endif;

        $this->load->model('categorias_model');

        $categorias = $this->categorias_model->getCategorias();

        $this->load->view('headers/header_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/admin_menu', array('url' => $url));
        $this->load->view('bodys/editSubcategories', array('data' => $data));
        $this->load->view('components/alerts');
        $this->load->view('footers/footer_admin_subcategories', array('title' => $title, 'fecha_actual' => $fecha_actual));
    }

    function updateCategory(){
        $this->verifySession();
        // Leer los datos JSON de la entrada
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        $this->load->model('categorias_model');
        $result = $this->categorias_model->updateCategory($data);
        if($result):
            echo json_encode(true);
        else:
            echo json_encode(false);
        endif;
    }
    
    function updateSubcategory(){
        $this->verifySession();
        // Leer los datos JSON de la entrada
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        $this->load->model('subcategorias_model');
        $result = $this->subcategorias_model->updateSubcategory($data);
        echo json_encode($result);
    }
    
    function deleteSubcategory(){
        $this->verifySession();
        // Leer los datos JSON de la entrada
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        $this->load->model('subcategorias_model');
        $result = $this->subcategorias_model->deleteSubcategory($data);
        echo json_encode($result);
    }
    
    function deleteCategory(){
        $this->verifySession();
        // Leer los datos JSON de la entrada
        $input = file_get_contents('php://input');
        $id = json_decode($input, true);

        $this->load->model('categorias_model');
        $result = $this->categorias_model->deleteCategory($id);
        if($result):
            echo json_encode(true);
        else:
            echo json_encode(false);
        endif;
    }

    function subcategories(){
        $this->verifySession();
        $title = 'Dashboard - Subcategorias';
        $fecha_actual = date("dmY:H:i:s");

        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $arrayUrl = explode('/', $currentURL);
        if ($_SERVER['HTTP_HOST'] == 'localhost'):
            if($arrayUrl[5] == 'Ipanel' || $arrayUrl[5] == 'ipanel'):
                $url = $arrayUrl[6];
            endif;
        else:
            if($arrayUrl[4] == 'Ipanel' || $arrayUrl[4] == 'ipanel'):
                $url = $arrayUrl[5];
            endif;
        endif;

        $this->load->model('subcategorias_model');
        $this->load->model('categorias_model');

        $subcategorias = $this->subcategorias_model->searchAllSubCategories();
        $categorias = $this->categorias_model->getCategorias();

        $this->load->view('headers/header_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/admin_menu', array('url' => $url));
        $this->load->view('bodys/subcategories', array('subcategorias' => $subcategorias, 'categorias' => $categorias));
        $this->load->view('components/alerts');
        $this->load->view('footers/footer_admin_subcategories', array('title' => $title, 'fecha_actual' => $fecha_actual));
    }

    function calendar(){
        $this->verifySession();
        $title = 'Panel de control - Calendario';
        $fecha_actual = date("dmY:H:i:s");

        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $arrayUrl = explode('/', $currentURL);
        if ($_SERVER['HTTP_HOST'] == 'localhost'):
            if($arrayUrl[5] == 'Ipanel' || $arrayUrl[5] == 'ipanel'):
                $url = $arrayUrl[6];
            endif;
        else:
            if($arrayUrl[4] == 'Ipanel' || $arrayUrl[4] == 'ipanel'):
                $url = $arrayUrl[5];
            endif;
        endif;

        $this->load->view('headers/header_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/admin_menu', array('url' => $url));
        $this->load->view('bodys/calendar');
        $this->load->view('footers/footer_admin_categories', array('title' => $title, 'fecha_actual' => $fecha_actual));
    }
    
    
    function products(){
        $this->verifySession();
        $title = 'Panel de control - Productos';
        $fecha_actual = date("dmY:H:i:s");

        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $arrayUrl = explode('/', $currentURL);
        if ($_SERVER['HTTP_HOST'] == 'localhost'):
            if($arrayUrl[5] == 'Ipanel' || $arrayUrl[5] == 'ipanel'):
                $url = $arrayUrl[6];
            endif;
        else:
            if($arrayUrl[4] == 'Ipanel' || $arrayUrl[4] == 'ipanel'):
                $url = $arrayUrl[5];
            endif;
        endif;

        $this->load->view('headers/header_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/admin_menu', array('url' => $url));
        $this->load->view('components/alerts');
        $this->load->view('bodys/admin_products');
        $this->load->view('footers/footer_admin_product', array('title' => $title, 'fecha_actual' => $fecha_actual));
    }
    
    
    function logOut(){
        $this->verifySession();
        $this->session->sess_destroy();
        redirect('index.php/ipanel');
    }
}