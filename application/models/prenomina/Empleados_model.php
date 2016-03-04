<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Empleados_model class
 *
 * @package Prenomina
 * @author Alfredo García
 **/
class Empleados_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct($db = null) {
        // llamma el Modelo constructor
        parent::__construct($db);
        $this->table_name = 'emp_empleados_mstr';
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

         $this->schema = array(
            'Empleados' => array(
              'class'  => 'ejemplo',
              'id'     => 'ejemplo',
              'emp_id' => array(
                'name'    => 'Id',
                'tipo'    => 'int',
                'lenght'  => 11,
                'null'    => FALSE,
                'primary' => TRUE,
                'update'  => FALSE,
                'type'    => 'hidden',
                'class'   => 'form-control'
              ),

              'emp_numero' => array(
                'name'    => 'Descripcion',
                'tipo'    => 'varchar',
                'lenght'  => 100,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),

              'emp_nombre' => array(
                'name'    => 'Subdescripcion',
                'tipo'    => 'varchar',
                'lenght'  => 100,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),

              'emp_apellido_paterno' => array(
                'name'    => 'Link',
                'tipo'    => 'varchar',
                'lenght'  => 100,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'url',
                'class'   => 'form-control'
              ),

              'emp_apellido_materno' => array(
                'name'    => 'Especie',
                'tipo'    => 'varchar',
                'lenght'  => 100,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'dropdown',
                'class'   => 'form-control'
              ),
              'emp_dep_ubicacion' => array(
                'name'    => 'Imagen',
                'tipo'    => 'varchar',
                'lenght'  => 255,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'selct',
                'class'   => 'form-control'
              )
            )        
          );
    }// end constructor
    
    public function delete_t($id) {
        $this->dbUse->trans_begin();
        $this->dbUse->update($this->table_name, array('activo' => 0 ), array('idHoja_tecnica' => $id));
        if ($this->dbUse->trans_status() === FALSE) {
            $this->dbUse->trans_rollback();
            return false;
        }
        $this->dbUse->trans_commit();
        return true;
    }
}// END class 

/* End of file plantas_model.php */
/* Location: ./application/models/usuarios/plantas_model.php */