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
class Tecnicos_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    function __construct($db = null) {
        parent::__construct($db);
        $this->table_name = 'tec_tecnicos_mstr';
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
                'id' => 'eliminar',
                'value' => 'Eliminar'
            )
        );
        $this->schema = array(
            'Datos Generales' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
            	'tec_id' => array(
            		'name' => 'Id',
            		'tipo' => 'int',
            		'lenght' => 100,
            		'null' => FALSE,
            		'primary' => TRUE,
            		'update' => FALSE,
    				'type' => 'hidden'
            	),
            	'tec_nombre' => array(
            		'name' => 'Nombre',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text'
            	),
            	'tec_apellidos' => array(
            		'name' => 'Apellidos',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text'
            	),
                'tec_region' => array(
                    'name' => 'Regi&oacute;n',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text'
                ),
            	'tec_domicilio' => array(
            		'name' => 'Domicilio',
            		'tipo' => 'varchar',
            		'lenght' => 28,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,                    
    				'type' => 'textarea'
            	),
                'tec_ciudad' => array(
                    'name' => 'Ciudad',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text'
                ),
                'tec_estado' => array(
                    'name' => 'Estado',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text'
                ),
                'tec_color' => array(
                    'name' => 'Selecciona color para el t&eacute;cnico',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'color'
                ), 
                'tec_estatus' => array(
                    'name' => 'Estatus',
                    'tipo' => 'varchar',
                    'lenght' => 2,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'hidden',                    
                )
            ),
            'Datos de contacto' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',                
                'tec_telefono' => array(
                    'name' => 'Tel&eacute;fono',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text'
                ),
                'tec_celular' => array(
                    'name' => 'Celular',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text'
                ),
                'tec_correo' => array(
                    'name' => 'Correo',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text'
                ),
                'tec_facebook' => array(
                    'name' => 'Facebook',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text'
                ),
                'tec_twitter' => array(
                    'name' => 'Twitter',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text'
                ),
                'tec_web' => array(
                    'name' => 'P&aacute;gina Web',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text'
                )
            )    
        );
    }
}

/* End of file campos_model.php */
/* Location: ./application/censos/models/campos_model.php */