<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model {
	
	public function __construct() {
        parent::__construct();
		// Cargar la base de datos
		$this->load->database();
    }

	function getOfertasProductos()
	{	
		$query = $this->db->query("SELECT p.*, c.nombre AS nombre_categoria FROM productos p JOIN categorias c ON p.idsubcat = c.id WHERE p.preoferpro > 0 and oculto = 0 and cantidad > 0 ORDER BY RAND() LIMIT 5");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}
	
	function getProductosRelacionados($id_producto, $id_categoria)
	{	
		$query = $this->db->query("
		SELECT p.*, c.nombre AS nombre_categoria
		FROM productos p
		JOIN categorias c ON p.idsubcat = c.id
		WHERE p.idsubcat = $id_categoria
		AND p.oculto = 0
		AND p.cantidad > 0
		AND p.id != $id_producto
		ORDER BY RAND()
		LIMIT 5;
		");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}
    
	// Function para obtener el producto buscado
	function getProductosNombre($datos)
	{
		// Obtén el segmento que contiene los datos de búsqueda
		$datos = $this->uri->segment(3);

		// Decodificar la cadena
		$datos_decodificados = urldecode($datos);

		$query = $this->db->query("
			SELECT * FROM productos
			WHERE (nompro LIKE ? OR codpro LIKE ?)
			AND cantidad > 0
			AND oculto = 0
			LIMIT 10
		", array("%$datos_decodificados%", "%$datos_decodificados%"));

		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
			return $result;
		endif;
	}

	function getOneProductId($id)
	{	
		$query = $this->db->query("SELECT * FROM productos WHERE id = ? LIMIT 1", array($id));
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result[0];
        endif;
	}
	
	function getAllProducts($id)
	{	
		$query = $this->db->query("
			SELECT p.*, c.nombre
			FROM productos p
			INNER JOIN categorias c ON p.idsubcat = c.id
			WHERE p.idsubcat = ? AND p.oculto = 0
			ORDER BY p.prepro ASC
		", array($id));


        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}
	
	function getAllProductsPage($id, $iniciar)
	{	
		$query = $this->db->query("
		SELECT p.*, c.nombre AS nombre
		FROM productos p
		INNER JOIN categorias c ON p.idsubcat = c.id
		WHERE p.idsubcat = ? AND p.oculto = 0
		ORDER BY 
		  CASE WHEN p.cantidad > 0 THEN 0 ELSE 1 END,  -- Prioriza los productos con cantidad > 0
		  p.prepro ASC
		LIMIT ?, 15	
		", array($id, $iniciar));


        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}
	
	function getAllProductsOfertsCount()
	{	
		$query = $this->db->query("
		SELECT * FROM productos
		WHERE preoferpro > 0 
		AND oculto = 0
		");


        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}

	function getAllProductsOferts($iniciar)
	{	
		$query = $this->db->query("
			SELECT p.*, c.nombre AS nombre
			FROM productos p
			INNER JOIN categorias c ON p.idsubcat = c.id
			WHERE p.preoferpro > 0
			AND p.oculto = 0
			ORDER BY 
				CASE WHEN p.cantidad > 0 THEN 0 ELSE 1 END, -- Priorizar productos con cantidad > 0
				p.preoferpro ASC -- Ordenar por preoferpro ascendente
			LIMIT ?, 15
		", array($iniciar));





        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}
	
	function getCountCatSubCatPro()
	{	
		$query = $this->db->query("
		SELECT
		(SELECT COUNT(*) FROM productos) AS cantidad_productos,
		(SELECT COUNT(*) FROM catpadre) AS cantidad_catpadre,
		(SELECT COUNT(*) FROM categorias) AS cantidad_categorias,
		(SELECT COUNT(*) FROM usuario) AS cantidad_usuarios
		");

        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}

}