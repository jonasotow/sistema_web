<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 * Transportes_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Author Alfredo Garcia
 * @link http://localhost/sistema_web/censos.php/
 */
class Transportes_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct($db = null) {
        // llamma el Modelo constructor
        parent::__construct($db);
        $this->table_name = 'tra_transportes_mstr';
        $this->schema_add = array(
            'Borrar' => array(
                'tipo' => 'reset',
                'label' => 'Borrar',
                'class' => 'btn btn-default',
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
                'class' => 'btn btn-default',
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
                'class' => 'btn btn-danger',
                'id' => 'eliminar'
            )
        );
         $this->schema = array(
            'Datos Clientes' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
            	'tra_id_transporte' => array(
            		'name' => 'Id',
            		'tipo' => 'int',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => TRUE,
            		'update' => FALSE,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	),
            	'tra_nombre' => array(
            		'name' => 'Nombre',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => FALSE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'tra_imagen' => array(
            		'name' => 'Imagen',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'file',
                    'class' => 'form-control'
            	),
            	'tra_descripcion' => array(
            		'name' => 'Descripcion',
            		'tipo' => 'textarea',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'textarea',
                    'class' => 'form-control'
            	),
            	'tra_capacidad' => array(
            		'name' => 'Capacidad',
            		'tipo' => 'double',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'numerico',
                    'class' => 'form-control'
            	),
            	'tra_estatus' => array(
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

     public function delete_t($id) {
        $this->dbUse->trans_begin();
        $this->dbUse->update('tra_transportes_mstr', array('tra_estatus' => 0 ), array('tra_id_transporte' => $id));
        if ($this->dbUse->trans_status() === FALSE) {
            $this->dbUse->trans_rollback();
            return false;
        }
        $this->dbUse->trans_commit();
        return true;
    }
}
/* End of file transportes_model.php */
/* Location: ./application/models/pedidos/transportes_model.php */