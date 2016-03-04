<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

class Periodos_model extends My_Model {
	public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;
	
    function __construct() {
        parent::__construct();
        $this->load->model('censos/modelo_generico_model');
        $this->load->model('censos/granjas_model','oGranja');
        $this->table_name = 'per_periodos_mstr';
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
				'id' => 'guardar_tipoespecie'
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
				'id' => 'guardar_tipoespecie'
			),
			'Eliminar' => array(
				'tipo' => 'submit',
				'label' => 'Eliminar',
				'class' => 'btn btn-primary',
				'id' => 'eliminar'
			)
        );
         $this->schema = array(
         	'Datos Censo' => array(
         		'class' => 'ejemplo',
         		'id' => 'ejemplo',
	        	'per_id_periodo' => array(
	        		'name' => 'Id',
	        		'tipo' => 'int',
	        		'lenght' => 11,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'hidden',
					'class' => 'form-control'
	        	),
	        	'per_id_granja' => array(
	        		'name' => 'Granja',
	        		'tipo' => 'varchar',
	        		'lenght' => 100,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'per_id_especie' => array(
	        		'name' => 'Tipo',
	        		'tipo' => 'varchar',
	        		'lenght' => 40,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'per_anio' => array(
	        		'name' => 'A&ntilde;o',
	        		'tipo' => 'int',
	        		'lenght' => 11,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'data' => array(
						1 => '2014',
						2 => '2015'
					),
					'class' => 'form-control'
	        	),
	        	'per_mes' => array(
	        		'name' => 'Mes',
	        		'tipo' => 'int',
	        		'lenght' => 11,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'data' => array(
						1 => 'Enero',
						2 => 'Febrero',
						3 => 'Marzo',
						4 => 'Abril',
						5 => 'Mayo',
						6 => 'Junio',
						7 => 'Julio',
						8 => 'Agosto',
						9 => 'Septiembre',
						10 => 'Octubre',
						11 => 'Noviembre',
						12 => 'Diciembre'					
					),
					'class' => 'form-control'
	        	)
        	)
        );
    }
    
    function prepararForm($id = NULL,$especie = NULL){
	    $forms = array();
	    if($id !== NULL)
	    	$formularios =  $this->oGranja->find('result',array( 
				'fields' => array('gran_id_granja', 'gran_nombre'),
				'conditions' => array('gran_id_cliente' => $id,'gran_estatus' => 1)
				));
	    else
	    	$formularios =  $this->oGranja->find('result',array( 
				'fields' => array('gran_id_granja', 'gran_nombre'),
				'conditions' => array('gran_estatus' => 1)
				));
	    $forms[''] = 'Seleccione una Granja';
		foreach($formularios->result() as $formulario){
			$forms[$formulario->gran_id_granja] = $formulario->gran_nombre;
		}
		$this->schema['Datos Censo']['per_id_granja']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get('especies_tipos','',array('especies_estatus' => 1, 'especies_id_tipo' => $especie));
	    $forms[''] = 'Seleccione un Censo';
		foreach($formularios as $formulario){
			$forms[$formulario->idespecies_tipos] = $formulario->especies_desc;
		}
		$this->schema['Datos Censo']['per_id_especie']['data'] = $forms;
    }
}

/* End of file periodos_model.php */
/* Location: ./application/censos/models/periodos_model.php */