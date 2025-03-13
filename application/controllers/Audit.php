<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        // Carga el helper url
        $this->load->helper('url');
        $this->load->library('session');
    }
	
    function verifySession() {
        if(!$this->session->userdata('usuario')):
            redirect('index.php/ipanel');
        endif;
    }

    public function url(){
        $currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $arrayUrl = explode('/', $currentURL);

        if ($_SERVER['HTTP_HOST'] == 'localhost'):
            if($arrayUrl[5] == 'audit' || $arrayUrl[5] == 'audit'):
                $url = $arrayUrl[5];
            endif;
        else:
            if($arrayUrl[4] == 'audit' || $arrayUrl[4] == 'audit'):
                $url = $arrayUrl[4];
            endif;
        endif;
        return $url;
    }

    public function getAllAudits(){
        $this->load->model('audit_model');
        $audits = $this->audit_model->getAllAudits();
        echo json_encode($audits);
    }

    public function searchAudit(){
        $this->load->model('audit_model');
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        $filters = array(
            'usuario' => $data['searchAudit'],
            'fecha_inicio' => $data['startDate'],
            'fecha_fin' => $data['endDate']
        );

        $search = $this->input->post('searchAudit');
        $audits = $this->audit_model->searchAudit($filters);
        echo json_encode($audits);
    }

	function index(){	
		$this->verifySession();
        $url = $this->url();

        $title = 'Dashboard - Auditoria';
        $fecha_actual = date("dmY:H:i:s");

        $this->load->model('audit_model');
        $audits = $this->audit_model->getAllAudits();
        
        $this->load->view('headers/header_admin_dashboard', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/admin_menu', array('url' => $url));
        $this->load->view('bodys/audit', array('audits' => $audits));
        $this->load->view('components/alerts');
        $this->load->view('footers/footer_admin_audit', array('title' => $title, 'fecha_actual' => $fecha_actual));
	}
}