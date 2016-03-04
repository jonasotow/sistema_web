<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  contacto_model Class
 *
 *  @category:  Modelo
 *  @author:    José Manzo
 */
class Genericos_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    function __construct() {
        parent::__construct();
        $this->table_name = 'code_mstr';
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
            'Datos Genericos' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
            	'code_fldname' => array(
            		'name' => 'Campo',
            		'tipo' => 'varchar',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => TRUE,
            		'update' => FALSE,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	),
            	'code_value' => array(
            		'name' => 'Valor',
            		'tipo' => 'varchar',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => FALSE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'code_desc' => array(
            		'name' => 'Descripcion',
            		'tipo' => 'varchar',
            		'lenght' => 255,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'code_cmmt' => array(
            		'name' => 'Comentario',
            		'tipo' => 'varchar',
            		'lenght' => 255,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'code_status' => array(
            		'name' => 'Estatus',
            		'tipo' => 'int',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => false,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	)
            )    
        );
    }
}

/* End of file campos_model.php */
/* Location: ./application/censos/models/campos_model.php */