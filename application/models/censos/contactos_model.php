<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *  Contactos_model Class
 *
 *  @category:  Modelo
 *  @author:    José Manzo
 */
class Contactos_model extends My_Model {
	public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;
	
    function __construct() {
        parent::__construct();
        $this->load->model('censos/modelo_generico_model');
        $this->table_name = 'con_contactos_mstr';
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
        	'Datos Contactos' => array(
        		'class' => 'ejemplo',
       			'id' => 'ejemplo',
	           	'con_id_contacto' => array(
	        		'name' => 'Id',
	        		'tipo' => 'int',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'hidden',
					'class' => 'form-control'
	        	),
	        	'con_id_cliente' => array(
	        		'name' => 'Id Cliente',
	        		'tipo' => 'int',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'con_nombre' => array(
	        		'name' => 'Nombre Contacto',
	        		'tipo' => 'text',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'con_email' => array(
	        		'name' => 'Email',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'con_telefono' => array(
	        		'name' => 'Telefono',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'con_direccion' => array(
	        		'name' => 'Direcci&oacute;n',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'textarea',
					'class' => 'form-control'
	        	),
	        	'con_estado' => array(
	        		'name' => 'Estado',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'con_puesto' => array(
	        		'name' => 'Puesto',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'con_cumpleanios' => array(
	        		'name' => 'Cumplea&ntilde;os',
	        		'tipo' => 'date',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'date',
					'class' => 'form-control'
	        	),
	        	'con_ciclo_vida_familiar' => array(
	        		'name' => 'Ciclo de Vida Familiar',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'con_canal_comunicacion' => array(
	        		'name' => 'Comunicacion',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'con_afinacion_politica' => array(
	        		'name' => 'Afinacion Politica',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'con_prioridades' => array(
	        		'name' => 'Prioridades',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'con_decision_compra' => array(
	        		'name' => 'Decision Compra',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'con_fecha_alta' => array(
	        		'name' => 'Fecha Alta',
	        		'tipo' => 'date',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'hidden',
					'class' => 'form-control'
	        	),
	        	'con_estatus' => array(
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
		$this->schema['Datos Contactos']['con_estado']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get_valor_tabla_generica('ciclo_vida_familiar');
	    $forms[''] = 'Seleccione un Ciclo';
		foreach($formularios as $formulario){
			$forms[$formulario->tblgval_valor] = $formulario->tblgval_valor;
		}
		$this->schema['Datos Contactos']['con_ciclo_vida_familiar']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get_valor_tabla_generica('decision_compra');
	    $forms[''] = 'Seleccione quien toma la decision de compra';
		foreach($formularios as $formulario){
			$forms[$formulario->tblgval_valor] = $formulario->tblgval_valor;
		}
		$this->schema['Datos Contactos']['con_decision_compra']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get_valor_tabla_generica('canal_comunicacion');
	    $forms[''] = 'Seleccione un Canal';
		foreach($formularios as $formulario){
			$forms[$formulario->tblgval_valor] = $formulario->tblgval_valor;
		}
		$this->schema['Datos Contactos']['con_canal_comunicacion']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get_value('cli_clientes_mstr', 'cli_id_cliente', 'cli_cve_cliente');
	    $forms[''] = 'Seleccione un Cliente';
		foreach($formularios as $formulario){
			$forms[$formulario->cli_id_cliente] = $formulario->cli_cve_cliente;
		}
		$this->schema['Datos Contactos']['con_id_cliente']['data'] = $forms;
    }
}

/* End of file contactos_model.php */
/* Location: ./application/censos/models/contactos_model.php */  