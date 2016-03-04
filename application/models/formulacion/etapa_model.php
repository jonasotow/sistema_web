<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Etapa_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "Etapa";
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
            'Datos Etapa' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
                'idEtapa' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'Etapa' => array(
                    'name' => 'Etapa',
                    'tipo' => 'varchar',
                    'lenght' => 50,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'Descripcion' => array(
                    'name' => 'Descripcion',
                    'tipo' => 'int',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'idSubespecie' => array(
                    'id' => 'idEspecie',
                    'name' => 'Especie',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                )
            )
        );
    }

    function prepararForm(){
        $forms = array();
        $formularios = $this->get('Subespecie','idSubespecie,Subespecie');
        $forms[0] = 'Seleccione una Subespecie';
        foreach($formularios as $formulario){
            $forms[$formulario->idSubespecie] = $formulario->Subespecie;
        }
        $this->schema['Datos Etapa']['idSubespecie']['data'] = $forms;
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