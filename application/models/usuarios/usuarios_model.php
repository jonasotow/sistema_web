<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Usuarios_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Alfredo Garcia
 * @link http://localhost/sistema_web/usuarios.php/
 */
class Usuarios_model extends My_Model {
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
        $this->load->model('usuarios/modelo_generico_model');
        $this->table_name = 'usu_usuarios_mstr';
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
            'class'    => 'btn btn-default',
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
            'class'    => 'btn btn-danger',
            'id'       => 'eliminar'
          )
        );
         $this->schema = array(
            'Usuario' => array(
              'class'  => 'ejemplo',
              'id'     => 'ejemplo',
              'usu_id' => array(
                'name'    => 'Id',
                'tipo'    => 'int',
                'lenght'  => 11,
                'null'    => FALSE,
                'primary' => TRUE,
                'update'  => FALSE,
                'type'    => 'hidden',
                'class'   => 'form-control'
              ),
              'usu_nombre' => array(
                'name'    => 'Nombre',
                'tipo'    => 'varchar',
                'lenght'  => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),

              'usu_apellido_paterno' => array(
                'name'    => 'Apellido Paterno',
                'tipo'    => 'varchar',
                'lenght'  => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),

              'usu_apellido_materno' => array(
                'name'    => 'Apellido Materno',
                'tipo'    => 'varchar',
                'lenght'  => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),

              'usu_email' => array(
                'name'    => 'Email',
                'tipo'    => 'varchar',
                'lenght'  => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'email',
                'class'   => 'form-control'
              ),

              'usu_telefono' => array(
                'name'    => 'Telefono',
                'tipo'    => 'varchar',
                'lenght'  => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),
              'usu_id_tipo' => array(
                'name'    => 'Tipo',
                'tipo'    => 'dropdown',
                'lenght'  => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'dropdown',
                'class'   => 'form-control'
              ),

              'usu_usuario' => array(
                'name'    => 'Usuario',
                'tipo'    => 'varchar',
                'lenght'  => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),

              'usu_password' => array(
                'name'    => 'Password',
                'tipo'    => 'varchar',
                'lenght'  => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'password',
                'class'   => 'form-control'
              ),

              'usu_estatus' => array(
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
        $this->db->update('usu_usuarios_mstr', array('usu_estatus' => 0 ), array('usu_id' => $id));
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