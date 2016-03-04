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
class Campos_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    function __construct() {
        parent::__construct();
        $this->table_name = 'cam_campos_det';
        $this->load->model('censos/formularios_model');
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
            'Datos Campos' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
            	'cam_id_campo' => array(
            		'name' => 'Id',
            		'tipo' => 'int',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => TRUE,
            		'update' => FALSE,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	),
            	'cam_id_formulario' => array(
            		'name' => 'Formulario',
            		'tipo' => 'int',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => FALSE,
    				'type' => 'dropdown',
                    'class' => 'form-control'
            	),
            	'cam_id' => array(
            		'name' => 'ID Campo',
            		'tipo' => 'varchar',
            		'lenght' => 20,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'cam_label' => array(
            		'name' => 'Etiqueta',
            		'tipo' => 'varchar',
            		'lenght' => 40,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'cam_type' => array(
            		'name' => 'Tipo',
            		'tipo' => 'varchar',
            		'lenght' => 255,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'dropdown',
    				'data' => array(
    					''	=> 'Seleccione un Tipo',
    					'text' => 'text',
    					'radio'=> 'radio',
    					'checkbox' => 'checkbox',
    					'textarea' => 'textarea',
    					'select' => 'select'
    				),
                    'class' => 'form-control'
            	),
            	'cam_name' => array(
            		'name' => 'Nombre',
            		'tipo' => 'varchar',
            		'lenght' => 100,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'cam_value' => array(
            		'name' => 'Valores',
            		'tipo' => 'varchar',
            		'lenght' => 100,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'cam_required' => array(
            		'name' => 'Requerido',
            		'tipo' => 'varchar',
            		'lenght' => 2,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'cam_posicion' => array(
            		'name' => 'Posicion',
            		'tipo' => 'int',
            		'lenght' => 2,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'number',
                    'class' => 'form-control'
            	),
            	'cam_estatus' => array(
            		'name' => 'Estatus',
            		'tipo' => 'boolean',
            		'lenght' => 1,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	)
            )    
        );
    }
    
    function prepararForm(){
	    $forms = array();
	    $formularios = $this->formularios_model->find('result',array( 
				'fields' => array('form_id_formulario','form_nombre')
				));
		$forms[''] = 'Seleccione un Formulario';
		foreach($formularios->result() as $formulario){
			$forms[$formulario->form_id_formulario] = $formulario->form_nombre;
		}
		$this->schema['cam_id_formulario']['data'] = $forms;
    }
}

/* End of file campos_model.php */
/* Location: ./application/censos/models/campos_model.php */