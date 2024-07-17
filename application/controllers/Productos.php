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
			$this->load->view('bodys/product_view', array('producto' => $producto, 'fecha_actual' => $fecha_actual));
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

	function searchProduct()
	{	
		$datos = $this->input->get('searchCategory');
		$decoded_datos = urldecode($datos);
		$this->load->model('Productos_model');
		$result = $this->Productos_model->searchProduct($decoded_datos);
		if(count($result) > 0):
    		echo json_encode($result);
		endif;
	}

	function getProductForEdit()
	{
		$this->load->model('Productos_model');
		$id = $this->input->get('searchCategory');
		$result = $this->Productos_model->getOneProductForEdit($id);
		if($result):
			echo json_encode($result);
		else:
			echo json_encode(false);
		endif;
	}

	 // Definir la función convertToWebp
	function convertToWebp($source, $destination, $quality = 80) {
		// Obtener la información de la imagen
		$info = getimagesize($source);
		$mime = $info['mime'];

		// Crear una nueva imagen a partir del archivo fuente
		switch ($mime) {
			case 'image/jpeg':
				$image = imagecreatefromjpeg($source);
				break;
			case 'image/png':
				$image = imagecreatefrompng($source);
				break;
			default:
				throw new Exception('Tipo de imagen no soportado: ' . $mime);
		}

		// Guardar la imagen en formato WEBP
		if (!imagewebp($image, $destination, $quality)) {
			throw new Exception('Fallo al guardar la imagen en formato WEBP.');
		}

		// Liberar memoria
		imagedestroy($image);
	}

	function newOrEditProduct() {
		$data = $this->input->post();
		$file = $_FILES['productImg'];

		if ($file['size'] == 0):
			$this->load->model('Productos_model');
			$result = $this->Productos_model->editProduct($data);
			if ($result):
				echo json_encode(true);
			else:
				echo json_encode(false);
			endif;
			return;
		endif;

		$new = false;
		
		if(empty($data['idProduct'])):
			$this->load->model('Productos_model');
			$data['idProduct'] = $this->Productos_model->getLastid();
			$data['idProduct'] = $data['idProduct'] + 1;
			$new = true;
		endif;

		if(empty($data['productRend'])):
			$data['productRend'] = '0';
		endif;

		// Definir el nombre de archivo de destino para la imagen WEBP
		$filename = pathinfo($data['idProduct'], PATHINFO_FILENAME) . '.webp';
		$destination = FCPATH . 'public/img/productos/' . $filename;

		// Crear el directorio si no existe
		$dir = dirname($destination);
		if (!is_dir($dir)) {
			if (!mkdir($dir, 0755, true)) {
				echo json_encode(['error' => 'No se pudo crear el directorio de destino.']);
				return;
			}
		}

		try {
			// Convertir la imagen a WEBP
			$this->convertToWebp($file['tmp_name'], $destination);

			// Actualizar la información de la imagen en los datos del producto
			$data['productImg'] = 'public/img/productos/' . $filename;

			// Guardar los cambios del producto
			$this->load->model('Productos_model');
			if($new == false):
				$result = $this->Productos_model->editProduct($data);
			else:
				$result = $this->Productos_model->newProduct($data);
			endif;

			if ($result):
				echo json_encode(true);
			else:
				echo json_encode(false);
			endif;
		} catch (Exception $e) {
			echo json_encode(['error' => $e->getMessage()]);
		}
	}

	function editStock() {
		$data = $this->input->post();
		$this->load->model('Productos_model');
		$result = $this->Productos_model->editStock($data);
		if ($result) {
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}
	
}
