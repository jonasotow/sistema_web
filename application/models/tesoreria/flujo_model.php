<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Flujo_model extends My_Model {
	function __construct(){
    	parent::__construct();
	}

// Consultas por JavaScript
    function montodetrsval($id_origen,$id_destino,$fecha,$tipo){
        $this->db->select('tra_fecha, tra_cue_dest_id, T1.cue_nombre, T1.cue_numero, tra_cue_orig_id, T2.cue_nombre, T2.cue_numero, une_nombre, tra_monto, tra_descripcion, tra_responsable, T1.cue_divisa');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cued_cuentas_det, tra_traspasos_mstr');
        $this->db->join('cue_cuentas_mstr as T1 ', 'T1.cue_id = tra_cue_orig_id');
        $this->db->join('cue_cuentas_mstr as T2 ', 'T2.cue_id = tra_cue_dest_id');
        $this->db->where('T1.cue_id = cued_id');     
        $this->db->where('T1.cue_uninegocio_id = une_id');
        $this->db->where('T1.cue_banco_id = ban_id');
        $this->db->where('tra_fecha = cued_fecha'); 
        $this->db->where('T1.cue_id', $id_origen); 
        $this->db->where('tra_fecha', $fecha); // filtro por fecha actual.
        $this->db->where('T2.cue_id', $id_destino);
        $this->db->where('tra_tipomov',$tipo);
        $consulta = $this->db->get();
        $cadena = "";
        foreach ($consulta->result_array() as $reg) {
            $cadena.="{$reg['tra_monto']}";
        }
        echo $cadena;
    
    }
       function montodetrshtml($id_origen,$id_destino,$fecha,$tipo){
        $this->db->select('tra_fecha, tra_cue_dest_id, T1.cue_nombre, T1.cue_numero, tra_cue_orig_id, T2.cue_nombre, T2.cue_numero, une_nombre, tra_monto, tra_descripcion, tra_responsable, T1.cue_divisa');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cued_cuentas_det, tra_traspasos_mstr');
        $this->db->join('cue_cuentas_mstr as T1 ', 'T1.cue_id = tra_cue_orig_id');
        $this->db->join('cue_cuentas_mstr as T2 ', 'T2.cue_id = tra_cue_dest_id');
        $this->db->where('T1.cue_id = cued_id');     
        $this->db->where('T1.cue_uninegocio_id = une_id');
        $this->db->where('T1.cue_banco_id = ban_id');
        $this->db->where('tra_fecha = cued_fecha'); 
        $this->db->where('T1.cue_id', $id_origen); 
        $this->db->where('tra_fecha', $fecha); // filtro por fecha actual.
        $this->db->where('T2.cue_id', $id_destino);
        $this->db->where('tra_tipomov',$tipo);
        $consulta = $this->db->get();
        $cadena = "";
        $html = "<div class='form-group trasant'>
                    <label class='control-label right col-xs-2 red'>Traspaso existente:</label>
                    <div class='input-group left col-xs-3' >
                    <div class='input-group-addon red'>$</div>";
        $html2 ="   </div
                </div>
                <label class='control-label col-xs-3 red'>Se modificará el importe</label>";

        foreach ($consulta->result_array() as $reg) {
            $cadena.="$html<input class='form-control red' disabled value='{$reg['tra_monto']}'> $html2";
        }
        echo $cadena;
    
    }
    function mcpagovim($idune, $cueogin, $divisa){
        $this->db->select('*');
        $this->db->from('cue_cuentas_mstr');
        $this->db->join('cued_cuentas_det', 'cued_cuentas_det.cued_id = cue_cuentas_mstr.cue_id');
        $this->db->join('ban_bancos_mstr', 'ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->join('une_uninegocio_mstr', 'une_uninegocio_mstr.une_id = cue_cuentas_mstr.cue_uninegocio_id');
        $this->db->where('une_id', $idune);
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('cued_id <>', $cueogin);
        $this->db->where('cued_fecha = CURDATE()'); 
        $this->db->order_by('cued_id', 'asc');
        $this->db->group_by('cued_id ');
        $consulta = $this->db->get();
      
        $cadena = "";
        $simbolo = "SALDO $";
        $html = "<option>-- Seleccione una Cuenta --</option>";
        foreach ($consulta->result_array() as $reg) {
            $cadena.="<option value='{$reg['cued_id']}|{$reg['cued_sald_fin']}|{$reg['cue_divisa']}|{$reg['une_id']}'>
            {$reg['ban_nombre']} {$reg['cue_nombre']} {$reg['cue_numero']} {$reg['cue_divisa']} $simbolo{$reg['cued_sald_fin']}</option>";
        }
        echo $html.$cadena;

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
        $this->db->where('tra_tipomov', '1' );
        $this->db->where('cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->order_by('cued_id', 'asc');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }

    function saldototalune_divisas($id,$divisa){
        $this->db->select('*');
        $this->db->select_sum('tra_monto');
        $this->db->join('tra_traspasos_mstr','tra_traspasos_mstr.tra_cue_dest_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->where('cue_cuentas_mstr.cue_id = cued_cuentas_det.cued_id');     
        $this->db->where('cue_cuentas_mstr.cue_uninegocio_id = une_uninegocio_mstr.une_id');
        $this->db->where('ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->where('une_id', $id);
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('tra_tipomov', 'C' );
        $this->db->where('cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->order_by('cued_id', 'asc');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }

    function saldototalune_pagov($id,$divisa){
        $this->db->select('*');
        $this->db->select_sum('tra_monto');
        $this->db->join('tra_traspasos_mstr','tra_traspasos_mstr.tra_cue_dest_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->where('cue_cuentas_mstr.cue_id = cued_cuentas_det.cued_id');     
        $this->db->where('cue_cuentas_mstr.cue_uninegocio_id = une_uninegocio_mstr.une_id');
        $this->db->where('ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->where('une_id', $id);
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('tra_tipomov', '0' );
        $this->db->where('cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->order_by('cued_id', 'asc');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }
    
    function saldototalune_ts($id,$divisa){
        $this->db->select('*');
        $this->db->select_sum('tra_monto');
        $this->db->join('tra_traspasos_mstr','tra_traspasos_mstr.tra_cue_dest_id = cued_cuentas_det.cued_id AND tra_traspasos_mstr.tra_fecha = cued_cuentas_det.cued_fecha');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->where('cue_cuentas_mstr.cue_id = cued_cuentas_det.cued_id');     
        $this->db->where('cue_cuentas_mstr.cue_uninegocio_id = une_uninegocio_mstr.une_id');
        $this->db->where('ban_bancos_mstr.ban_id = cue_cuentas_mstr.cue_banco_id');
        $this->db->where('une_id', $id);
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('tra_tipomov', 'S' );
        $this->db->where('cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->order_by('cued_id', 'asc');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }

    function obtenermovcuebanunes($id,$divisa){
        //$this->db->select('*, IF(tra_tipomov = "C", abs(tra_monto), abs(0)) as CV, IF(tra_tipomov = "1", abs(tra_monto),sum(tra_monto) as TP, sum(tra_monto) as tra_montoss');
        $this->db->select('*, sum(IF(tra_tipomov = "0", (tra_monto), abs(0))) as PV, sum(IF(tra_tipomov = "S", (tra_monto), abs(0))) as TS, sum(IF(tra_tipomov = "C", (tra_monto), abs(0))) as CD, sum(IF(tra_tipomov = "1", abs(tra_monto), abs(0))) as TP');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr','tra_cue_dest_id = cued_id AND tra_fecha = cued_fecha', 'left');
        $this->db->where('cue_id = cued_id');     
        $this->db->where('cue_uninegocio_id = une_id');
        $this->db->where('ban_id = cue_banco_id');
        $this->db->where('une_id', $id);
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('cue_es_inversion', 0);
        $this->db->where('cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->group_by('cued_id ');
        $this->db->order_by('cue_descripcion', 'asc');
        $this->db->order_by('ban_nombre', 'asc');
        $this->db->order_by('cue_es_inversion', 'asc');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta;
        else return false;
    }

    function ctatotal(){
        //$this->db->select('*, IF(tra_tipomov = "C", abs(tra_monto), abs(0)) as CV, IF(tra_tipomov = "1", abs(tra_monto),sum(tra_monto) as TP, sum(tra_monto) as tra_montoss');
        $this->db->select('*, sum(IF(tra_tipomov = "0", (tra_monto), abs(0))) as PV, sum(IF(tra_tipomov = "S", (tra_monto), abs(0))) as TS, sum(IF(tra_tipomov = "C", (tra_monto), abs(0))) as CD, sum(IF(tra_tipomov = "1", abs(tra_monto), abs(0))) as TP');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cue_cuentas_mstr, cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr','tra_cue_dest_id = cued_id AND tra_fecha = cued_fecha', 'left');
        $this->db->where('cue_id = cued_id');     
        $this->db->where('cue_uninegocio_id = une_id');
        $this->db->where('ban_id = cue_banco_id');
        $this->db->where('cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->group_by('cued_id ');
        $this->db->order_by('une_nombre', 'asc');
        $this->db->order_by('cue_descripcion', 'asc');
        $this->db->order_by('ban_nombre', 'asc');
        $this->db->order_by('cue_es_inversion', 'asc');
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
    function obtenerUnidades(){
        $this->db->order_by('une_nombre', 'asc');
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

    function flujoindex($id){
        $this->db->select('*');
        $this->db->from('cue_cuentas_mstr');
        $this->db->join('une_uninegocio_mstr', 'une_uninegocio_mstr.une_id = cue_cuentas_mstr.cue_uninegocio_id');
        $this->db->where('une_id',$id); 
        $this->db->where('une_nombre', 'asc');
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
        if ($consulta->num_rows() > 0){
           return $consulta->row();
        }
        return null;
    }

    function obternertraspasoenflujoorigen($id){
        $this->db->select('*');
        $this->db->select_sum('tra_monto');
        $this->db->from('cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr', 'tra_cue_dest_id = cued_id AND tra_fecha = cued_fecha', 'left');
        $this->db->where('cued_id',$id);
        $this->db->where('cued_fecha = CURDATE();');
        $consulta = $this->db->get();
        if ($consulta->num_rows() > 0){
           return $consulta->row();
        }
        return null;

    }
    function obternertraspasoenflujodestino($id){
        $this->db->select('*');
        $this->db->select_sum('tra_monto');
        $this->db->from('cued_cuentas_det');
        $this->db->join('tra_traspasos_mstr', 'tra_cue_orig_id = cued_id AND tra_fecha = cued_fecha', 'left');
        $this->db->where('cued_id',$id);
        $this->db->where('cued_fecha = CURDATE();');
        $consulta = $this->db->get();
        if ($consulta->num_rows() > 0){
           return $consulta->row();
        }
        return null;

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


// Insert *** Agregar Pago Vimifos**

    function nuevopagovim($id_o,$id_d,$fecha,$data,$tipo){
        $this->db->where('tra_cue_orig_id',$id_o);
        $this->db->where('tra_cue_dest_id',$id_d);
        $this->db->where('tra_fecha',$fecha);
        $this->db->where('tra_tipomov',$tipo);
        $query = $this->db->get('tra_traspasos_mstr');
        $datos = array(
                'tra_cue_orig_id'=> $id_o,
                'tra_cue_dest_id' => $id_d,
                'tra_monto' => -($data['pagointvim']),
                'tra_descripcion' => $data['descrip'],
                'tra_responsable' => $data['respo'],
                'tra_tipomov' => $tipo,
                'tra_fecha' => $fecha,
                );
        if ($query->num_rows() > 0)
        {
            $this->db->where('tra_cue_orig_id',$id_o);
            $this->db->where('tra_cue_dest_id',$id_d);
            $this->db->where('tra_fecha',$fecha);
            $this->db->where('tra_tipomov',$tipo);
            $this->db->update('tra_traspasos_mstr', $datos);
        }
        else
        {
            $this->db->insert('tra_traspasos_mstr', $datos);
        }

    }
    
    function nuevopagovimp($id_o,$id_d,$fecha,$data,$tip){
        $this->db->where('tra_cue_orig_id',$id_o);
        $this->db->where('tra_cue_dest_id',$id_d);
        $this->db->where('tra_fecha',$fecha);
        $this->db->where('tra_tipomov',$tip);
        $query = $this->db->get('tra_traspasos_mstr');
        $datos = array(
                'tra_cue_orig_id'=> $id_o,
                'tra_cue_dest_id' => $id_d,
                'tra_monto' => $data['pagointvim'],
                'tra_descripcion' => $data['descrip'],
                'tra_responsable' => $data['respo'],
                'tra_tipomov' => $tip,
                'tra_fecha' => $fecha,
                );
        if ($query->num_rows() > 0)
        {
            $this->db->where('tra_cue_orig_id',$id_o);
            $this->db->where('tra_cue_dest_id',$id_d);
            $this->db->where('tra_fecha',$fecha);
            $this->db->where('tra_tipomov',$tip);
            $this->db->update('tra_traspasos_mstr', $datos);
        }
        else
        {
            $this->db->insert('tra_traspasos_mstr', $datos);
        }

    }


// Insert *** Agregar Traspaso ***
    function nuevotraspaso($data,$fecha,$id_o,$id_d,$tipo){
        $this->db->where('tra_cue_orig_id',$id_o);
        $this->db->where('tra_cue_dest_id',$id_d);
        $this->db->where('tra_fecha',$fecha);
        $this->db->where('tra_tipomov',$tipo);
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
            $this->db->where('tra_tipomov',$tipo);
            $this->db->update('tra_traspasos_mstr', $datos);
        }
        else
        {
            $this->db->insert('tra_traspasos_mstr', $datos);
        }
    
    }

// Insert *** Agregar Traspaso salida ***
    function nuevotraspasosl($data,$fecha,$id_o,$id_d,$tipos){
        $this->db->where('tra_cue_orig_id',$id_d);
        $this->db->where('tra_cue_dest_id',$id_o);
        $this->db->where('tra_fecha',$fecha);
        $this->db->where('tra_tipomov',$tipos);
        $query = $this->db->get('tra_traspasos_mstr');
        $datos = array(
            'tra_cue_orig_id'=> $data['tra_cue_dest_id'],
            'tra_cue_dest_id' => $data['tra_cue_orig_id'],
            'tra_monto' => -($data['tra_monto']),
            'tra_descripcion' => $data['tra_descripcion'],
            'tra_responsable' => $data['tra_responsable'],
            'tra_fecha' => $fecha,
            'tra_tipomov' => $tipos,
        );

        if ($query->num_rows() > 0)
        {
            $this->db->where('tra_cue_orig_id',$id_d);
            $this->db->where('tra_cue_dest_id',$id_o);
            $this->db->where('tra_fecha',$fecha);
            $this->db->where('tra_tipomov',$tipos);
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

    function grabrarnvosalpagoslin($id_d,$fecha,$saldodepagos){
        $datos = array(
                'cued_pagos_lin' => $saldodepagos,
                );
        $this->db->where('cued_id',$id_d);
        $this->db->where('cued_fecha',$fecha);
        $this->db->update('cued_cuentas_det', $datos);
    }
// Update *** Actualizar saldo flujo cuenta origen *** Pago Vim
    function actualizarsaldoorigenpgo($saldonuevoorigen,$id_o,$fecha){
        $datos = array(
                'cued_sald_fin' => $saldonuevoorigen,
                 );
        $this->db->where('cued_id',$id_o);
        $this->db->where('cued_fecha',$fecha);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }
    function actualizarsaldodestinopgo($saldonuevodestino,$id_d,$fecha){
        $datos = array(
                'cued_sald_fin' => $saldonuevodestino,
                 );
        $this->db->where('cued_id',$id_d);
        $this->db->where('cued_fecha',$fecha);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }

// Update *** Editar flujo ***
    function actualizarFlujo($idcuenta,$data,$fecha){
        $datos = array(
                'cued_sald_ini'=> $data['cued_sald_ini'],
                'cued_cheq_circ' => $data['cued_cheq_circ'],
                'cued_cheques' => -($data['cued_cheques']),
                'cued_depos_fir' => $data['cued_depos_fir'],
                'cued_sald_fin' => $data['cued_sald_fin']
                 );
        $this->db->where('cued_id',$idcuenta);
        $this->db->where('cued_fecha',$fecha);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }

    function trapasosctaxcta(){
        $this->db->select('tra_fecha, tra_cue_dest_id, T1.cue_descripcion as T1CD, T1.cue_nombre AS T1C, T1.cue_numero AS T1N, tra_cue_orig_id, T2.cue_nombre AS T2C, T2.cue_numero AS T2N, une_nombre, tra_monto, tra_descripcion, tra_responsable, T1.cue_divisa AS divisa');
        $this->db->from('une_uninegocio_mstr, ban_bancos_mstr, cued_cuentas_det,  tra_traspasos_mstr');
        $this->db->join('cue_cuentas_mstr as T1 ', 'T1.cue_id = tra_cue_orig_id' ,'inner');
        $this->db->join('cue_cuentas_mstr as T2 ', 'T2.cue_id = tra_cue_dest_id' ,'inner');
        $this->db->where('T1.cue_id = cued_id');     
        $this->db->where('T1.cue_uninegocio_id = une_id');
        $this->db->where('ban_id = T1.cue_banco_id');
        $this->db->where('tra_fecha = cued_fecha'); 
        $this->db->where('tra_tipomov', '1' );
        $this->db->where('tra_fecha = CURDATE();'); // filtro por fecha actual.
        $query = $this->db->get();
        if($query->num_rows() > 0) return $query->result();
        else return false;
    }
    function obtBenef(){
        $query = $this->db->get('ben_beneficiarios_mstr');
        if($query->num_rows() > 0) return $query->result();
        else return false;
    }
    function pagoben($ben,$monto,$cuentapago,$fecha){
        $datos = array(
                'cueben_beneficiario_id' => $ben,
                'cueben_monto' => $monto,
                'cueben_cuenta_id' => $cuentapago,
                'cueben_fecha' => $fecha
                );
        $this->db->insert('cueben_cuentas_beneficiarios_det', $datos);   
    }
    function mpagoben($nsaldopago,$cuentapago,$fecha,$saldonuevo){
        $datos = array(
                'cued_cheques' => $nsaldopago,
                'cued_sald_fin' => $saldonuevo
                );
        $this->db->where('cued_id',$cuentapago);
        $this->db->where('cued_fecha',$fecha);
        $this->db->update('cued_cuentas_det', $datos);
    }

    function obtBenefsql(){
        $consulta = $this->db->get('ben_beneficiarios_mstr');
      
        $cadena = "";
        foreach ($consulta->result_array() as $reg) {
            $cadena.="<option value='{$reg['ben_id']}'>{$reg['ben_nombre']}</option>";

        }
        echo $cadena;
    }
    function obtcta($divisa, $une){
        $this->db->select('*');
        $this->db->from('cue_cuentas_mstr');
        $this->db->join('cued_cuentas_det','cue_id = cued_id');
        $this->db->join('une_uninegocio_mstr','une_id = cue_uninegocio_id');
        $this->db->join('ban_bancos_mstr','ban_id = cue_banco_id');
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('une_id', $une);
        $this->db->where('cued_sald_fin !=', '0');
        $this->db->where('cued_fecha = CURDATE()'); 
        $consulta = $this->db->get();
      
        $cadena = "";
        $simbolo = "SALDO $";

        if($consulta->num_rows() > 0){
            foreach ($consulta->result_array() as $reg) {
            $cadena.="<option value='{$reg['cue_id']}|{$reg['cued_sald_fin']}|{$reg['cued_cheques']}'>
            {$reg['ban_nombre']} {$reg['cue_nombre']} {$reg['cue_numero']} {$reg['cue_divisa']} $simbolo{$reg['cued_sald_fin']}</option>";
            }
        }else {
            $cadena.="<option>CUENTAS SIN SALDO</option>";
        }

        echo $cadena;

    }

}


      