<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Inversion_model extends My_Model {
	function __construct(){
    	parent::__construct();
	}

// Contador de datos en el flujo

    function contadorflujo(){
      //  $consulta = $this->db->count_all('cued_cuentas_det');
      //  return $consulta;
        $this->db->select( 'COUNT(*) AS `contador`' );
        $this->db->where('cued_fecha = CURDATE();');
        $query = $this->db->get ('cued_cuentas_det' );
        return $query->row ()->contador;
    }
// Ceros *****
    function cuentasflujo(){
        $this->db->select('cue_id');
        $this->db->where('cue_es_inversion', '0');
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
    
// Saldo anterior *****
    function flujoinvfecha(){
        $this->db->select('*');
        $this->db->join('cued_cuentas_det', 'cued_id = cue_id');
        $this->db->where('cue_es_inversion', '1');
        $this->db->order_by('cued_fecha', 'desc');
        $this->db->limit(1);
        $dat = $this->db->get('cue_cuentas_mstr');
        return $dat->result();
    }
    function cuentasflujoinv($fech){
        $this->db->select('*');
        $this->db->join('cued_cuentas_det', 'cued_id = cue_id');
        $this->db->where('cue_es_inversion', '1');
        $this->db->where('cued_fecha', $fech);
        $dat = $this->db->get('cue_cuentas_mstr');
        return $dat->result();
    }
    function agregarsaldoant($fecha,$datos){
        $this->db->insert('cued_cuentas_det',
             array(
                'cued_id' => $datos['cued_id'],
                'cued_fecha' => $fecha,
                'cued_sald_ini' => $datos['cued_sald_fin'],
                'cued_cheq_circ' => 0,
                'cued_cheques' => 0,
                'cued_pagos_lin' => 0,
                'cued_depos_fir' => 0,
                'cued_depos_24h' => 0,
                'cued_sald_fin' => $datos['cued_sald_fin']               
                 ));
    }
    function agregarsaldoantinv($fecha,$datos){
        $this->db->insert('cueinv_inversiones_det',
             array(
                'cueinv_id' => $datos['cued_id'],
                'cueinv_fecha' => $fecha,
                'cueinv_sald_ini' => $datos['cued_sald_fin'],
                'cueinv_sald_fin' => 0,
                'cueinv_tasa_bruta' => 0,
                'cueinv_tasa_neta' => 0,
                'cueinv_int_gene' => 0,
                'cueinv_dias' => 0,
                'cueinv_ocargos' => 0,
                'cueinv_ocargos' => 0,
                'cueinv_oabonos' => 0,
                'cueinv_descripcion' => 0,        
                 ));
    }

    function flujocuentasinversion(){
        $this->db->select('*');
        $this->db->from('ban_bancos_mstr, une_uninegocio_mstr, cued_cuentas_det');
        $this->db->join('cueinv_inversiones_det', 'cued_id = cueinv_id' );
        $this->db->join('cue_cuentas_mstr', 'cue_id = cued_id');
        $this->db->where('cue_uninegocio_id = une_id');
        $this->db->where('ban_id = cue_banco_id');
        $this->db->where('cued_fecha = cueinv_fecha');
        $this->db->where('cued_fecha = CURDATE()');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta;
        else return false;
    }

    function cuentasinversion(){
        $this->db->select('*');
        $this->db->from('cued_cuentas_det,ban_bancos_mstr,une_uninegocio_mstr');
        $this->db->join('cueinv_inversiones_det', 'cueinv_id = cued_id AND cued_fecha = cueinv_fecha' );
        $this->db->join('cue_cuentas_mstr', 'cue_id = cued_id');
        $this->db->where('cue_uninegocio_id = une_id');
        $this->db->where('ban_id = cue_banco_id');
        $this->db->where('cue_es_inversion', '1');
        $this->db->group_by('cued_id');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;

    }

    function actualizardatosinv($id,$cueinv_sald_ini,$datos,$fecha,$rendi,$tasab,$tasan){
        $datos = array(
                'cueinv_sald_ini' => $cueinv_sald_ini,
                'cueinv_sald_fin' => $datos['cueinv_sald_fin'],
                'cueinv_dias' => $datos['cueinv_dias'],
                'cueinv_tasa_bruta' => $tasab,
                'cueinv_tasa_neta' => $tasan,
                'cueinv_int_gene' => $rendi,
                 );
        $this->db->where('cueinv_id',$id);
        $this->db->where('cueinv_fecha',$fecha);
        $query = $this->db->update('cueinv_inversiones_det',$datos);
    }
    
    function actualizarsaldof($id,$datos,$fecha,$cueinv_sald_ini,$cueinv_sald_fin){
        $datos = array(
                'cued_sald_ini' => $cueinv_sald_ini,
                'cued_sald_fin' => $cueinv_sald_fin,
                 );
        $this->db->where('cued_id',$id);
        $this->db->where('cued_fecha',$fecha);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }

    function obtenertods(){
        $this->db->distinct();
        $this->db->select('une_nombre, une_id');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr', 'tra_traspasos_mstr.tra_cue_orig_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha','left');
        $this->db->where('cue_cuentas_mstr.cue_id = cued_cuentas_det.cued_id');     
        $this->db->where('cue_cuentas_mstr.cue_uninegocio_id = une_uninegocio_mstr.une_id');
        $this->db->where('ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->order_by('une_nombre', 'asc');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }

    // Insert *** Agregar Traspaso ***
    function nuevotraspaso($data,$fecha,$id_o,$id_d){
        $this->db->where('tra_cue_orig_id',$id_o);
        $this->db->where('tra_cue_dest_id',$id_d);
        $this->db->where('tra_fecha',$fecha);
        $query = $this->db->get('tra_traspasos_mstr');
        $datos = array(
            'tra_cue_orig_id'=> $data['tra_cue_orig_id'],
            'tra_cue_dest_id' => $data['tra_cue_dest_id'],
            'tra_monto' => $data['tra_monto'],
            'tra_descripcion' => $data['tra_descripcion'],
            'tra_responsable' => $data['tra_responsable'],
            'tra_fecha' => $fecha,
            'tra_tipomov' => $data['tipo'],

        );

        if ($query->num_rows() > 0)
        {
            $this->db->where('tra_cue_orig_id',$id_o);
            $this->db->where('tra_cue_dest_id',$id_d);
            $this->db->where('tra_fecha',$fecha);
            $this->db->update('tra_traspasos_mstr', $datos);

        }
        else
        {
            $this->db->insert('tra_traspasos_mstr', $datos);
        }
    
    }
// Update *** Actualizar saldo flujo cuenta origen *** Traspaso
    function actualizarsaldoorigen($saldonuevoorigen,$id_o,$fecha){
        $datos = array(
                'cued_sald_fin' => $saldonuevoorigen,
                 );
        $this->db->where('cued_id',$id_o);
        $this->db->where('cued_fecha',$fecha);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }
    function actualizarsaldodestino($saldonuevodestino,$id_d,$fecha){
        $datos = array(
                'cued_sald_fin' => $saldonuevodestino,
                 );
        $this->db->where('cued_id',$id_d);
        $this->db->where('cued_fecha',$fecha);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }

    function actualizarsaldoinv($saldonuevoorigen,$id_o,$fecha){
        $datos = array(
                'cueinv_sald_fin' => $saldonuevoorigen,
                 );
        $this->db->where('cueinv_id',$id_o);
        $this->db->where('cueinv_fecha',$fecha);
        $query = $this->db->update('cueinv_inversiones_det',$datos);
    }


}