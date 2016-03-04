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
class Granjas_Mon_Model extends My_Model {
    public $table_name;
    public $schema;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
        $this->table_name = 'granjas_mstr';
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
	        	'idgranjas_mstr' => array(
	        		'name' => 'Id',
	        		'tipo' => 'int',
	        		'lenght' => 11,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	),
	        	'granjas_desc' => array(
	        		'name' => 'Nombre',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'text'
	        	),
	        	'granjas_mfg_addr' => array(
	        		'name' => 'Gerente',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text'
	        	),
	        	'granjas_dir' => array(
	        		'name' => 'Direccion',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'textarea'
	        	),
	        	'granjas_tel' => array(
	        		'name' => 'Telefono',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text'
	        	),
	        	'granjas_status' => array(
	        		'name' => 'Estatus',
	        		'tipo' => 'boolean',
	        		'lenght' => 1,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	),
	        	'granjas_clave' => array(
	        		'name' => 'Clave',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'hidden',
					'value' => 1
	        	)
	        )
        );
    }
}

/* End of file granjas_model.php */
/* Location: ./application/censos/models/granjas_model.php */