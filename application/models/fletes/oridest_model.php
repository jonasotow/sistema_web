<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Oridest_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "trayecto";
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
            'Datos Trayectos' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
                'idtrayecto' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'idproveedor' => array(
                    'id' => 'idestado',
                    'name' => 'Proveedor',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'descripcion' => array(
                    'name' => 'Descripcion',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'idestado' => array(
                    'id' => 'idestado',
                    'name' => 'Estado Origen',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'idciudadorigen' => array(
                    'name' => 'Ciudad Origen',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'idestado2' => array(
                    'name' => 'Estado Destino',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'idciudaddestino' => array(
                    'name' => 'Ciudad Destino',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'kms' => array(
                    'name' => 'Kilometros',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'idunidad' => array(
                    'name' => 'Tipo de Unidad',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'costokm' => array(
                    'name' => 'Costo por Viaje',
                    'tipo' => 'varchar',
                    'lenght' => 30,
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
        $formularios = $this->get('proveedor','idproveedor,descripcion','status = 1');
        $forms[0] = 'Seleccione un Proveedor';
        foreach($formularios as $formulario){
            $forms[$formulario->idproveedor] = $formulario->descripcion;
        }
        $this->schema['Datos Trayectos']['idproveedor']['data'] = $forms;

        $forms = array();
        $formularios = $this->get('Estado','idestado,descripcion');
        $forms[0] = 'Seleccione un Estado';
        foreach($formularios as $formulario){
            $forms[$formulario->idestado] = $formulario->descripcion;
        }
        $this->schema['Datos Trayectos']['idestado']['data'] = $forms;
        $this->schema['Datos Trayectos']['idestado2']['data'] = $forms;
        
        $forms = array();
        $forms[0] = 'Seleccione una Ciudad';
        $this->schema['Datos Trayectos']['idciudadorigen']['data'] = $forms;
        $this->schema['Datos Trayectos']['idciudaddestino']['data'] = $forms;

        $forms = array();
        $formularios = $this->get('unidad','idunidad,descripcion');
        $forms[0] = 'Seleccione una Unidad';
        foreach($formularios as $formulario){
            $forms[$formulario->idunidad] = $formulario->descripcion;
        }
        $this->schema['Datos Trayectos']['idunidad']['data'] = $forms;
    }

    function prepararForm2(){
        $forms = array();
        $formularios = $this->get('ciudad','idciudad,descripcion');
        $forms[0] = 'Seleccione una Ciudad';
        foreach($formularios as $formulario){
            $forms[$formulario->idciudad] = $formulario->descripcion;
        }
        $this->schema['Datos Trayectos']['idciudadorigen']['data'] = $forms;
        $this->schema['Datos Trayectos']['idciudaddestino']['data'] = $forms;
    }

    public function ciudad($idestado)
    {
        $datos = $this->get('ciudad','idciudad,descripcion',"idestado = $idestado","descripcion ASC");
        return $datos;
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
    $this->db->update('trayecto', array('status' => 0 ), array('idtrayecto' => $id));
    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
    }
    $this->db->trans_commit();
    return true;
  }
}