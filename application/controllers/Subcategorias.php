<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategorias extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        // Carga el helper url
        $this->load->helper('url');
    }

	function getSubCategorias($id)
	{	
		$this->load->model('Subcategorias_model');
		$result = $this->Subcategorias_model->getSubCategorias($id);
		if(count($result) > 0):
			header('Content-Type: application/json'); // Establece el tipo de contenido como JSON
    		echo json_encode($result);
		endif;
	}
}
