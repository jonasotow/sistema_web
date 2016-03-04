<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 * Tablas_genericas_valores_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Author Alfredo Garcia
 * @link http://localhost/sistema_web/censos.php/
 */
class Tablas_genericas_valores_model extends CI_Model {

    // Variables
    var $tblgval_id_tabla_generica_valor = '';
    var $tblgval_id_tabla_generica = '';
    var $tblgval_valor = '';
    var $tblgval_tabla_relacionar = '';

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
    }

    /**
     * Muestra la consulta de cuantas granjas existene en la tabla gran_granjas_mstr 
     * @return [type] [description]
     */
    function find($limit = null, $id2 = null, $id = null) {
        if (!is_null($id)) {
            $this->db->select('*');
        } else {
            $this->db->select('tblgval_id_tabla_generica_valor, tblg_tabla, tblgval_valor, tblgval_tabla_relacionar');
        }
        $this->db->from('tblgval_tablas_genericas_valores_det');
        $this->db->join('tblg_tablas_genericas_mstr', 'tblgval_id_tabla_generica = tblg_id_tabla_generica', 'INNER');
        if (!is_null($id)) {
            $this->db->where('tblgval_id_tabla_generica_valor', $id);
        }
        if (!is_null($limit)) {
            $rows = ((int) $id2 - 1) * (int) $limit < 0 ? 0 : ((int) $id2 - 1) * (int) $limit;
            $this->db->limit($limit, $rows);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    /**
     * [insert_tabla_generica_valor description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function insert_tabla_generica_valor($data) {
        $this->db->trans_begin();
        $this->db->insert('tblgval_tablas_genericas_valores_det', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    /**
     * [update_tabla_generica_valor description]
     * @param  [type] $id   [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function update_tabla_generica_valor($id, $data) {
        $this->db->trans_begin();
        $this->db->update('tblgval_tablas_genericas_valores_det', $data, array('tblgval_id_tabla_generica_valor' => $id['id']));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

}

/* End of file tablas_genericas_valores_model.php */
/* Location: ./application/censos/models/tablas_genericas_valores_model.php */