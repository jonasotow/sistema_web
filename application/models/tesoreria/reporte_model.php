<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reporte_model extends My_Model {
	function __construct(){
    	parent::__construct();
	}
    function reportetrapasos(){
        $this->db->select('tra_fecha, tra_cue_dest_id, T1.cue_nombre AS T1C, T1.cue_numero AS T1N, tra_cue_orig_id, T2.cue_nombre AS T2C, T2.cue_numero AS T2N, une_nombre, tra_monto, tra_descripcion, T1.cue_divisa AS divisa');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cued_cuentas_det, tra_traspasos_mstr');
        $this->db->join('cue_cuentas_mstr as T1 ', 'T1.cue_id = tra_cue_orig_id' ,'inner');
        $this->db->join('cue_cuentas_mstr as T2 ', 'T2.cue_id = tra_cue_dest_id' ,'inner');
        $this->db->where('T1.cue_id = cued_id');     
        $this->db->where('T1.cue_uninegocio_id = une_id');
        $this->db->where('ban_id = T1.cue_banco_id');
        $this->db->where('tra_fecha = cued_fecha'); 
        $this->db->where('tra_fecha = CURDATE();'); // filtro por fecha actual.
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }
    function reportetrapasos_f($fecha){
        $this->db->select('tra_fecha, tra_cue_dest_id, T1.cue_nombre AS T1C, T1.cue_numero AS T1N, tra_cue_orig_id, T2.cue_nombre AS T2C, T2.cue_numero AS T2N, une_nombre, tra_monto, tra_descripcion, T1.cue_divisa AS divisa');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cued_cuentas_det, tra_traspasos_mstr');
        $this->db->join('cue_cuentas_mstr as T1 ', 'T1.cue_id = tra_cue_orig_id' ,'inner');
        $this->db->join('cue_cuentas_mstr as T2 ', 'T2.cue_id = tra_cue_dest_id' ,'inner');
        $this->db->where('T1.cue_id = cued_id');     
        $this->db->where('T1.cue_uninegocio_id = une_id');
        $this->db->where('ban_id = T1.cue_banco_id');
        $this->db->where('tra_fecha = cued_fecha');
        $this->db->where('tra_fecha', $fecha); // filtro por fecha actual.
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }

}

