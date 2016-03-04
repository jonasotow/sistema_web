<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Cotizaciones_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct(){
        parent::__construct();
        $this->table_name = "solicitudes";
    }

    function filas(){
        $filas = $this->get('solicitudes','*',NULL,NULL);
        return $filas;
    }

    function ciudad($idciudad){
        $ciudad = $this->get('ciudad','descripcion',"idciudad = $idciudad", NULL);
        foreach($ciudad as$row){
            return $row->descripcion;
        }
    }

    function estado($idestado){
        $estado = $this->get('Estado','descripcion',"idestado = $idestado", NULL);
        foreach($estado as $row){
            return $row->descripcion;
        }
    }

    function generar_pdf($idsolicitud){
        $solicitudes = $this->get('solicitudes','*',"idsolicitud = $idsolicitud",NULL);
        return $solicitudes;
    }

    function detalle($idsolicitud){
        $this->db->select('unidad.descripcion,detalle_solicitud.viajes_mensuales,detalle_solicitud.tn_x_viaje,detalle_solicitud.costo_tn,detalle_solicitud.tn_x_viaje * detalle_solicitud.costo_tn as costo_viaje,((detalle_solicitud.tn_x_viaje * detalle_solicitud.costo_tn) * detalle_solicitud.viajes_mensuales) as costo_total');
        $this->db->from('detalle_solicitud');
        $this->db->join('unidad','unidad.idunidad = detalle_solicitud.idunidad');
        $this->db->where('detalle_solicitud.idsolicitud', $idsolicitud);
        $query = $this->db->get();
        
        if($query->num_rows()>0)
        {
            //retorna o resultado
            return $query->result();
        }
    }

    function get($tabla,$campos = null,$where = null,$order = null){
        if (!is_null($campos))
            $this->db->select($campos); 
        if (!is_null($where))
            $this->db->where($where);
        if (!is_null($order))
            $this->db->order_by($order);
        $query = $this->db->get($tabla);
        return $query->result();
    }
}