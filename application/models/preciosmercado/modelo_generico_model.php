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

    public function get_tipo_clase(){
        $this->db->select('idtipo_clase,clase');
        $this->db->from('tipo_x_clase');
        $this->db->join('clase' , 'clase.idclase = tipo_x_clase.idclase');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}
