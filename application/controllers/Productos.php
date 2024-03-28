<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        // Carga el helper url
        $this->load->helper('url');
    }

	function viewProduct($id){
		// Carga de modelos
		$this->load->model('Categorias_model');
		$this->load->model('Productos_model');

		$categorias = $this->Categorias_model->getCategorias();
		$producto = $this->Productos_model->getOneProductId($id);
		$productosRelacionados = $this->Productos_model->getProductosRelacionados($producto['id'], $producto['idsubcat']);

		// Obtiene la fecha actual para la cache
		$fecha_actual = date("dmY:H:i:s");

		if(count($categorias) > 0):
			$title = "Producto";
			$this->load->view('headers/header_product', array('title' => $title, 'fecha_actual' => $fecha_actual));
			$this->load->view('components/menu', array('categorias' => $categorias));
			$this->load->view('components/buttonUp');
			$this->load->view('bodys/product_view', array('producto' => $producto));
			$this->load->view('components/relations', array('relacionados' => $productosRelacionados));
			$this->load->view('footers/foot');
			$this->load->view('footers/footer_product', array('fecha_actual' => $fecha_actual));
		endif;
	}

	function getProductosNombre($datos)
	{	
		$this->load->model('Productos_model');
		$result = $this->Productos_model->getProductosNombre($datos);
		if(count($result) > 0):
			header('Content-Type: application/json'); // Establece el tipo de contenido como JSON
    		echo json_encode($result);
		endif;
	}

	function viewOferts()
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
		$productos = $this->Productos_model->getAllProductsOfertsCount();
		
		$articulos_x_pagina = 15;
		$numero_paginas = count($productos) / $articulos_x_pagina;
		$numero_paginas =  ceil($numero_paginas);

		if($_GET['page'] > $numero_paginas || $_GET['page'] < 1):
			$url_actual = explode('?', $url_actual);
			header("Location: ".$url_actual[0]."?page=1");
		endif;
		
		$iniciar = ($_GET['page'] - 1) * $articulos_x_pagina;
		$productsOferts = $this->Productos_model->getAllProductsOferts($iniciar);

		if(count($categorias) > 0):
			$titulo = "Producto";
			$this->load->view('headers/head', array('titulo' => $titulo));
			$this->load->view('setup/menu', array('categorias' => $categorias));
			$this->load->view('productosCategorias', array('productos' => $productsOferts, 'numero_paginas' => $numero_paginas, 'articulos_x_pagina' => $articulos_x_pagina));
			$this->load->view('footers/footer');
			$this->load->view('footers/foot');
		endif;
	}
}
