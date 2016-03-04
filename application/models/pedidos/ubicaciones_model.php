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
class Ubicaciones_model extends My_Model {
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
        $this->table_name = 'ubi_ubicaciones_mstr';
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
            'Ubicaciones' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
            	'ubi_id_ubicacion' => array(
            		'name' => 'Id',
            		'tipo' => 'int',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => TRUE,
            		'update' => FALSE,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	),

            	'ubi_nombre' => array(
            		'name' => 'Nombre',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'ubi_direccion' => array(
            		'name' => 'Apellido paterno',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'ubi_estatus' => array(
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
        $this->dbUse->update('ubi_ubicaciones_mstr', array('ubi_estatus' => 0 ), array('ubi_id_ubicacion' => $id));
        if ($this->dbUse->trans_status() === FALSE) {
            $this->dbUse->trans_rollback();
            return false;
        }
        $this->dbUse->trans_commit();
        return true;
    }
}

/* End of file ejecutivas_model.php */
/* Location: ./application/models/pedidos/ejecutivas_model.php */