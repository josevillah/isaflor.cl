<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias_model extends CI_Model {

	public $datosAleatorios = array();
	
	public function __construct() {
        parent::__construct();
		// Cargar la base de datos
		$this->load->database();
    }

	function getCategorias()
	{	
		$query = $this->db->query("SELECT * FROM catpadre ORDER BY nombre ASC");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
		endif;
	}
	
	function getDestacadas()
	{	
		$query = $this->db->query("SELECT * FROM categorias where destacada = true order by nombre ASC");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();			
            return $result;
        endif;
	}
	
	function getCantidadCategorias()
	{	
		$query = $this->db->query("SELECT
		c.id AS id_categoria,
		c.nombre AS nombre_categoria,
		c.url_imagen_categoria,
		COUNT(p.id) AS cantidadProductos
		FROM
			categorias c
		LEFT JOIN
			productos p ON c.id = p.idsubcat
		WHERE
			c.destacada = 1 AND
			p.cantidad = 1
		GROUP BY
			c.id, c.nombre, c.url_imagen_categoria
		ORDER BY
		c.nombre ASC
		");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();			
            return $result;
        endif;
	}

	function obtenerDatosAleatorios() {
		// Seleccionar una categoría al azar que tenga al menos 5 productos
		$query = $this->db->query("
		SELECT
			id_categoria,
			codigo_producto,
			id_producto,
			nombre_producto,
			descripcion_producto,
			url_imagen_producto,
			nombre_categoria,
			precio_producto,
			precio_oferta,
			fecha,
			cantidad,
			medida,
			agregarCarrito
		FROM (
			SELECT
				p.idsubcat AS id_categoria,
				p.codpro AS codigo_producto,
				p.id AS id_producto,
				p.nompro AS nombre_producto,
				p.despro AS descripcion_producto,
				p.urlimagen AS url_imagen_producto,
				c.nombre AS nombre_categoria,
				p.prepro AS precio_producto,
				p.preoferpro AS precio_oferta,
				p.fecharegistro AS fecha,
				p.cantidad AS cantidad,
				p.medida AS medida,
				p.agregarCarrito AS agregarCarrito,
				ROW_NUMBER() OVER (PARTITION BY c.id ORDER BY RAND()) AS row_num
			FROM
				productos p
			JOIN categorias c ON p.idsubcat = c.id
			WHERE
				p.cantidad > 0
				AND p.oculto = 0
				AND c.id = (
					SELECT
						id_categoria
					FROM (
						SELECT
							c.id AS id_categoria,
							COUNT(p2.id) AS total_productos
						FROM
							categorias c
						JOIN productos p2 ON c.id = p2.idsubcat
						WHERE
							p2.cantidad > 0
							AND p2.oculto = 0
						GROUP BY
							c.id
						HAVING
							total_productos >= 5
						ORDER BY RAND()
						LIMIT 1
					) categorias_con_suficientes_productos
				)
		) productos_categoria
		WHERE
			row_num <= 5;
		");

		// Devolver los productos seleccionados
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();

			if(isset($this->datosAleatorios["datosUno"])):

				$this->datosAleatorios["datosDos"] = $result;
				if ($this->datosAleatorios["datosUno"] == $this->datosAleatorios["datosDos"]) {
					$this->obtenerDatosAleatorios();
				} else {
					return;
				}
			endif;

			$this->datosAleatorios["datosUno"] = $result;
			$this->obtenerDatosAleatorios();
        endif;
	} 

	function searchCategories($cat)
	{	
		$query = $this->db->query("SELECT * FROM catpadre WHERE nombre like '%$cat%' ORDER BY nombre ASC LIMIT 5");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}
	
	function newCategory($data){    
		$data = [
			'nombre' => $data['categoryName'],
			'dataCategoria' => $data['categoryName']
		];
	
		$this->db->insert('catpadre', $data);
		
		if ($this->db->affected_rows() > 0) {
			$id_insertado = $this->db->insert_id(); // Obtener ID insertado
	
			// Cargar el modelo de auditoría
			$this->load->model('audit_model');
			
			// Registrar en auditoría (nuevo orden de parámetros)
			$this->audit_model->registrar('catpadre', 'INSERT', $id_insertado, $_SESSION['usuario'], null, $data);
			
			return true;
		}
		return false;
	}
	
	
	function updateCategory($data){    
		// Obtener datos actuales antes de la actualización
		$this->db->where('id', $data['id']);
		$categoriaAnterior = $this->db->get('catpadre')->row_array(); // Datos antes de actualizar

		if (!$categoriaAnterior) {
			return false; // Si no existe la categoría, retornar false
		}

		// Datos nuevos
		$datosActualizar = [
			'nombre' => $data['categoryName']
		];

		// Realizar la actualización
		$this->db->where('id', $data['id']);
		$query = $this->db->update('catpadre', $datosActualizar);

		if ($query) {
			// Cargar el modelo de auditoría
			$this->load->model('Audit_model');

			// Registrar en auditoría
			$this->Audit_model->registrar(
				'catpadre', 
				'UPDATE', 
				$data['id'], 
				$_SESSION['usuario'], 
				$categoriaAnterior,  // Datos antes de la actualización
				$datosActualizar     // Datos después de la actualización
			);

			return true;
		}

		return false;
	}

	
	function deleteCategory($id){    
		// Obtener datos antes de eliminar
		$this->db->where('id', $id);
		$categoriaAnterior = $this->db->get('catpadre')->row_array();

		if (!$categoriaAnterior) {
			return false; // Si no existe la categoría, retornar false
		}

		// Eliminar la categoría
		$this->db->where('id', $id);
		$query = $this->db->delete('catpadre');

		if ($query) {
			// Cargar el modelo de auditoría
			$this->load->model('Audit_model');

			// Registrar en auditoría
			$this->Audit_model->registrar(
				'catpadre', 
				'DELETE', 
				$id, 
				$_SESSION['usuario'], 
				$categoriaAnterior, // Datos antes de la eliminación
				null                // No hay datos nuevos, ya que se eliminó
			);

			return true;
		}

		return false;
	}

}
