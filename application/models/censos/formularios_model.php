<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 * Super Class
 *
 * @package Package Name
 * @subpackage Subpackage
 * @category Censos
 * @author Author Alfredo Garcia
 * @link http://localhost/sistema_web/censos.php/
 */
class Formularios_model extends My_Model {
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
        $this->table_name = 'form_formularios_mstr';
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
            'Datos Formularios' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
            	'form_id_formulario' => array(
            		'name' => 'Id',
            		'tipo' => 'int',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => TRUE,
            		'update' => FALSE,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	),
            	'form_nombre' => array(
            		'name' => 'Nombre',
            		'tipo' => 'varchar',
            		'lenght' => 120,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => FALSE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'form_descripcion' => array(
            		'name' => 'Descripcion',
            		'tipo' => 'varchar',
            		'lenght' => 120,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'form_estatus' => array(
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
}

/* End of file formularios_model.php */
/* Location: ./application/censos/models/formularios_model.php */