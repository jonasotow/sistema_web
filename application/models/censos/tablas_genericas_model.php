<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  Tablas_genericas_model Class
 *
 *  @category:  Modelo
 *  @author:    
 */
class Tablas_genericas_model extends CI_Model {

    var $tblg_id_tabla_generica = '';
    var $tblg_tabla = '';
    var $tblg_valor = '';
    var $tblg_descripcion = '';
    var $tblg_comentarios = '';

    function __construct() {
        parent::__construct();
    }

    /**
     * Regresa la lista de las tablas genericas
     * 
     * @access public
     * @return array || boolean
     */
    function find($id = null) {
        if (!is_null($id)) {
            $this->db->select('*');
        } else {
            $this->db->select('tblg_id_tabla_generica,tblg_tabla,tblg_descripcion,tblg_comentarios');
        }
        $this->db->from('tblg_tablas_genericas_mstr');
        if (!is_null($id)) {
            $this->db->where('tblg_id_tabla_generica', $id);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    /**
     * Inserta un tabla generica
     * 
     * @access public
     * @param  array
     * @return boolean
     */
    function insert_tabla_generica($data) {
        $this->db->trans_begin();
        $this->db->insert('tblg_tablas_genericas_mstr', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    /**
     * Actualiza una tabla generica
     * 
     * @access public
     * @param int
     * @param array
     * @return boolean   
     */
    function update_tabla_generica($id, $data) {
        $this->db->trans_begin();
        $this->db->update('tblg_tablas_genericas_mstr', $data, array('tblg_id_tabla_generica' => $id['id_tabla_generica']));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

}

/* End of file tablas_genericas_model.php */
/* Location: ./application/censos/models/tablas_genericas_model.php */