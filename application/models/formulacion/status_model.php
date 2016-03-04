<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Status_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "Status_solicitud";
    }

    function cambio_status($datos){
        //TRABAJANDO ARCHIVO CARGADO
        $archivo = $_FILES["File"]["tmp_name"]; 
        $tamanio = $_FILES["File"]["size"];
        $tipo    = $_FILES["File"]["type"];
        $nombre  = $_FILES["File"]["name"];
        if ( $archivo != "none" ){
            $fp = fopen($archivo, "rb");
            $contenido = fread($fp, $tamanio);
            $contenido = addslashes($contenido);
            fclose($fp); 
        }
        //TRABAJANDO ARCHIVO CARGADO
        $data = array(
            'Status' => $datos['Status'],
            'FechaModificacion' => date("Y-m-d H:i:s"),
            'idSolicitud' => $datos['idSolicitud'],
            'Comentario' => $datos['Comentario'],
            'Formato' => $datos['Formato'],
            'Archivo' => ($contenido = NULL ? NULL : $contenido),
            'Tipo' => ($tipo = NULL ? NULL : $tipo),
            'Nombre' => ($nombre = NULL ? NULL : $nombre)
        );
        $this->db->insert('Status_solicitud',$data);
        $datau = array(
            'StatusSolicitud' => $datos['Status'],
        );

        if($datos['Formato'] == "ENGORDA"){
            $this->db->where('idSolicitud_Engorda', $datos['idSolicitud']);
            $this->db->update('Solicitud_engorda', $datau); 
        } else {
            $this->db->where('idSolicitud_Lechero', $datos['idSolicitud']);
            $this->db->update('Solicitud_lechero', $datau); 
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