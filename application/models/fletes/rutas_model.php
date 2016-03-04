<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * rutas_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Rutas_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "rutas";
    }

     function list_generic($table){
        $array = $this->get($table,'*');
        return $array;
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

    function guardar_ruta(){

    $data = array(
        'descripcion' => $this->input->post('descripcion', TRUE),   
        'idunidad' => $this->input->post('idunidad', TRUE),
        'status' => 1
    );

    //SE GUARDA LA RUTA.
    $this->db->insert('rutas', $data);
    //SE BUSCA EL ID DE LA RUTA DADA DE ALTA ANTERIORMENTE.
    $rutas = $this->get('rutas','*',NULL,"idruta DESC LIMIT 1");
        foreach($rutas as $ruta){
            $idruta = $ruta->idruta;
        }

        //SE TOMAN LAS RUTAS INGRESADAS.
        $idestado = $this->input->post('idestado', TRUE);
        $idciudad = $this->input->post('idciudad', TRUE);
        $posicion = $this->input->post('posicion', TRUE);
        $monto = $this->input->post('monto', TRUE);
        $traslado = $this->input->post('traslado', TRUE);

        //SE RECORRE EL NUMERO TOTAL DE VIAJES A COTIZAR
        for($i = 0; $i <= count($idestado); $i++){
            $id = $idestado[$i];
            if($id<>0){
                $data2 = array(
                    'idruta' => $idruta,
                    'idestado' => $idestado[$i],
                    'idciudad' => $idciudad[$i],
                    'posicion' => $posicion[$i],
                    'monto' => $monto[$i],
                    'traslado' => ($traslado[$i]) ? 1 : 0
                );
                //SE GUARDA EL DETALLE DE LA RUTA
                $this->db->insert('detalle_ruta',$data2);
            }
        }
    }

    public function delete_t($id) {
    $this->db->trans_begin();
    $this->db->update('rutas', array('status' => 0 ), array('idruta' => $id));
    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
    }
    $this->db->trans_commit();
    return true;
  }
}