<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Reporte_model extends My_Model {
	function __construct(){
    	parent::__construct();
	}

    function reportcta(){
        $this->db->select('*');
        $this->db->from('cue_cuentas_mstr, cued_cuentas_det, une_uninegocio_mstr');
        $this->db->where('cue_id = cued_id');
        $this->db->where('cue_uninegocio_id = une_id');
        $this->db->group_by('cue_id');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }   


    function reportecd_f($fecha){
        $this->db->select('tra_fecha, tra_cue_dest_id, T1.cue_descripcion as T1CD, T1.cue_nombre AS T1C, T1.cue_numero AS T1N, tra_cue_orig_id, T2.cue_nombre AS T2C, T2.cue_numero AS T2N, une_nombre, tra_monto, tra_tc, tra_divisa, tra_descripcion, tra_responsable, T1.cue_divisa AS divisa, B2.ban_nombre AS B2N, B1.ban_nombre AS B1N');
        $this->db->from('une_uninegocio_mstr, cued_cuentas_det, tra_traspasos_mstr');
        $this->db->join('cue_cuentas_mstr as T1 ', 'T1.cue_id = tra_cue_orig_id' ,'inner');
        $this->db->join('cue_cuentas_mstr as T2 ', 'T2.cue_id = tra_cue_dest_id' ,'inner');
        $this->db->join('ban_bancos_mstr as B1 ', 'B1.ban_id = T1.cue_banco_id' ,'inner');
        $this->db->join('ban_bancos_mstr as B2 ', 'B2.ban_id = T2.cue_banco_id' ,'inner');
        $this->db->join('ban_bancos_mstr as B3 ', 'B3.ban_id = tra_banco_id' ,'full');
        $this->db->where('T1.cue_id = cued_id');     
        $this->db->where('T1.cue_uninegocio_id = une_id');
        $this->db->where('tra_fecha = cued_fecha');
        $this->db->where('tra_descripcion = "COMPRA DE DIVISAS"');
        $this->db->where('tra_tipomov = "C"');
        $this->db->where('tra_fecha', $fecha); // filtro por fecha actual.
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }

    function reportetrapasos_f($fecha){
        $this->db->select('tra_fecha, tra_cue_dest_id, T1.cue_descripcion as T1CD, T1.cue_nombre AS T1C, T1.cue_numero AS T1N, tra_cue_orig_id, T2.cue_nombre AS T2C, T2.cue_numero AS T2N, une_nombre, tra_monto, tra_descripcion, tra_responsable, T1.cue_divisa AS divisa, B2.ban_nombre AS B2N, B1.ban_nombre AS B1N');
        $this->db->from('une_uninegocio_mstr, cued_cuentas_det, tra_traspasos_mstr');
        $this->db->join('cue_cuentas_mstr as T1 ', 'T1.cue_id = tra_cue_orig_id' ,'inner');
        $this->db->join('cue_cuentas_mstr as T2 ', 'T2.cue_id = tra_cue_dest_id' ,'inner');
        $this->db->join('ban_bancos_mstr as B1 ', 'B1.ban_id = T1.cue_banco_id' ,'inner');
        $this->db->join('ban_bancos_mstr as B2 ', 'B2.ban_id = T2.cue_banco_id' ,'inner');
        $this->db->where('T1.cue_id = cued_id');     
        $this->db->where('T1.cue_uninegocio_id = une_id');
        $this->db->where('tra_fecha = cued_fecha');
        $this->db->where('tra_tipomov = "1"');
        $this->db->where('tra_fecha', $fecha); // filtro por fecha actual.
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }

    function saldosunes_f($fecha){
        $this->db->select('*');
        $this->db->select_sum('cued_sald_ini');
        $this->db->select_sum('cued_cheq_circ');
        $this->db->select_sum('cued_cheques');
        $this->db->select_sum('cued_pagos_lin');
        $this->db->select_sum('cued_depos_fir');
        $this->db->select_sum('cued_depos_24h');
        $this->db->select_sum('tra_monto');
        $this->db->select_sum('cued_sald_fin');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr','tra_traspasos_mstr.tra_cue_dest_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha', 'left');
        $this->db->where('cue_cuentas_mstr.cue_id = cued_cuentas_det.cued_id');     
        $this->db->where('cue_cuentas_mstr.cue_uninegocio_id = une_uninegocio_mstr.une_id');
        $this->db->where('ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->where('cued_fecha', $fecha); // filtro por fecha actual.
        $this->db->group_by('une_nombre');
        $this->db->group_by('cue_divisa');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }
    
    function displaytipo(){
        $this->db->select('*');
        $this->db->from('tc_tcambio_det');
        $this->db->join('tc_tcambio_mstr', 'tc_tcambio_det.tcd_insti_id = tc_tcambio_mstr.tc_insti_id');
        $this->db->where('tcd_fecha = CURDATE()');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }


}

