<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clases_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "clase";
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
                'id' => 'guardar_especie'
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
                'id' => 'guardar_especie'
            )
        );
        $this->schema = array(
            'Datos Clases' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
                'idclase' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'idtipo_clase' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'idtipo' => array(
                    'name' => 'Tipos',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'clase' => array(
                    'name' => 'Clases',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'clase_status' => array(
                    'name' => 'Estatus',
                    'tipo' => 'int',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => false,
                    'type' => 'hidden',
                    'class' => 'form-control'
                )
            )
        );
    }

    function prepararForm(){
        $forms = array();
        $formularios = $this->get('tipo','idtipo,tipo',array('tipo_status' => 1));
        $forms[''] = 'Seleccione un Tipo';
        foreach($formularios as $formulario){
            $forms[$formulario->idtipo] = $formulario->tipo;
        }
        $this->schema['Datos Clases']['idtipo']['data'] = $forms;
    }

    function get($tabla,$campos = null,$where = null){
        if (!is_null($campos))
            $this->db->select($campos); 
        if (!is_null($where))
            $this->db->where($where);
        $query = $this->db->get($tabla);
        return $query->result();
    }

    public function delete_t($id) {
        $this->db->trans_begin();
        $this->db->update('clase', array('clase_status' => 0 ), array('idclase' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }


}