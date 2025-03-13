<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_model extends CI_Model { // ✅ El nombre de la clase debe coincidir con el archivo
    public function __construct() {
        parent::__construct();
        $this->load->database(); // ✅ Cargar la base de datos
    }

    public function registrar($tabla, $operacion, $id_registro, $usuario, $datos_anteriores = null, $datos_nuevos = null) {
        $data = [
            'tabla' => $tabla,
            'operacion' => $operacion,
            'id_registro' => $id_registro,
            'datos_anteriores' => $datos_anteriores ? json_encode($datos_anteriores) : null,
            'datos_nuevos' => $datos_nuevos ? json_encode($datos_nuevos) : null,
            'usuario' => $usuario
        ];
        $this->db->insert('auditoria', $data);
    }

    public function getAllAudits() {
        $query = $this->db->get('auditoria'); // Selecciona todos los registros de la tabla auditoria
        $result = $query->result_array();

        if($query->num_rows() > 0):
            return $result;
        else:
            return false;
        endif;
    }

    public function searchAudit($filters) {
        
         // El usuario es obligatorio
        $this->db->like('usuario', $filters['usuario']);

        // Aplicar filtros de fecha si se proporcionan
        if (!empty($filters['fecha_inicio']) && !empty($filters['fecha_fin'])) {
            $this->db->where('fecha >=', $filters['fecha_inicio']);
            $this->db->where('fecha <=', $filters['fecha_fin']);
        }
    
        $query = $this->db->get('auditoria'); // Ejecutar la consulta
        $result = $query->result_array(); // Retornar los resultados como un array asociativo
        
        if($query->num_rows() > 0):
            return $result;
        else:
            return false;
        endif;
    }
    
}
