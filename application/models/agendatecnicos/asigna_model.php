<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  contacto_model Class
 *
 *  @category:  Modelo
 *  @author:    Antonio Gaxiola
 */
class Asigna_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    function __construct() {
        parent::__construct();
        $this->table_name = 'tecd_tecnicos_det';
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
            'Seleccionar t&eacute;cnicos' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
                'tecd_id' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 2,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden'
                ),
                'tecd_idusuario' => array(
                    'name' => 'Gerente',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'tecd_idtec' => array(
                    'name' => 'Asignar los siguientes t&eacute;cnicos',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'tecd_estatus' => array(
                    'name' => 'Estatus',
                    'tipo' => 'int',
                    'lenght' => 2,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => FALSE,
                    'type' => 'hidden'                    
                )
            )    
        );
    }
}

/* End of file campos_model.php */
/* Location: ./application/censos/models/campos_model.php */