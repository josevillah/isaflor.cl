<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategorias_model extends CI_Model {
	
	public function __construct() {
        parent::__construct();
		// Cargar la base de datos
		$this->load->database();
    }

    // Function para obtener las categorías
	function getSubCategorias($id){	
		$query = $this->db->query("SELECT * FROM categorias WHERE idCatPadre = $id ORDER BY nombre ASC");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}
    
	// Function para obtener Todas las categorías
	function searchAllSubCategories(){	
		$query = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}

	function searchSubCategories($subcat){	
		$query = $this->db->query("SELECT * FROM categorias WHERE nombre like '%$subcat%' ORDER BY nombre ASC LIMIT 5");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}
	
	
	function newSubcategory($subcat){    
		$data = [
			'nombre' => $subcat['categoryName'],
			'urlPagina' => $subcat['categoryName'],
			'idCatPadre' => $subcat['selectCategory'],
			'destacada' => 0
		];

		// Insertar en la base de datos
		if ($this->db->insert('categorias', $data)) {
			$id_insertado = $this->db->insert_id(); // Obtener ID de la nueva subcategoría

			// Cargar el modelo de auditoría
			$this->load->model('Audit_model');

			// Registrar en auditoría
			$this->Audit_model->registrar(
				'categorias', 
				'INSERT', 
				$id_insertado, 
				$_SESSION['usuario'], 
				null,  // No hay datos anteriores
				$data  // Datos nuevos insertados
			);

			return true;
		} 

		return false;
	}
	
	public function updateSubcategory($info){    
		// Obtener datos actuales antes de la actualización
		$this->db->where('id', $info['id']);
		$subcategoriaAnterior = $this->db->get('categorias')->row_array(); // Datos antes de actualizar

		if (!$subcategoriaAnterior) {
			return false; // Si la subcategoría no existe, retornar false
		}

		// Datos nuevos
		$data = [
			'nombre' => $info['categoryName'],
			'urlPagina' => $info['categoryName']
		];

		// Actualizar en la base de datos
		$this->db->where('id', $info['id']);
		$query = $this->db->update('categorias', $data);

		if ($query) {
			// Cargar el modelo de auditoría
			$this->load->model('Audit_model');

			// Registrar en auditoría
			$this->Audit_model->registrar(
				'categorias', 
				'UPDATE', 
				$info['id'], 
				$_SESSION['usuario'], 
				$subcategoriaAnterior, // Datos antes de la actualización
				$data                  // Datos nuevos
			);

			return true;
		}

		return false;
	}

	
	public function deleteSubcategory($id){    
		// Obtener datos antes de eliminar
		$this->db->where('id', $id);
		$subcategoriaAnterior = $this->db->get('categorias')->row_array(); // Datos antes de borrar

		if (!$subcategoriaAnterior) {
			return false; // Si la subcategoría no existe, retornar false
		}

		// Eliminar la subcategoría
		$this->db->where('id', $id);
		$query = $this->db->delete('categorias');

		if ($query) {
			// Cargar el modelo de auditoría
			$this->load->model('Audit_model');

			// Registrar en auditoría
			$this->Audit_model->registrar(
				'categorias', 
				'DELETE', 
				$id, 
				$_SESSION['usuario'], 
				$subcategoriaAnterior, // Datos antes de la eliminación
				null                  // No hay datos nuevos, ya que se eliminó
			);

			return true;
		}

		return false;
	}

}