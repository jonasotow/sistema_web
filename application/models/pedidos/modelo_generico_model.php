<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *  tabla_generica Class
 *
 *  @category:  Modelo
 *  @author:    José Manzo
 */
class Modelo_generico_model extends CI_Model {

    /**
     * Obtiene una lista de acuerdo a los campos y tablas que reciba
     * 
     * @param string $table Nombre de la tabla
     * @param string $campo1 Primer campo
     * @param string $campo2 Segundo campo
     * @access public
     * @return array || boolean
     */
    function get_value($table, $campo1, $campo2) {
        $this->db->select($campo1 . ',' . $campo2);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    /**
     * Cuenta los registros de determinada tabla
     * 
     * @param string $table Nombre de la tabla
     * @access public
     * @return int
     */
    function count($table) {
        $count = $this->db->count_all_results($table);
        return $count;
    }

    /**
     * Obtiene la clave y el nombre del cliente del usuario que esta logeado
     * 
     * @param string $table Nombre de la tabla
     * @access public
     * @return int
     */
    public function clave_cliente($id_usuario) {
        $this->db->select('usu_usuario, usutip_id_asignado, usu_nombre, usu_apellido_paterno, usu_apellido_materno');
        $this->db->from('usu_usuarios_mstr');
        $this->db->join('usutip_usuarios_tipos_det','usu_id = usutip_id_asignado','INNER');
        $this->db->where('usutip_id_usuario', $id_usuario);
        $this->db->where('usu_estatus', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) 
            return $query->row();
        else 
            return false;
    }
}

/* End of file modelo_generico_model.php */
/* Location: ./application/censos/models/modelo_generico_model.php */  