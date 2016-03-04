<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Aplicaciones_roles_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Alfredo Garcia
 * @link http://localhost/sistema_web/usuarios.php/
 */
class Aplicaciones_roles_model extends My_Model {
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
        $this->load->model('usuarios/modelo_generico_model');
        $this->table_name = 'aplrol_aplicaciones_roles_det';
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
            'Aplicacion Roles' => array(
              'class'  => 'ejemplo',
              'id'     => 'ejemplo',
              'aplrol_id' => array(
                'name'    => 'Id',
                'tipo'    => 'int',
                'lenght'  => 11,
                'null'    => FALSE,
                'primary' => TRUE,
                'update'  => FALSE,
                'type'    => 'hidden',
                'class'   => 'form-control'
              ),

              'aplrol_aplicacion_id' => array(
                'name'    => 'Id_aplicacion',
                'tipo'    => 'int',
                'lenght' => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'number',
                'class'   => 'form-control'
              ),

              'aplrol_rol_id' => array(
                'name'    => 'Id_rol',
                'tipo'    => 'int',
                'lenght' => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'numbre',
                'class'   => 'form-control'
              ),

              'aplrol_estatus' => array(
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

    public function delete_t($id) {
        $this->db->trans_begin();
        $this->db->update('aplrol_aplicaciones_roles_det', array('aplrol_estatus' => 0 ), array('aplrol_id' => $id));
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