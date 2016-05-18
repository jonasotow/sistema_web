<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Inversion_model extends My_Model {
	function __construct(){
    	parent::__construct();
	}

    function contadorflujo(){
      //  $consulta = $this->db->count_all('cued_cuentas_det');
      //  return $consulta;
        $this->db->select( 'COUNT(*) AS `contador`' );
        $this->db->where('cued_fecha = CURDATE();');
        $query = $this->db->get ( 'cued_cuentas_det' );
        return $query->row ()->contador;
    }
    function obtenercuentasflujo(){
        $this->db->select('cue_id');
        $dat = $this->db->get('cue_cuentas_mstr');
        return $dat->result();
    }
    function agregarsaldoencero($fecha,$data){
        $this->db->insert('cued_cuentas_det',
             array(
                'cued_id' => $data['cued_id'],
                'cued_fecha' => $fecha,
                'cued_sald_ini' => 0,
                'cued_cheq_circ' => 0,
                'cued_cheques' => 0,
                'cued_pagos_lin' => 0,
                'cued_depos_fir' => 0,
                'cued_depos_24h' => 0,
                'cued_sald_fin' => 0                
                 ));
    }

    function cuentasinversion(){
        $this->db->select('*');
        $this->db->select_sum('tra_monto');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr','tra_traspasos_mstr.tra_cue_dest_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha', 'left');
        $this->db->join('cueinv_inversiones_det','cueinv_inversiones_det.cueinv_id = cued_cuentas_det.cued_id');
        $this->db->where('cue_cuentas_mstr.cue_id = cued_cuentas_det.cued_id');     
        $this->db->where('cue_cuentas_mstr.cue_uninegocio_id = une_uninegocio_mstr.une_id');
        $this->db->where('ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->where('cue_es_inversion', '1');
        $this->db->where('cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->group_by('cued_id ');
        $this->db->order_by('cued_id', 'asc');
        $this->db->order_by('cue_descripcion', 'asc');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta;
        else return false;
    }

}