<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends CI_Model {
	
	public function __construct() {
        parent::__construct();
		// Cargar la base de datos
		$this->load->database();
    }

	function getDate(){
		$query = $this->db->query("SELECT NOW() as fecha_actual");
		$result = $query->result_array();
		if($result):
		    return $result[0]['fecha_actual'];
		endif;
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

	function getLastid(){
		$query = $this->db->query("SELECT id as productName FROM productos ORDER BY id DESC LIMIT 1");
		$result = $query->result_array();
		if($result):
		    return $result[0]['productName'];
		endif;
	}

	function editProduct($data) {
		// Obtener los datos previos del producto (antes de la actualización)
		$this->db->where('id', $data['idProduct']);
		$query = $this->db->get('productos');
		$oldData = $query->row_array();
	
		// Preparar los datos nuevos para la actualización
		$newData = [
			'codpro' => $data['productCode'],
			'nompro' => $data['productName'],
			'anchpro' => $data['productAncho'],
			'largpro' => $data['productLargo'],
			'prepro' => $data['productPrice'],
			'preoferpro' => $data['productOfertPrice'],
			'despro' => $data['productDetails'],
			'marcapro' => $data['productTag'],
			'idsubcat' => $data['selectSubcategory'],
			'medida' => $data['productRend'],
			// Incluir otros campos necesarios si los hay
		];
	
		// Realizar la actualización
		$this->db->where('id', $data['idProduct']);
		$result = $this->db->update('productos', $newData);
	
		// Verificar si la consulta fue exitosa
		if ($result) {
			// Registrar la auditoría solo si hubo un cambio en los datos
			$this->load->model('Audit_model');

			// Registrar en la auditoría
			$this->Audit_model->registrar('productos', 'UPDATE', $data['idProduct'], $this->session->userdata('usuario'), $oldData, $newData);
	
			return true;
		} else {
			return false;
		}
	}
		
	public function newProduct($data) {
		// Definir los datos a insertar
		$data_to_insert = [
			'id' => $data['idProduct'],
			'codpro' => $data['productCode'],
			'nompro' => $data['productName'],
			'anchpro' => $data['productAncho'],
			'largpro' => $data['productLargo'],
			'prepro' => $data['productPrice'],
			'preoferpro' => $data['productOfertPrice'],
			'despro' => $data['productDetails'],
			'marcapro' => $data['productTag'],
			'idsubcat' => $data['selectSubcategory'],
			'oculto' => 0,
			'fecharegistro' => date('Y-m-d H:i:s'),
			'urlimagen' => $data['productImg'],
			'medida' => $data['productRend'],
			'cantidad' => 1,
			'agregarCarrito' => 0
		];
	
		// Insertar datos en la base de datos
		if ($this->db->insert('productos', $data_to_insert)) {
			// Obtener los datos recién insertados
			$insertedData = $this->db->get_where('productos', ['id' => $data['idProduct']])->row_array();
	
			// Registrar en auditoría
			$this->load->model('Audit_model');
	
			$this->Audit_model->registrar(
				'productos',             // Nombre de la tabla
				'INSERT',                // Tipo de operación
				$data['idProduct'],      // ID del producto insertado
				$_SESSION['usuario'],   // Usuario que realiza la operación
				null,                    // No hay datos anteriores, ya que es una inserción
				$insertedData // Datos nuevos (el producto insertado)
			);
	
			return true;
		} else {
			return false;
		}
	}
	
	
	public function editStock($data){
		// Obtener datos actuales antes de la actualización
		$this->db->where('id', $data['id']);
		$productoAnterior = $this->db->get('productos')->row_array(); // Datos antes de actualizar stock

		if (!$productoAnterior) {
			return false; // Si el producto no existe, retornar false
		}

		// Datos nuevos
		$nuevosDatos = [
			'cantidad' => $data['stock']
		];

		// Actualizar el stock en la base de datos
		$this->db->where('id', $data['id']);
		$query = $this->db->update('productos', $nuevosDatos);

		if ($query && $this->db->affected_rows() > 0) {
			// Cargar el modelo de auditoría
			$this->load->model('Audit_model');

			// Registrar en auditoría
			$this->Audit_model->registrar(
				'productos', 
				'UPDATE', 
				$data['id'], 
				$_SESSION['usuario'], 
				$productoAnterior, // Datos antes de la actualización
				$nuevosDatos       // Datos nuevos (solo el stock)
			);

			return true;
		}

		return false;
	}

	public function deleteProduct($id) {
		// Obtener datos actuales antes de la eliminación
		$this->db->where('id', $id);
		$productoAnterior = $this->db->get('productos')->row_array(); // Datos antes de la eliminación
	
		if (!$productoAnterior) {
			return false; // Si el producto no existe, retornar false
		}
	
		// Eliminar el producto de la base de datos
		$this->db->where('id', $id);
		$query = $this->db->delete('productos');
	
		if ($query && $this->db->affected_rows() > 0) {
			// Cargar el modelo de auditoría
			$this->load->model('Audit_model');
	
			// Registrar en auditoría
			$this->Audit_model->registrar(
				'productos',             // Nombre de la tabla
				'DELETE',                // Tipo de operación
				$id,                     // ID del producto eliminado
				$_SESSION['usuario'],   // Usuario que realiza la operación
				$productoAnterior, // Datos antes de la eliminación
				null                     // No hay datos nuevos, ya que el producto fue eliminado
			);
	
			return true;
		}
	
		return false;
	}	

	function getAllProductsExcel(){
		$query = $this->db->query("select p.*, c.nombre as categoria from productos as p, categorias as c where p.idsubcat = c.id");
		$result = $query->result_array();
		if($result):
		    return $result;
		endif;
	}
	
	function getAllProductsExcelYesOferts(){
		$query = $this->db->query("SELECT p.* FROM productos p WHERE p.preoferpro > 1");
		$result = $query->result_array();
		if($result):
		    return $result;
		endif;
	}
	
	function getAllProductsExcelNoOferts(){
		$query = $this->db->query("SELECT p.* FROM productos p WHERE p.preoferpro < 1");
		$result = $query->result_array();
		if($result):
		    return $result;
		endif;
	}

	function getDateReducida(){
		$query = $this->db->query("SELECT NOW() as fecha_actual");
		$result = $query->result_array();
		if($result){
			$fecha_actual = $result[0]['fecha_actual'];
			return date('d M Y', strtotime($fecha_actual));
		}
		return null;
	}

	function updateProductForExcel($data){
		foreach($data as $row){

			if($row['tipo'] === 0):
				if($row['oferta'] > 0):
					$query = "
						UPDATE productos SET 
						preoferpro = '".$row['precio']."'
						WHERE codpro = '".$row['codigo']."';
					";
				else:
					$query = "
						UPDATE productos SET 
						prepro = '".$row['precio']."'
						WHERE codpro = '".$row['codigo']."';
					";
				endif;
			elseif($row['tipo'] === 1):
				$query = "
						UPDATE productos SET 
						cantidad = '".$row['stock']."'
						WHERE codpro = '".$row['codigo']."';
					";
			elseif($row['tipo'] === 2):
				if($row['oferta'] > 0):
					$query = "
						UPDATE productos SET 
						preoferpro = '".$row['precio']."',
						cantidad = '".$row['stock']."'
						WHERE codpro = '".$row['codigo']."';
					";
				else:
					$query = "
						UPDATE productos SET 
						prepro = '".$row['precio']."',
						cantidad = '".$row['stock']."'
						WHERE codpro = '".$row['codigo']."';
					";
				endif;

			endif;
			
			if(!$this->db->query($query)):
				return false;
			endif;
		}

		return true;
	}

	// se creo para cargar actualizaciones de productos por listados excel
	function nuevo($data){
		foreach($data as $d):
			$query = "
					UPDATE productos SET 
					codpro = '".$d['codigo']."',
					nompro = '".$d['nombre']."'
					WHERE nompro like '%".$d['nombre']."%';
				";
			$this->db->query($query);
			// echo $query. "<br>";
		endforeach;
	}
}