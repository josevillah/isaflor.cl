<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
	
	public function __construct() {
        parent::__construct();
		// Cargar la base de datos
		$this->load->database();
    }



    // Function para obtener las categorías
	function getUsers()
	{	
		$query = $this->db->query("SELECT * FROM usuario");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}
	
	
	function getUserfromUser($user)
	{	
		$query = $this->db->query("SELECT * FROM usuario WHERE usuario = '$user'");
        // Verificar si la consulta fue exitosa
		if($query):
			// Obtener los resultados como un array
			$result = $query->result_array();
            return $result;
        endif;
	}

	function changeDataForUser($data){
		if(empty($data['password'])):
			$query = $this->db->query("UPDATE usuario SET nombre = '".$data['nombre']."', apellido = '".$data['apellido']."' WHERE usuario = '".$data['usuario']."'");
		else:
			$query = $this->db->query("UPDATE usuario SET nombre = '".$data['nombre']."', apellido = '".$data['apellido']."', clave = '".$data['password']."' WHERE usuario = '".$data['usuario']."'");
		endif;

		if($query):
			return true;
		endif;
	}
}