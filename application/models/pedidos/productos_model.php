<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Productos_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Author Alfredo Garcia
 * @link http://localhost/sistema_web/pedidos.php/
 */
class productos_model extends My_Model {
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
        $this->table_name = 'pro_productos_mstr';
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
            'Producto' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
            	'pro_id_producto' => array(
            		'name' => 'Id',
            		'tipo' => 'int',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => TRUE,
            		'update' => FALSE,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	),

            	'pro_clave' => array(
            		'name' => 'Clave',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'pro_marca' => array(
            		'name' => 'Marca',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'pro_descripcion' => array(
            		'name' => 'Descripcion',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'pro_especie' => array(
            		'name' => 'Especie',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'pro_minima' => array(
            		'name' => 'Minima',
            		'tipo' => 'double',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'number',
                    'class' => 'form-control'
            	),

                'pro_imagen' => array(
                    'name' => 'Imagen',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'file',
                    'class' => 'form-control'
                ),

            	'pro_estatus' => array(
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
/* 
    function prepararForm(){
	    $forms = array();
	    $formularios = $this->modelo_generico_model->get_estados();
	    $forms[''] = 'Seleccione un Estado';
		foreach($formularios as $formulario){
			$forms[$formulario->est_estado] = $formulario->est_estado;
		}
		$this->schema['pla_estado']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get_valor_tabla_generica('esp_especie');
	    $forms[''] = 'Seleccione una Especie';
		foreach($formularios as $formulario){
			$forms[$formulario->tblgval_valor] = $formulario->tblgval_valor;
		}
		$this->schema['pla_especie']['data'] = $forms;
    }
*/

     public function delete_t($id) {
        $this->db->trans_begin();
        $this->db->update('pro_productos_mstr', array('pro_estatus' => 0 ), array('pro_id_producto' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }
}
/* End of file productos_model.php */
/* Location: ./application/models/pedidos/productos_model.php */