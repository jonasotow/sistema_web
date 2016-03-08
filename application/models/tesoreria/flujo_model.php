<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Flujo_model extends My_Model {
	function __construct(){
    	parent::__construct();
	}

// Consultas

    function saldototalune($id,$divisa){
        $this->db->select('*');
        $this->db->select_sum('cued_sald_ini');
        $this->db->select_sum('cued_cheq_circ');
        $this->db->select_sum('cued_cheques');
        $this->db->select_sum('cued_pagos_lin');
        $this->db->select_sum('cued_depos_fir');
        $this->db->select_sum('cued_depos_24h');
        $this->db->select_sum('cued_sald_fin');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->where('cue_cuentas_mstr.cue_id = cued_cuentas_det.cued_id');     
        $this->db->where('cue_cuentas_mstr.cue_uninegocio_id = une_uninegocio_mstr.une_id');
        $this->db->where('ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->where('une_id', $id);
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->order_by('cued_id', 'asc');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }

    function saldototalune_trapaso($id,$divisa){
        $this->db->select('*');
        $this->db->select_sum('tra_monto');
        $this->db->join('tra_traspasos_mstr','tra_traspasos_mstr.tra_cue_dest_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->where('cue_cuentas_mstr.cue_id = cued_cuentas_det.cued_id');     
        $this->db->where('cue_cuentas_mstr.cue_uninegocio_id = une_uninegocio_mstr.une_id');
        $this->db->where('ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->where('une_id', $id);
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->order_by('cued_id', 'asc');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }
    function obtenermovcuebanunes($id,$divisa){
        $this->db->select('*');
        $this->db->select_sum('tra_monto');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr','tra_traspasos_mstr.tra_cue_dest_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha', 'left');
        $this->db->where('cue_cuentas_mstr.cue_id = cued_cuentas_det.cued_id');     
        $this->db->where('cue_cuentas_mstr.cue_uninegocio_id = une_uninegocio_mstr.une_id');
        $this->db->where('ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->where('une_id', $id);
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->group_by('cued_id ');
        $this->db->order_by('cued_id', 'asc');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta;
        else return false;
    }
    function obtenertodo($id,$divisa){
        $this->db->distinct();
        $this->db->select('cued_id, ban_nombre,cue_nombre, cue_numero, cued_sald_fin, cue_divisa');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr', 'tra_traspasos_mstr.tra_cue_orig_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha','left');
        $this->db->where('cue_cuentas_mstr.cue_id = cued_cuentas_det.cued_id');     
        $this->db->where('cue_cuentas_mstr.cue_uninegocio_id = une_uninegocio_mstr.une_id');
        $this->db->where('ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->where('une_id', $id);
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('cued_fecha = CURDATE();'); // filtro por fecha actual.
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }
    function obtenerUnidades(){
        $query = $this->db->get('une_uninegocio_mstr');
        if($query->num_rows() > 0) return $query;
        else return false;
    }
    function obtenerUnidad($id){
        $this->db->where('une_id',$id);
        $query = $this->db->get('une_uninegocio_mstr');
        if($query->num_rows() > 0) return $query;
        else return false;
    }

    function flujoindex($id){
        $this->db->select('*');
        $this->db->from('cue_cuentas_mstr');
        $this->db->join('une_uninegocio_mstr', 'une_uninegocio_mstr.une_id = cue_cuentas_mstr.cue_uninegocio_id');
        $this->db->where('une_id',$id); 
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta;
        else return false;
    }

    function obtenercuentaune($id){
        $this->db->select('*');
        $this->db->from('cue_cuentas_mstr');
        $this->db->join('ban_bancos_mstr', 'ban_bancos_mstr.ban_id =  cue_cuentas_mstr.cue_banco_id');
        $this->db->join('cued_cuentas_det', 'cued_cuentas_det.cued_id =  cue_cuentas_mstr.cue_id');        
        $this->db->join('une_uninegocio_mstr', 'une_uninegocio_mstr.une_id = cue_cuentas_mstr.cue_uninegocio_id');
        $this->db->where('cued_id',$id); 
        $this->db->where('cued_fecha = CURDATE();');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta;
        else return false;
    }

    function obternertraspasoenflujoorigen($id){
        $this->db->select('*');
        $this->db->from('cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr', 'tra_traspasos_mstr.tra_cue_dest_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha', 'left');
        $this->db->where('cued_id',$id);
        $this->db->where('cued_fecha = CURDATE();');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta;
        else return false;

    }
    function obternertraspasoenflujodestino($id){
        $this->db->select('*');
        $this->db->from('cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr', 'tra_traspasos_mstr.tra_cue_orig_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha', 'left');
        $this->db->where('cued_id',$id);
        $this->db->where('cued_fecha = CURDATE();');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta;
        else return false;

    }
    function obtenerBancos(){
        $query = $this->db->get('ban_bancos_mstr');
        if($query->num_rows() > 0) return $query->result();
        else return false;
    }
    function obtenerCuentasBancosUnes($id){
        $this->db->where('cue_id',$id);
        $this->db->from('cue_cuentas_mstr');
        $this->db->join('ban_bancos_mstr', 'ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->join('une_uninegocio_mstr', 'une_uninegocio_mstr.une_id = cue_cuentas_mstr.cue_uninegocio_id');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta;
        else return false;
    }

// Contador de datos en el flujo

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
    
// Insert *** Agregar Traspaso ***
    function nuevotraspaso($data,$fecha){
        $this->db->insert('tra_traspasos_mstr',
            array(
                'tra_cue_orig_id'=> $data['tra_cue_orig_id'],
                'tra_cue_dest_id' => $data['tra_cue_dest_id'],
                'tra_monto' => $data['tra_monto'],
                'tra_descripcion' => $data['tra_descripcion'],
                'tra_fecha' => $fecha,

                 ));
    }

// Update *** Actualizar saldo flujo cuenta origen ***
    function actualizarsaldoorigen($saldonuevoorigen,$id_o){
        $datos = array(
                'cued_sald_fin' => $saldonuevoorigen,
                 );
        $this->db->where('cued_id',$id_o);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }

// Update *** Actualizar saldo flujo cuenta destino ***
    function actualizarsaldodestino($saldonuevodestino,$id){
        $datos = array(
                'cued_sald_fin' => $saldonuevodestino,
                 );
        $this->db->where('cued_id',$id);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }

// Update *** Editar flujo ***
    function actualizarFlujo($id,$data,$fecha){
        $datos = array(
                'cued_sald_ini'=> $data['cued_sald_ini'],
                'cued_cheq_circ' => $data['cued_cheq_circ'],
                'cued_cheques' => $data['cued_cheques'],
                'cued_pagos_lin' => $data['cued_pagos_lin'],
                'cued_depos_fir' => $data['cued_depos_fir'],
                'cued_depos_24h' => $data['cued_depos_24h'],
                'cued_sald_fin' => $data['cued_sald_fin']
                 );
        $this->db->where('cued_id',$id);
        $this->db->where('cued_fecha',$fecha);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }

}