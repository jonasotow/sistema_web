<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  contacto_model Class
 *
 *  @category:  Modelo
 *  @author:    Antonio Gaxiola
 */
class Reportes_Model extends My_Model {
    public $schema;
    public $schema_add;
    public $schema_up;

    function __construct() {
        parent::__construct();
    }


    function reportes($id_usuario, $fecha_inicio = NULL, $fecha_fin = NULL){

       // echo $id_usuario;
        $nuevafecha_fin = date("Y-m-d h:i:s", strtotime("$fecha_fin +1 day"));
      //  echo $nuevafecha_fin;

        if($id_usuario > 0){
            $this->db->select('calmstr.idcal_mstr,calmstr.cal_what,calmstr.cal_startDate,calmstr.cal_endDate,caldet.idcal_mstr,caldet.cald_value');
            $this->db->from('cal_mstr as calmstr');
            $this->db->join('cald_det as caldet','calmstr.idcal_mstr = caldet.idcal_mstr', 'INNER'); 
          /*  $this->db->where('caldet.cald_key', 'tec_id_usuario');
            $this->db->where('caldet.cald_key', 'usu_nombre'); 
            $this->db->where('caldet.cald_value', $id_usuario); */
        }else{
            $this->db->select('calmstr.idcal_mstr,calmstr.cal_what,calmstr.cal_startDate,calmstr.cal_endDate');
            $this->db->from('cal_mstr as calmstr');   
        }

        if ($fecha_inicio <> 0 || $fecha_fin <> 0) {
            $this->db->where('calmstr.cal_startDate >=', $fecha_inicio);
            $this->db->where('calmstr.cal_endDate <=', $nuevafecha_fin);
        }

        $datos = $this->db->get()->result_array();

        if ($this->db->count_all_results() > 0) {
            return $datos;
        }else{
            return FALSE;
        } 
        
    }

    function regresaUsuarios(){
        $this->db->distinct();
        $this->db->select('usu_id,usu_nombre,usu_estatus,usu_apellido_paterno');
        $this->db->from('usuarios.usu_usuarios_mstr as usu');
        $this->db->join('usuarios.usutip_usuarios_tipos_det as usudet','usudet.usutip_id_usuario = usu.usu_id', 'INNER');   
      //  $this->db->join('agenda_tecnicos.tec_tecnicos_mstr as agetec','agetec.tec_id_usuario = usudet.usutip_id_usuario', 'INNER');  
        //$this->db->where('usudet.usutip_id_asignado', $usuario); 
        //$this->db->or_where('usu.usu_id', $usuario);
        $this->db->where('usudet.usutip_id_tipo', 2);
        $this->db->where('usu.usu_estatus', 1); 

        $datos = $this->db->get()->result();

        if ($this->db->count_all_results() > 0) {
            return $datos;
        }else{
            return false;
        } 

    }
}

/* End of file campos_model.php */
/* Location: ./application/censos/models/campos_model.php */