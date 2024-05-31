<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        // Carga el helper url
        $this->load->helper('url');
    }
	
	function viewCategoria($id)
	{	
		
		$url_actual = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if(base_url() != $url_actual):
			if(!isset($_GET['page'])):
				header("Location: ".$url_actual."?page=1");
			endif;
		endif;

		// Carga de modelos
		$this->load->model('Categorias_model');
		$this->load->model('Productos_model');

		$categorias = $this->Categorias_model->getCategorias();
		$productos = $this->Productos_model->getAllProducts($id);
		
		$articulos_x_pagina = 15;
		$numero_paginas = count($productos) / $articulos_x_pagina;
		$numero_paginas =  ceil($numero_paginas);

		if($numero_paginas == 0):
			header("Location: ".base_url());
			exit; // ¡No olvides salir del script después de redireccionar!
		endif;

		if(isset($_GET['page']) && (int)$_GET['page'] > $numero_paginas || (int)$_GET['page'] < 1):
			$url_actual = explode('?', $url_actual);
			header("Location: ".$url_actual[0]."?page=1");
			exit; // ¡No olvides salir del script después de redireccionar!
		endif;
		
		$iniciar = ($_GET['page'] - 1) * $articulos_x_pagina;
		$productosPage = $this->Productos_model->getAllProductsPage($id, $iniciar);

		// Obtiene la fecha actual para la cache
		$fecha_actual = date("dmY:H:i:s");

		if(count($categorias) > 0):
			$title = "Categoría ".isset($productosPage[0]['nombre']);
			$this->load->view('headers/header_main', array('title' => $title, 'fecha_actual' => $fecha_actual));
			$this->load->view('components/menu', array('categorias' => $categorias));
			$this->load->view('bodys/productosCategorias', array('productos' => $productosPage));
			$this->load->view('components/pagination', array('numero_paginas' => $numero_paginas, 'articulos_x_pagina' => $articulos_x_pagina));
			$this->load->view('components/buttonUp');
			$this->load->view('footers/foot');
			$this->load->view('footers/footer_main', array('fecha_actual' => $fecha_actual));
		endif;
	}

	function getCategoriasDestacadas()
	{	
		$this->load->model('Categorias_model');
		$result = $this->Categorias_model->getCategoriasDestacadas();
		if(count($result) > 0):
			return $result;
		endif;
	}
	
	function getCategorias()
	{	
		$this->load->model('Categorias_model');
		$result = $this->Categorias_model->getCategorias();
		if(count($result) > 0):
			echo json_encode($result);
		else:
			echo json_encode(false);
		endif;
	}

}