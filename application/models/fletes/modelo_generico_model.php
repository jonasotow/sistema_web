<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  Modelo_generico_model
 *
 *  @category:  Modelo
 *  @author:    Alfredo Garcia
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

}

/* End of file modelo_generico_model.php */
/* Location: ./application/censos/models/modelo_generico_model.php */  