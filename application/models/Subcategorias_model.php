<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategorias_model extends CI_Model {
	
	public function __construct() {
        parent::__construct();
		// Cargar la base de datos
		$this->load->database();
    }

    // Function para obtener las categorías
	function getSubCategorias($id)
	{	
		$query = $this->db->query("SELECT * FROM categorias WHERE idCatPadre = $id ORDER BY nombre ASC");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}
}