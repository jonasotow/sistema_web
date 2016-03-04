<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Formularios_model
 *
 * @package None
 * @subpackage None
 * @category Pedidos
 * @author Alfredo Garcia
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
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => FALSE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),
            	'form_descripcion' => array(
            		'name' => 'Descripcion',
            		'tipo' => 'varchar',
            		'lenght' => 30,
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

     public function delete_t($id) {
        $this->db->trans_begin();
        $this->db->update('form_formularios_mstr', array('form_estatus' => 0 ), array('form_id_formulario' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }
}
/* End of file formularios_model.php */
/* Location: ./application/models/pedidos/formularios_model.php */