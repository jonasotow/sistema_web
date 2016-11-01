<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Divisas_model extends My_Model {
	function __construct(){
    	parent::__construct();
	}
    function obtbanc(){
    	$query = $this->db->get('ban_bancos_mstr');
    	if($query->num_rows() > 0) return $query;
    	else return false;
    }
    function obtune(){
        $query = $this->db->get('une_uninegocio_mstr');
        if($query->num_rows() > 0) return $query;
        else return false;
    }

    function obtcuentorig($divisa, $une){
        $this->db->select('*');
        $this->db->from('cue_cuentas_mstr');
        $this->db->join('cued_cuentas_det','cue_id = cued_id');
        $this->db->join('une_uninegocio_mstr','une_id = cue_uninegocio_id');
        $this->db->join('ban_bancos_mstr','ban_id = cue_banco_id');
        $this->db->where('cue_divisa <>', $divisa);
        $this->db->where('une_id', $une);
        $this->db->where('cued_sald_fin !=', '0');
        $this->db->where('cued_fecha = CURDATE()'); 
        $consulta = $this->db->get();
      
        $cadena = "";
        $simbolo = "SALDO $";

        if($consulta->num_rows() > 0){
            foreach ($consulta->result_array() as $reg) {
            $cadena.="<option value='{$reg['cue_id']}|{$reg['cued_sald_fin']}'>
            {$reg['ban_nombre']} {$reg['cue_nombre']} {$reg['cue_numero']} {$reg['cue_divisa']} $simbolo{$reg['cued_sald_fin']}</option>";
            }
        }else {
            $cadena.="<option>CUENTAS SIN SALDO</option>";
        }

        echo $cadena;

    }
    function obtcuentdest($divisa, $une){
        $this->db->select('*');
        $this->db->from('cue_cuentas_mstr');
        $this->db->join('cued_cuentas_det','cue_id = cued_id');
        $this->db->join('une_uninegocio_mstr','une_id = cue_uninegocio_id');
        $this->db->join('ban_bancos_mstr','ban_id = cue_banco_id');
        $this->db->where('cue_divisa', $divisa);
        $this->db->where('une_id', $une);
        $this->db->where('cued_fecha = CURDATE()'); 
        $consulta = $this->db->get();
        $cadena = "";
        $simbolo = "SALDO $";
        if($consulta->num_rows() > 0){
            foreach ($consulta->result_array() as $reg) {
            $cadena.="<option value='{$reg['cue_id']}|{$reg['cued_sald_fin']}'>
            {$reg['ban_nombre']} {$reg['cue_nombre']} {$reg['cue_numero']} {$reg['cue_divisa']} $simbolo{$reg['cued_sald_fin']}</option>";
            }
        }else {
            $cadena.="<option>NO TIENES CUENTAS CON ESTA DIVISA</option>";
        }

        echo $cadena;

    }

    function compradivisas($data){
        $this->db->where('tra_cue_orig_id',$data['tra_cue_orig']);
        $this->db->where('tra_cue_dest_id',$data['tra_cue_dest']);
        $this->db->where('tra_fecha',$data['fecha']);
        $query = $this->db->get('tra_traspasos_mstr');
        $datos = array(
                'tra_cue_orig_id'=> $data['tra_cue_orig'],
                'tra_cue_dest_id' => $data['tra_cue_dest'],
                'tra_monto' => $data['tra_monto'],
                'tra_descripcion' => $data['descrip'],
                'tra_responsable' => $data['respo'],
                'tra_tipomov' => $data['tra_tipomov'],
                'tra_fecha' => $data['fecha'],
                'tra_banco_id' => $data['tra_banco'],
                'tra_divisa' => $data['tra_divisa'],
                'tra_tc' => $data['tra_tc'],
                );

        $this->db->insert('tra_traspasos_mstr', $datos);
    }

    function compradivisascv($dato,$convdv){
        $this->db->where('tra_cue_orig_id',$dato['tra_cue_orig']);
        $this->db->where('tra_cue_dest_id',$dato['tra_cue_dest']);
        $this->db->where('tra_fecha',$dato['fecha']);
        $query = $this->db->get('tra_traspasos_mstr');
        $datos = array(
                'tra_cue_orig_id'=> $dato['tra_cue_orig'],
                'tra_cue_dest_id' => $dato['tra_cue_dest'],
                'tra_monto' => -($convdv),
                'tra_descripcion' => $dato['descrip'],
                'tra_responsable' => $dato['respo'],
                'tra_tipomov' => $dato['tra_tipomov'],
                'tra_fecha' => $dato['fecha'],
                'tra_banco_id' => $dato['tra_banco'],
                'tra_divisa' => $dato['tra_divisa'],
                'tra_tc' => $dato['tra_tc'],
                );

        $this->db->insert('tra_traspasos_mstr', $datos);

    }

    function actsaldodepo($id_dest,$nsaldodepo,$fecha){
        $datos = array(
                'cued_sald_fin' => $nsaldodepo,
                 );
        $this->db->where('cued_id',$id_dest);
        $this->db->where('cued_fecha',$fecha);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }
    function actsaldopago($id_orig,$nsaldopago,$fecha){
        $datos = array(
                'cued_sald_fin' => $nsaldopago,
                 );
        $this->db->where('cued_id',$id_orig);
        $this->db->where('cued_fecha',$fecha);
        $query = $this->db->update('cued_cuentas_det',$datos);
    }

    function mostrartrans(){
        $this->db->select('une_nombre, B3.ban_nombre AS institucion, tra_tc, tra_divisa, tra_monto,
            tra_cue_orig_id AS tCuenta_origen, M1.cue_numero AS cNumero_origen, M1.cue_nombre AS cNombre_origen, B1.ban_nombre AS bNombre_origen, C1.cued_sald_fin AS cdsaldo_origen, M1.cue_descripcion AS cDescr_origen,
           tra_cue_dest_id AS tCuenta_destino, M2.cue_numero AS cNumero_destino, M2.cue_nombre AS cNombre_destino, B2.ban_nombre AS bNombre_destino, C2.cued_sald_fin AS cdsaldo_destino, M2.cue_descripcion AS cDescr_destino');
        $this->db->from('une_uninegocio_mstr, tra_traspasos_mstr');

        $this->db->join('cued_cuentas_det as C1 ', 'tra_cue_orig_id = C1.cued_id' ,'');
        $this->db->join('cued_cuentas_det as C2 ', 'tra_cue_dest_id = C2.cued_id' ,'');

        $this->db->join('cue_cuentas_mstr as M1 ', 'tra_cue_orig_id = M1.cue_id' ,'');
        $this->db->join('cue_cuentas_mstr as M2 ', 'tra_cue_dest_id = M2.cue_id' ,'');

        $this->db->join('ban_bancos_mstr as B1 ', 'M1.cue_banco_id = B1.ban_id' ,'');
        $this->db->join('ban_bancos_mstr as B2 ', 'M2.cue_banco_id = B2.ban_id' ,'');
        $this->db->join('ban_bancos_mstr as B3 ', 'tra_banco_id = B3.ban_id' ,'');

        $this->db->where('tra_descripcion = "COMPRA DE DIVISAS"');
        $this->db->where('M1.cue_uninegocio_id = une_id');
        $this->db->where('tra_fecha = C2.cued_fecha');
        $this->db->where('C2.cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->where('C1.cued_fecha = CURDATE()'); // filtro por fecha actual.
        $this->db->where('tra_tipomov = "C"');
        $this->db->order_by("M1.cue_descripcion", "asc");
        $this->db->order_by("B1.ban_nombre", "asc");
        $this->db->order_by("tra_cue_orig_id","asc");

        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta;
        else return false;
    }

    function deletetransdivisas($tra_cue_orig_id,$tra_cue_dest_id,$tipo,$fecha){
        $this->db->where('tra_cue_orig_id',$tra_cue_orig_id);
        $this->db->where('tra_cue_dest_id',$tra_cue_dest_id);
        $this->db->where('tra_tipomov',$tipo);
        $this->db->where('tra_fecha',$fecha);
        $this->db->delete('tra_traspasos_mstr');
    }
    function deletetransdivisasx($tra_cue_orig_id,$tra_cue_dest_id,$tipo,$fecha){
        $this->db->where('tra_cue_orig_id',$tra_cue_dest_id);
        $this->db->where('tra_cue_dest_id',$tra_cue_orig_id);
        $this->db->where('tra_tipomov',$tipo);
        $this->db->where('tra_fecha',$fecha);
        $this->db->delete('tra_traspasos_mstr');
    }

    function editransdivisas($data){
        $datos = array(
                'tra_tc' => $data['tratcn'],
                'tra_monto' => $data['tramonton']
             );
        $this->db->where('tra_fecha',$data['fecha']);
        $this->db->where('tra_tipomov',$data['tipo']);
        $this->db->where('tra_cue_orig_id',$data['tra_cue_orig_id']);
        $this->db->where('tra_cue_dest_id',$data['tra_cue_dest_id']);
        $query = $this->db->update('tra_traspasos_mstr',$datos);

    }
    function editransdivisasx($data){
        $datos = array(
                'tra_tc' => $data['tratcn'],
                'tra_monto' => -($data['nconv'])
             ); 
        $this->db->where('tra_fecha',$data['fecha']);
        $this->db->where('tra_tipomov',$data['tipo']);
        $this->db->where('tra_cue_orig_id',$data['tra_cue_dest_id']);
        $this->db->where('tra_cue_dest_id',$data['tra_cue_orig_id']);
        $query = $this->db->update('tra_traspasos_mstr',$datos);

    }

}

