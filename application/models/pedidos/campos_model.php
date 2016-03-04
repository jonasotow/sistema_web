<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Campos_model
 *
 * @package Package Name
 * @subpackage Subpackage
 * @category Censos
 * @author Alfredo Garcia
 * @link http://localhost/sistema_web/censos.php/
 */
class Campos_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    function __construct($db = null) {
        parent::__construct($db);
        $this->table_name = 'cam_campos_det';
        $this->load->model('pedidos/formularios_model');
        $this->schema_add = array(
            'Borrar' => array(
                'tipo'  => 'reset',
                'label' => 'Borrar',
                'class' => 'btn btn-default',
                'id'    => 'borrar'
            ),
            'Guardar' => array(
                'tipo'  => 'submit',
                'label' => 'Guardar',
                'class' => 'btn btn-primary',
                'id'    => 'guardar'
            )
        );
        $this->schema_up = array(
            'Borrar' => array(
                'tipo'  => 'reset',
                'label' => 'Borrar',
                'class' => 'btn btn-default',
                'id'    => 'borrar'
            ),
            'Guardar' => array(
                'tipo'  => 'submit',
                'label' => 'Guardar',
                'class' => 'btn btn-primary',
                'id'    => 'guardar'
            ),
            'Eliminar' => array(
                'tipo'  => 'submit',
                'label' => 'Eliminar',
                'class' => 'btn btn-danger',
                'id'    => 'eliminar'
            )
        );
        $this->schema = array(
            'Datos Campos' => array(
                'class' => 'ejemplo',
                'id'    => 'ejemplo',
            	'cam_id_campo' => array(
                    'name'    => 'Idcampo',
                    'tipo'    => 'int',
                    'lenght' => 30,
                    'null'    => FALSE,
                    'primary' => TRUE,
                    'update'  => FALSE,
                    'type'    => 'hidden',
                    'class'   => 'form-control'
            	),
            	'cam_id_formulario' => array(
                    'name'    => 'Formulario',
                    'tipo'    => 'int',
                    'lenght' => 30,
                    'null'    => FALSE,
                    'primary' => FALSE,
                    'update'  => FALSE,
                    'type'    => 'text',
                    'class'   => 'form-control'
            	),
            	'cam_id' => array(
                    'name'    => 'Id Campo',
                    'tipo'    => 'varchar',
                    'lenght' => 30,
                    'null'    => FALSE,
                    'primary' => FALSE,
                    'update'  => TRUE,
                    'type'    => 'text',
                    'class'   => 'form-control'
            	),
            	'cam_label' => array(
                    'name'    => 'Etiqueta',
                    'tipo'    => 'varchar',
                    'lenght' => 30,
                    'null'    => FALSE,
                    'primary' => FALSE,
                    'update'  => TRUE,
                    'type'    => 'text',
                    'class'   => 'form-control'
            	),
            	'cam_type' => array(
                    'name'    => 'Tipo',
                    'tipo'    => 'varchar',
                    'lenght' => 30,
                    'null'    => FALSE,
                    'primary' => FALSE,
                    'update'  => TRUE,
                    'type'    => 'dropdown',
                    'data'    => array(
                        ''         => 'Seleccione un Tipo',
                        'text'     => 'text',
                        'radio'    => 'radio',
                        'checkbox' => 'checkbox',
                        'textarea' => 'textarea',
                        'select'   => 'select',
                        'number'   => 'number'
    				),
                    'class'   => 'form-control'
            	),
            	'cam_name' => array(
                    'name'    => 'Nombre',
                    'tipo'    => 'varchar',
                    'lenght' => 30,
                    'null'    => FALSE,
                    'primary' => FALSE,
                    'update'  => TRUE,
                    'type'    => 'text',
                    'class'   => 'form-control'
            	),
            	'cam_value' => array(
                    'name'    => 'Valores',
                    'tipo'    => 'text',
                    'lenght' => 30,
                    'null'    => FALSE,
                    'primary' => FALSE,
                    'update'  => TRUE,
                    'type'    => 'textarea',
                    'class'   => 'form-control'
            	),
            	'cam_required' => array(
                    'name'    => 'Requerido',
                    'tipo'    => 'varchar',
                    'lenght' => 30,
                    'null'    => FALSE,
                    'primary' => FALSE,
                    'update'  => TRUE,
                    'type'    => 'dropdown',
                    'data'    => array(
                        '1' => 'True',
                        '0' => 'False',
                    ),
                    'class'   => 'form-control'
            	),
            	'cam_posicion' => array(
                    'name'    => 'Posicion',
                    'tipo'    => 'int',
                    'lenght' => 30,
                    'null'    => FALSE,
                    'primary' => FALSE,
                    'update'  => TRUE,
                    'type'    => 'number',
                    'class'   => 'form-control'
            	),
            	'cam_estatus' => array(
                    'name'    => 'Estatus',
                    'tipo'    => 'boolean',
                    'lenght'  => 1,
                    'null'    => FALSE,
                    'primary' => FALSE,
                    'update'  => TRUE,
                    'type'    => 'hidden',
                    'class'   => 'form-control'
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
		$this->schema['Datos Campos']['cam_id_formulario']['data'] = $forms;
    }

     public function delete_t($id) {
        $this->dbUse->trans_begin();
        $this->dbUse->update('cam_campos_det', array('cam_estatus' => 0 ), array('cam_id_campo' => $id));
        if ($this->dbUse->trans_status() === FALSE) {
            $this->dbUse->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }
}

/* End of file campos_model.php */
/* Location: ./application/pedidos/models/campos_model.php */