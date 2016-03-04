<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 * Super Class
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Author Alfredo Garcia
 * @link http://localhost/sistema_web/censos.php/
 */
class Granjas_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
        $this->load->model('censos/modelo_generico_model');
        $this->table_name = 'gran_granjas_mstr';
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
				'id' => 'guardar'
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
				'id' => 'guardar'
			),
			'Eliminar' => array(
				'tipo' => 'submit',
				'label' => 'Eliminar',
				'class' => 'btn btn-primary',
				'id' => 'eliminar'
			)
        );
         $this->schema = array(
         	'Datos Granja' => array(
         		'class' => '',
         		'id' => '',
	        	'gran_id_granja' => array(
	        		'name' => 'Id',
	        		'tipo' => 'int',
	        		'lenght' => 11,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'hidden',
					'class' => 'form-control'
	        	),
	        	'gran_id_cliente' => array(
	        		'name' => 'Cliente',
	        		'tipo' => 'int',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'gran_nombre' => array(
	        		'name' => 'Nombre',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'gran_gerente_atiende' => array(
	        		'name' => 'Gerente',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'gran_direccion' => array(
	        		'name' => 'Direcci&oacute;n',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'textarea',
					'class' => 'form-control'
	        	),
	        	'gran_estado' => array(
	        		'name' => 'Estado',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'gran_ciudad' => array(
	        		'name' => 'Ciudad',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'gran_municipio' => array(
	        		'name' => 'Municipio',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'gran_zona' => array(
	        		'name' => 'Zona',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'gran_especie' => array(
	        		'name' => 'Especie',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'gran_estatus' => array(
	        		'name' => 'Estatus',
	        		'tipo' => 'boolean',
	        		'lenght' => 1,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'hidden',
					'class' => 'form-control'
	        	)
        	)
        );
    }
    
    function prepararForm(){
	    $forms = array();
	    $formularios = $this->modelo_generico_model->get_estados();
	    $forms[''] = 'Seleccione un Estado';
		foreach($formularios as $formulario){
			$forms[$formulario->id] = $formulario->estado;
		}
		$this->schema['Datos Granja']['gran_estado']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get_valor_tabla_generica('esp_especie');
	    $forms[''] = 'Seleccione una Especie';
		foreach($formularios as $formulario){
			$forms[$formulario->tblgval_valor] = $formulario->tblgval_valor;
		}
		$this->schema['Datos Granja']['gran_especie']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get_value('cli_clientes_mstr', 'cli_id_cliente', 'cli_cve_cliente');
	    $forms[''] = 'Seleccione un Cliente';
		foreach($formularios as $formulario){
			$forms[$formulario->cli_id_cliente] = $formulario->cli_cve_cliente;
		}
		$this->schema['Datos Granja']['gran_id_cliente']['data'] = $forms;
    }
}

/* End of file granjas_model.php */
/* Location: ./application/censos/models/granjas_model.php */