<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Cotizador_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "unidad";
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
                'label' => 'Imprimir',
                'class' => 'btn btn-primary',
                'id' => 'guardar_especie'
            )
        );
        $this->schema = array(
            'Datos para Cotizacion' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
                /*'fecha' => array(
                    'name' => 'Fecha de solicitud',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'date',
                    'class' => 'form-control'
                ),
                'nombresolicitante' => array(
                    'name' => 'Nombre del Solicitante',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'division' => array(
                    'name' => 'División',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'embalaje' => array(
                    'name' => 'Tipo de Embalaje',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'radio',
                    'class' => 'form-control',
                    'data' => array(1 => 'A Piso: ',
                        2 => 'Entarimado: ', 3 => 'A Granel: ')
                ),*/
                'idproveedor' => array(
                    'name' => 'Proveedor',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'idestado' => array(
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
                'cantidad' => array(
                    'name' => 'Kg a Embarcar',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'costoflete' => array(
                    'name' => 'Costo del Flete',
                    'tipo' => 'decimal',
                    'lenght' => 50,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'kms' => array(
                    'name' => 'Km del Recorrido',
                    'tipo' => 'decimal',
                    'lenght' => 50,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'text',
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
        $this->schema['Datos para Cotizacion']['idproveedor']['data'] = $forms;

        $forms = array();
        $formularios = $this->get('Estado','idestado,descripcion');
        $forms[0] = 'Seleccione un Estado';
        foreach($formularios as $formulario){
            $forms[$formulario->idestado] = $formulario->descripcion;
        }
        $this->schema['Datos para Cotizacion']['idestado']['data'] = $forms;
        $this->schema['Datos para Cotizacion']['idestado2']['data'] = $forms;
        
        $forms = array();
        $forms[0] = 'Seleccione una Ciudad';
        $this->schema['Datos para Cotizacion']['idciudadorigen']['data'] = $forms;
        $this->schema['Datos para Cotizacion']['idciudaddestino']['data'] = $forms;

        $forms = array();
        $formularios = $this->get('unidad','idunidad,descripcion');
        $forms[0] = 'Seleccione una Unidad';
        foreach($formularios as $formulario){
            $forms[$formulario->idunidad] = $formulario->descripcion;
        }
        $this->schema['Datos para Cotizacion']['idunidad']['data'] = $forms;
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