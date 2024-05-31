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
    
	// Function para obtener el producto buscado METODO POST
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
	
	// Function para obtener el producto buscado METODO GET
	function searchProduct($datos)
	{
		$query = "
			SELECT * FROM productos
			WHERE nompro LIKE '%".$datos."%' OR codpro LIKE '%".$datos."%'
			AND oculto = 0
			LIMIT 10
		";
		$query = $this->db->query($query);
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
	
	function getOneProductForEdit($id)
	{   
		$query = $this->db->query("
			SELECT 
				p.*, 
				c.id AS id_subcategoria, 
				c.nombre AS nombre_subcategoria, 
				cp.id AS id_categoria, 
				cp.nombre AS nombre_categoria
			FROM 
				productos AS p
			LEFT JOIN 
				categorias AS c ON p.idsubcat = c.id
			LEFT JOIN 
				catpadre AS cp ON c.idCatPadre = cp.id
			WHERE 
				p.id = $id;
		");
		// Verificar si la consulta fue exitosa
		if ($query):
			// Obtener el resultado como un array
			$result = $query->row_array();
			return $result;
		endif;
	}
	
	function getAllProducts($id)
	{	
		$query = $this->db->query("
			SELECT p.*, c.nombre
			FROM productos p
			INNER JOIN categorias c ON p.idsubcat = c.id
			WHERE p.idsubcat = ? AND p.oculto = 0
			AND p.cantidad > 0
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
		AND p.cantidad > 0
		ORDER BY 
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
			AND p.cantidad > 0
			ORDER BY 
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

	function editProduct($data){
		// Obtener la fecha actual
		$query = $this->db->query("SELECT NOW() as fecha_actual");
		$result = $query->result_array();
    	$fecha = $result[0]['fecha_actual'];
		
		$query = "
			UPDATE productos SET 
			codpro = '".$data['productCode']."',
			nompro = '".$data['productName']."',
			anchpro = '".$data['productAncho']."',
			largpro = '".$data['productLargo']."',
			prepro = '".$data['productPrice']."',
			preoferpro = '".$data['productOfertPrice']."',
			despro = '".$data['productDetails']."',
			marcapro = '".$data['productTag']."',
			idsubcat = '".$data['selectSubcategory']."',
			fecharegistro = '".$fecha."',
			medida = '".$data['productRend']."'
			WHERE id = '".$data['idProduct']."';
		";

		$result = $this->db->query($query);
        // Verificar si la consulta fue exitosa
		if($result):
            return true;
        endif;
	}
	
	function editStock($data){
		$query = "
			UPDATE productos SET 
			cantidad = '".$data['stock']."'
			WHERE id = '".$data['id']."';
		";

		$result = $this->db->query($query);
        // Verificar si la consulta fue exitosa
		if($result):
			return true;
		endif;
	}

}