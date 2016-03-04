<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Departamentos_model class
 *
 * @package Prenomina
 * @author  Alfredo García
 **/
class Departamentos_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct($db = null) {
      // llamma el Modelo constructor
      parent::__construct($db);
      $this->table_name = 'dep_departamentos_mstr';
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
        'Departamentos' => array(
        'class'  => 'ejemplo',
        'id'     => 'ejemplo',
        'dep_id' => array(
          'name'    => 'Id',
          'tipo'    => 'int',
          'lenght'  => 11,
          'null'    => FALSE,
          'primary' => TRUE,
          'update'  => FALSE,
          'type'    => 'hidden',
          'class'   => 'form-control'
        ),

          'dep_ubicaicon' => array(
            'name'    => 'Descripcion',
            'tipo'    => 'varchar',
            'lenght'  => 100,
            'null'    => FALSE,
            'primary' => FALSE,
            'update'  => TRUE,
            'type'    => 'text',
            'class'   => 'form-control'
          )
        )        
      );
    }
    
    public function delete_t($id) {
        $this->dbUse->trans_begin();
        $this->dbUse->update($this->table_name, array('activo' => 0 ), array('dep_id' => $id));
        if ($this->dbUse->trans_status() === FALSE) {
            $this->dbUse->trans_rollback();
            return false;
        }
        $this->dbUse->trans_commit();
        return true;
    }
}