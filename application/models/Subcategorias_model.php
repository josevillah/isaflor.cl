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
			return true;
		} else {
			return false;
		}
	}
	
	public function updateSubcategory($info) {    
		$data = [
			'nombre' => $info['categoryName'],
			'urlPagina' => $info['categoryName']
		];
		
		// Actualizar en la base de datos
		$this->db->where('id', $info['id']); // Filtrar por el ID de la categoría
		if ($this->db->update('categorias', $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function deleteSubcategory($id) {
		// Eliminar de la base de datos
		$this->db->where('id', $id); // Filtrar por el ID de la categoría
		if ($this->db->delete('categorias')) {
			return true;
		} else {
			return false;
		}
	}
}