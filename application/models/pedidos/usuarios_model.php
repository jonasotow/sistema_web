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
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
  //      $this->load->model('usuarios/modelo_generico_model');
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
              'class'  => 'Usuarios_orden_compra',
              'id'     => 'Usuarios_orden_compra',
              'usu_id' => array(
                'name'    => 'Id',
                'tipo'    => 'int',
                'lenght'  =>  11,
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
                'lenght'  => 35,
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
                'type'    => 'tel',
                'class'   => 'form-control'
              ),

              'usu_usuario' => array(
                'name'    => 'Usuario',
                'tipo'    => 'varchar',
                'lenght'  => 30,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => FALSE,
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
              
              'usu_password_conf' => array(
                'name'    => 'Confirmar Password',
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
                'tipo'    => 'int',
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

    public function insert_usu_apl($id) {
        $this->db->trans_begin();
        $this->db->insert('usuapl_usuarios_aplicaciones_det', array('usuapl_usuario_id' => $id, 'usuapl_aplicacion_id' => 3, 'usuapl_rol_id' => 5, 'usuapl_estatus' => 1 ));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    public function insert_usu_tip($id,$id_asignado) {
        $this->db->trans_begin();
        $this->db->insert('usuasi_usuarios_asignados_det', array('usuasi_id_usuario' => $id, 'usuasi_id_asignado' => $id_asignado ));
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