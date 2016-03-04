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
class Tipos_Model extends My_Model {
    public $table_name;
    public $schema;
    
    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
        $this->table_name = 'type_mstr';
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
         	'Datos' => array(
         		'class' => 'ejemplo',
         		'id' => 'ejemplo',
	        	'idtype_mstr' => array(
	        		'name' => 'Id',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	),
	        	'type_name' => array(
	        		'name' => 'Nombre',
	        		'tipo' => 'text',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text'
	        	),
	        	'type_status' => array(
	        		'name' => 'Estatus',
	        		'tipo' => 'boolean',
	        		'lenght' => 1,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	)
	        )
        );
    }
    
    function prepararForm(){
		$forms = array();
	    $formularios = $this->get_value('granjas_mstr',array('idgranjas_mstr', 'granjas_desc'),array('granjas_status' => 1));
	    $forms[''] = 'Seleccione una Granja';
		foreach($formularios as $formulario){
			$forms[$formulario->idgranjas_mstr] = $formulario->granjas_desc;
		}
		$this->schema['group_id_granja']['data'] = $forms;
    }
}

/* End of file granjas_model.php */
/* Location: ./application/censos/models/granjas_model.php */