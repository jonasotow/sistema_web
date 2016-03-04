<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Ejecutivas_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Author Alfredo Garcia
 * @link http://localhost/sistema_web/pedidos.php/
 */
class Ejecutivos_model extends My_Model {
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
        $this->load->model('pedidos/modelo_generico_model');
        $this->table_name = 'eje_ejecutivos_mstr';
        $this->schema_add = array(
            'Borrar' => array(
                'tipo' => 'reset',
                'label' => 'Limpiar',
                'class' => 'btn btn-default',
                'id' => 'limpiar'
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
            'Ejacutivos' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
            	'eje_id_ejecutivo' => array(
            		'name' => 'Id',
            		'tipo' => 'int',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => TRUE,
            		'update' => FALSE,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	),

            	'eje_nombre' => array(
            		'name' => 'Nombre',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'eje_apellido_paterno' => array(
            		'name' => 'Apellido paterno',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'eje_apellido_materno' => array(
            		'name' => 'Apellido materno',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'eje_planta' => array(
            		'name' => 'Planta',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'dropdown',
                    'class' => 'form-control'
            	),
                'eje_correo' => array(
                    'name' => 'Correo',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
            	'eje_estatus' => array(
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
        $formularios = $this->modelo_generico_model->get_value('pla_plantas_mstr', 'pla_id_planta', 'pla_nombre');
        $forms[''] = 'Seleccione un Planta';
        foreach($formularios as $formulario){
            $forms[$formulario->pla_nombre] = $formulario->pla_nombre;
        }
        $this->schema['Ejacutivos']['eje_planta']['data'] = $forms;
    }

    public function delete_t($id) {
        $this->dbUse->trans_begin();
        $this->dbUse->update('eje_ejecutivos_mstr', array('eje_estatus' => 0 ), array('eje_id_ejecutivo' => $id));
        if ($this->dbUse->trans_status() === FALSE) {
            $this->dbUse->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }
}

/* End of file ejecutivas_model.php */
/* Location: ./application/models/pedidos/ejecutivas_model.php */