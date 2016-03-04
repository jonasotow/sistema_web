<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Roles_recursos_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Alfredo Garcia
 * @link http://localhost/sistema_web/usuarios.php/
 */
class Roles_recursos_model extends My_Model {
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
        $this->table_name = 'rolrec_roles_recursos_det';
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
            'Rol recursos' => array(
              'class'  => 'ejemplo',
              'id'     => 'ejemplo',
              'rolrec_id' => array(
                'name'    => 'Id',
                'tipo'    => 'int',
                'lenght'  => 11,
                'null'    => FALSE,
                'primary' => TRUE,
                'update'  => FALSE,
                'type'    => 'hidden',
                'class'   => 'form-control'
              ),

              'rolrec_rol_id' => array(
                'name'    => 'Id_rol',
                'tipo'    => 'int',
                'lenght' => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),

              'rolrec_recurso_id' => array(
                'name'    => 'Id_recurso',
                'tipo'    => 'int',
                'lenght' => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'number',
                'class'   => 'form-control'
              ),

              'rolrec_estatus' => array(
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
        $this->db->update('rolrec_roles_recursos_det', array('rolrec_estatus' => 0 ), array('rolrec_id' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }
}
/* End of file roles_recursos_model.php */
/* Location: ./application/models/usuarios/roles_recursos_model.php */