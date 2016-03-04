<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Proveedor_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "proveedor";
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
            'Datos Proveedor' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
                'idproveedor' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'descripcion' => array(
                    'name' => 'Descripcion',
                    'tipo' => 'varchar',
                    'lenght' => 100,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'idestado' => array(
                    'id' => 'idestado',
                    'name' => 'Estado',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'idciudad' => array(
                    'name' => 'Ciudad',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'direccion' => array(
                    'name' => 'Dirección',
                    'tipo' => 'varchar',
                    'lenght' => 100,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'textarea',
                    'class' => 'form-control'
                ),
                'cp' => array(
                    'name' => 'Cod. Postal',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'contacto' => array(
                    'name' => 'Nombre del Contacto',
                    'tipo' => 'varchar',
                    'lenght' => 100,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'telefono' => array(
                    'name' => 'Telefono',
                    'tipo' => 'varchar',
                    'lenght' => 15,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'status' => array(
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
        $formularios = $this->get('Estado','idestado,descripcion');
        $forms[0] = 'Seleccione un Estado';
        foreach($formularios as $formulario){
            $forms[$formulario->idestado] = $formulario->descripcion;
        }
        $this->schema['Datos Proveedor']['idestado']['data'] = $forms;
        
        $forms = array();
        $forms[0] = 'Seleccione una Ciudad';
        $this->schema['Datos Proveedor']['idciudad']['data'] = $forms;
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
    $this->db->update('proveedor', array('status' => 0 ), array('idproveedor' => $id));
    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
    }
    $this->db->trans_commit();
    return true;
  }
}