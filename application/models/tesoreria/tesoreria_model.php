<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Tesoreria_model extends My_Model {
  function __construct(){
    	parent::__construct();
    }

// Modelos de Bancos -->
    function nuevoBanco($data){
    	$this->db->insert('ban_bancos_mstr',array('ban_nombre'=>$data['nombre_bancos']));
    }
    function obtenerBancos(){
    	$query = $this->db->get('ban_bancos_mstr');
    	if($query->num_rows() > 0) return $query;
    	else return false;
    }
    function obtenerBanco($id){
        $this->db->where('ban_id',$id);
        $query = $this->db->get('ban_bancos_mstr');
        if ($query->num_rows() > 0){
           return $query->row();
        }
        return null;
    }
    function actualizarBanco($id, $data){
        $datos = array('ban_nombre'=>$data['nombre_bancos']);
        $this->db->where('ban_id',$id);
        $query = $this->db->update('ban_bancos_mstr',$datos);
    }
    function deleteBanco($id){ 
        $this->db->delete('ban_bancos_mstr',array('ban_id'=>$id));
    }

// Modelo de Beneficiarios -->
    function nuevoBeneficiario($data){
        $this->db->insert('ben_beneficiarios_mstr',array('ben_nombre'=>$data['nombre_beneficiarios']));
    }
    function obtenerBeneficiarios(){
        $query = $this->db->get('ben_beneficiarios_mstr');
        if($query->num_rows() > 0) return $query;
        else return false;
    }
    function obtenerBeneficiario($id){
        $this->db->where('ben_id',$id);
        $query = $this->db->get('ben_beneficiarios_mstr');
        if ($query->num_rows() > 0){
           return $query->row();
        }
        return null;
    }
    function actualizarBeneficiario($id, $data){
        $datos = array('ben_nombre'=>$data['nombre_beneficiarios']);
        $this->db->where('ben_id',$id);
        $query = $this->db->update('ben_beneficiarios_mstr',$datos);
    }
    function deleteBeneficiario($id){ 
        $this->db->delete('ben_beneficiarios_mstr',array('ben_id'=>$id));
    }

// Modelo de Unidad de Negocios -->
    function nuevoUnidad($data){
        $this->db->insert('une_uninegocio_mstr',array('une_nombre'=>$data['nombre_unidades']));
    }
    function obtenerUnidades(){
        $query = $this->db->get('une_uninegocio_mstr');
        if($query->num_rows() > 0) return $query;
        else return false;
    }
    function obtenerUnidad($id){
        $this->db->where('une_id',$id);
        $query = $this->db->get('une_uninegocio_mstr');
        if ($query->num_rows() > 0){
           return $query->row();
        }
        return null;
    }
    function actualizarUnidad($id, $data){
        $datos = array('une_nombre'=>$data['nombre_unidades']);
        $this->db->where('une_id',$id);
        $query = $this->db->update('une_uninegocio_mstr',$datos);
    }
    function deleteUnidad($id){ 
        $this->db->delete('une_uninegocio_mstr',array('une_id'=>$id));
    }

// Modelo de Unidad de Lineas -->
    function nuevoLinea($data){
        $this->db->insert('lin_lineas_mstr',
            array(
                'lin_banco_id'=>$data['lin_banco_id'], 
                'lin_descripcion'=>$data['linea_descripcion'], 
                'lin_autorizado'=>$data['lin_autorizado'],
                'lin_disponible'=>$data['lin_disponible'],
                'lin_es_largo_plazo'=>$data['lin_es_largo_plazo']
                 ));
    }
    function obtenerLineas(){
        $query = $this->db->get('lin_lineas_mstr');
        if($query->num_rows() > 0) return $query;
        else return false;
    }
    function obtenerLinea($id){
        $this->db->where('lin_id',$id);
        $query = $this->db->get('lin_lineas_mstr');
        if ($query->num_rows() > 0){
           return $query->row();
        }
        return null;
    }
    function obtenerLineasBancos(){
        $this->db->select('*');
        $this->db->from('lin_lineas_mstr');
        $this->db->join('ban_bancos_mstr', 'ban_bancos_mstr.ban_id = lin_lineas_mstr.lin_banco_id');
        $this->db->order_by("lin_id", "asc");          
        $consulta = $this->db->get();
        return $consulta;
    }
    function obtenerLineasBanco($id){
        $this->db->where('lin_id',$id);
        $this->db->from('lin_lineas_mstr');
        $this->db->join('ban_bancos_mstr', 'ban_bancos_mstr.ban_id = lin_lineas_mstr.lin_banco_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
           return $query->row();
        }
        return null;
    }
    function deleteLinea($id){ 
        $this->db->delete('lin_lineas_mstr',array('lin_id'=>$id));
    }
    function actualizarLinea($id, $data){
        $datos = array(
                'lin_banco_id'=>$data['lin_banco_id'], 
                'lin_descripcion'=>$data['linea_descripcion'], 
                'lin_autorizado'=>$data['lin_autorizado'],
                'lin_disponible'=>$data['lin_disponible'],
                'lin_es_largo_plazo'=>$data['lin_es_largo_plazo']
                 );
        $this->db->where('lin_id',$id);
        $query = $this->db->update('lin_lineas_mstr',$datos);
    }

// Modelo de Cuentas -->
    function nuevoCuenta($data,$ncids){
        $this->db->insert('cue_cuentas_mstr',
            array(
                'cue_id'=>$ncids,
                'cue_banco_id'=>$data['cue_banco_id'], 
                'cue_uninegocio_id'=>$data['cue_uninegocio_id'], 
                'cue_numero'=>$data['cue_numero'],
                'cue_nombre'=>$data['cue_nombre'],
                'cue_descripcion'=>$data['cue_descripcion'],
                'cue_divisa'=>$data['cue_divisa'],
                'cue_es_inversion'=>$data['cue_es_inversion']
                 ));
    }
    function contarcuentas(){
        $dbBase = $this->load->database('tesoreria',TRUE);        
        $this->db->select('MAX(cue_id) AS cid');
        $query = $this->db->get('cue_cuentas_mstr');
        if ($query->num_rows() > 0){
           return $query->row();
        }
        return null;
    }
    function nuevoCuentaCero($ncids,$fecha){
        $dbBase = $this->load->database('tesoreria',TRUE);        
        $this->db->insert('cued_cuentas_det',
             array(
                'cued_id' => $ncids,
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

    function obtenerCuentas(){
        $query = $this->db->get('cue_cuentas_mstr');
        if($query->num_rows() > 0) return $query;
        else return false;
    }
    function obtenerCuenta($id){
        $this->db->where('cue_id',$id);
        $query = $this->db->get('cue_cuentas_mstr');
        if ($query->num_rows() > 0){
           return $query->row();
        }
        return null;
    }
    function obtenerCuentasBancosUne(){
        $this->db->select('*');
        $this->db->from('cue_cuentas_mstr');
        $this->db->join('ban_bancos_mstr', 'ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->join('une_uninegocio_mstr', 'une_uninegocio_mstr.une_id = cue_cuentas_mstr.cue_uninegocio_id');
        $this->db->order_by("cue_id", "asc");         
        $consulta = $this->db->get();
        return $consulta;
    }
    function obtenerCuentasBancosUnes($id){
        $this->db->where('cue_id',$id);
        $this->db->from('cue_cuentas_mstr');
        $this->db->join('ban_bancos_mstr', 'ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->join('une_uninegocio_mstr', 'une_uninegocio_mstr.une_id = cue_cuentas_mstr.cue_uninegocio_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
           return $query->row();
        }
        return null;
    }
    function deleteCuenta($id){ 
        $this->db->delete('cue_cuentas_mstr',array('cue_id'=>$id));
    }
    function actualizarCuenta($id, $data){
        $datos = array(
                'cue_banco_id'=>$data['cue_banco_id'], 
                'cue_uninegocio_id'=>$data['cue_uninegocio_id'], 
                'cue_numero'=>$data['cue_numero'],
                'cue_nombre'=>$data['cue_nombre'],
                'cue_descripcion'=>$data['cue_descripcion'],
                'cue_divisa'=>$data['cue_divisa'],
                'cue_es_inversion'=>$data['cue_es_inversion']
                 );
        $this->db->where('cue_id',$id);
        $query = $this->db->update('cue_cuentas_mstr',$datos);
    }
}

// $variable = "consulta";
// $this->db-> query($variable); 
