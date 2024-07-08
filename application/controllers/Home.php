<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        // Carga el helper url
        $this->load->helper('url');
    }

	public function index()
	{	
		$title = "Isaflor - Pagina de Inicio";

		$this->load->model('Categorias_model');
		$this->load->model('Productos_model');
		$categorias = $this->Categorias_model->getCategorias();
		$ofertas = $this->Productos_model->getOfertasProductos();
		$destacadas = $this->Categorias_model->getDestacadas();

		// Ejecuta el proceso de generar categorías aleatorias
		$this->Categorias_model->obtenerDatosAleatorios();

		// Obtiene 5 productos de una categoría aleatoria
		$datosAleatorios = $this->Categorias_model->datosAleatorios;

		// Obtiene la fecha actual para la cache
		$fecha_actual = $this->Productos_model->getDate();
		$mes_dia_actual = date('d-m', strtotime($fecha_actual));
		
		// Cargar la vista
		$this->load->view('headers/header_main', array('title' => $title, 'fecha_actual' => $fecha_actual));
		$this->load->view('components/menu', array('categorias' => $categorias));
		$this->load->view('components/slider', array('fecha_actual' => $fecha_actual, 'mes_dia_actual' => $mes_dia_actual));
		$this->load->view('components/categories', array('destacadas' => $destacadas));
		$this->load->view('components/oferts', array('ofertas' => $ofertas));
		$this->load->view('components/brands');
		$this->load->view('components/categoryOne', array('categoryOne' => $datosAleatorios['datosUno']));
		$this->load->view('components/categoryTwo', array('categoryTwo' => $datosAleatorios['datosDos']));
		$this->load->view('components/buttonUp');
		$this->load->view('footers/foot');
		$this->load->view('footers/footer_main', array('fecha_actual' => $fecha_actual));
	}
}