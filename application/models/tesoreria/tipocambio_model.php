<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Tipocambio_model extends My_Model {
	function __construct(){
    	parent::__construct();
	}
    function obtenerinstituciones(){
    	$query = $this->db->get('tc_tcambio_mstr');
    	if($query->num_rows() > 0) return $query;
    	else return false;
    }
    function ntipocambio($data){
    	$this->db->insert('tc_tcambio_det',
    		array(
    			'tcd_insti_id'=>$data['tcd_insti_id'],
    			'tcd_fecha'=>$data['tcd_fecha'],
    			'tcd_hora'=>$data['tcd_hora'],
    			'tcd_tc_compra'=>$data['tcd_tc_compra'],
    			'tcd_tc_venta'=>$data['tcd_tc_venta'],
    			'tcd_descripcion'=>$data['tcd_descripcion'],
    			));
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

