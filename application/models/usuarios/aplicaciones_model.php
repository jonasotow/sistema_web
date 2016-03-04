<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Aplicaciones_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Alfredo Garcia
 * @link http://localhost/sistema_web/usuarios.php/
 */
class Aplicaciones_model extends My_Model {
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
        $this->load->model('usuarios/usuarios_model','oCliente',FALSE,'usuarios');
        $this->table_name = "apl_aplicaciones_mstr";
        $this->schema_add = array(
          'Borrar'  => array(
            'tipo'    => 'reset',
            'label'   => 'Limpiar',
            'class'   => 'btn btn-default',
            'id'      => 'limpiar'
          ),
          'Guardar' => array(
            'tipo'    => 'submit',
            'label'   => 'Guardar',
            'class'   => 'btn btn-primary',
            'id'      => 'guardar'
          )
        );
        $this->schema_up = array(
          'Borrar'   => array(
            'tipo'     => 'reset',
            'label'    => 'Borrar',
            'class'    => 'btn btn-primary',
            'id'       => 'borrar'
          ),
          'Guardar'  => array(
            'tipo'     => 'submit',
            'label'    => 'Guardar',
            'class'    => 'btn btn-primary',
            'id'       => 'guardar'
          ),
          'Eliminar' => array(
            'tipo'     => 'submit',
            'label'    => 'Eliminar',
            'class'    => 'btn btn-primary',
            'id'       => 'eliminar'
          )
        );
         $this->schema = array(
            'Aplicacion' => array(
              'class'  => 'ejemplo',
              'id'     => 'ejemplo',
              'apl_id' => array(
                'name'    => 'Id',
                'tipo'    => 'int',
                'lenght'  => 11,
                'null'    => FALSE,
                'primary' => TRUE,
                'update'  => FALSE,
                'type'    => 'hidden',
                'class'   => 'form-control'
              ),

              'apl_nombre' => array(
                'name'    => 'Nombre',
                'tipo'    => 'varchar',
                'lenght'  => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),

              'apl_descripcion' => array(
                'name'    => 'Descripcion',
                'tipo'    => 'varchar',
                'lenght'  => 50,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'textarea',
                'class'   => 'form-control'
              ),

              'apl_estatus' => array(
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

    public function show_applications() {
      return $this->find('',array(
        'field' => array('apl_nombre,apl_id'),
        'conditions' => array('apl_estatus' => 1)
      )); 
    }
    
    public function delete_t($id) {
        $this->db->trans_begin();
        $this->db->update('apl_aplicaciones_mstr', array('apl_estatus' => 0 ), array('apl_id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }
}

/* End of file plantas_model.php */
/* Location: ./application/models/usuarios/plantas_model.php */