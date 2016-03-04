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
     * Obtiene valores de tabla generica
     * 
     * @access public
     * @param string
     * @return array || boolean
     */
    function get_valor_tabla_generica($tabla) {
        $this->db->select('*');
        $this->db->from('tblg_tablas_genericas_mstr as t');
        $this->db->join('tblgval_tablas_genericas_valores_det as tv', 't.tblg_id_tabla_generica = tv.tblgval_id_tabla_generica', 'INNER');
        $this->db->where('t.tblg_tabla', $tabla);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Obtiene los estados de México
     * 
     * @access public
     * @return array || boolean
     */
    function get_estados() {
        $this->db->select('*');
        $this->db->from('estados');
        $this->db->where('active', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function get_municipios($entidad) {
        $this->db->select('*');
        $this->db->from('tbl_municipios');
        $this->db->where('cve_ent', $entidad);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function get($tabla,$campos = null,$where = null){
		if (!is_null($campos))
			$this->db->select($campos);	
		if (!is_null($where))
			$this->db->where($where);
		$query = $this->db->get($tabla);
		return $query->result();
	}

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