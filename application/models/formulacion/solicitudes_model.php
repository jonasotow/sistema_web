<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Solicitudes_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "Solicitud_engorda";
        $this->schema_add = array(
            'Borrar' => array(
                'tipo' => 'reset',
                'label' => 'Borrar',
                'class' => 'btn btn-primary',
                'id' => 'borrar'
            ),
            'Guardar' => array(
                'tipo' => 'submit',
                'label' => 'Guardar',
                'class' => 'btn btn-primary',
                'id' => 'guardar_etapa'
            )
        );
        $this->schema_up = array(
            'Borrar' => array(
                'tipo' => 'reset',
                'label' => 'Borrar',
                'class' => 'btn btn-primary',
                'id' => 'borrar'
            ),
            'Guardar' => array(
                'tipo' => 'submit',
                'label' => 'Guardar',
                'class' => 'btn btn-primary',
                'id' => 'guardar_etapa'
            )
        );
        $this->schema = array(
            'solicitud' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
                'idSolicitud' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'Status' => array(
                    'name' => 'Etapa',
                    'tipo' => 'varchar',
                    'lenght' => 50,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'radio',
                    'class' => 'form-control',
                    'data' => array(
                        'RECIBIDA' => 'RECIBIDA',
                        'REVISION'=> 'REVISION',
                        'INCOMPLETO' => 'INCOMPLETO',
                        'TERMINADO' => 'TERMINADO'
                    )
                ),
                'Comentario' => array(
                    'name' => 'Comentario',
                    'tipo' => 'int',
                    'lenght' => 500,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'textarea',
                    'class' => 'form-control'
                ),
                'Formato' => array(
                    'name' => 'Formato',
                    'tipo' => 'int',
                    'lenght' => 20,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'File' => array(
                'name' => 'Adjuntar Archivo',
                'tipo' => 'varchar',
                'lenght' => 30,
                'null' => FALSE,
                'primary' => FALSE,
                'update' => TRUE,
                'type' => 'file',
                'class' => 'form-control'
                )
            )
        );
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

    public function delete_t($id) {
    $this->db->trans_begin();
    $this->db->update('tipo', array('tipo_status' => 0 ), array('idtipo' => $id));
    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
    }
    $this->db->trans_commit();
    return true;
  }
}