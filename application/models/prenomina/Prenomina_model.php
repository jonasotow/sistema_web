<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Prenomina_model
 *
 * @package Prenomina
 * @subpackage None
 * @category Model
 * @author Alfredo Garcia
 * @link None
 */
class Prenomina_model extends My_Model {
  public $table_name;
  public $schema;
  public $schema_add;

  /**
   * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
   */
  function __construct($db = null) {
      // llamma el Modelo constructor
      parent::__construct($db);
      $this->table_name = 'pre_prenominas_det';
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
        'Pre-Nomina' => array(
          'class'  => 'ejemplo',
          'id'     => 'ejemplo',
          'pre_id' => array(
            'name'    => 'Id',
            'tipo'    => 'int',
            'lenght'  => 11,
            'null'    => FALSE,
            'primary' => TRUE,
            'update'  => FALSE,
            'type'    => 'hidden',
            'class'   => 'form-control'
          ),
          'pre_semana_ano' => array(
            'name'    => 'Descripcion',
            'tipo'    => 'varchar',
            'lenght'  => 100,
            'null'    => FALSE,
            'primary' => FALSE,
            'update'  => TRUE,
            'type'    => 'text',
            'class'   => 'form-control'
          ),
          'pre_emp_id' => array(
            'name'    => 'Subdescripcion',
            'tipo'    => 'varchar',
            'lenght'  => 100,
            'null'    => FALSE,
            'primary' => FALSE,
            'update'  => TRUE,
            'type'    => 'text',
            'class'   => 'form-control'
          ),
          'link' => array(
            'name'    => 'Link',
            'tipo'    => 'varchar',
            'lenght'  => 100,
            'null'    => FALSE,
            'primary' => FALSE,
            'update'  => TRUE,
            'type'    => 'url',
            'class'   => 'form-control'
          ),
          'especie' => array(
            'name'    => 'Especie',
            'tipo'    => 'varchar',
            'lenght'  => 100,
            'null'    => FALSE,
            'primary' => FALSE,
            'update'  => TRUE,
            'type'    => 'text',
            'class'   => 'form-control'
          ),
          'imagen' => array(
            'name'    => 'Imagen',
            'tipo'    => 'varchar',
            'lenght'  => 255,
            'null'    => FALSE,
            'primary' => FALSE,
            'update'  => TRUE,
            'type'    => 'file',
            'class'   => 'form-control'
          ),
          'posicion' => array(
            'name'    => 'Posicion',
            'tipo'    => 'varchar',
            'lenght'  => 100,
            'null'    => FALSE,
            'primary' => FALSE,
            'update'  => TRUE,
            'type'    => 'number',
            'class'   => 'form-control'
          )
        )        
      );
  }

  public function tablaPrenomina(){
    $query_empleados = $this->dbUse->get($this->table_name); 
    return $query_empleados->result();
  }
   
  public function tablaPrenominaEmpleados(){
    $this->dbUse->select('emp_id,emp_numero,emp_nombre,emp_apellido_paterno,emp_apellido_materno,emp_dep_ubicacion');
    $this->dbUse->from('emp_empleados_mstr');
  //  $this->dbUse->join('pre_prenomina_det','','INNER');
    $query_empleados = $this->dbUse->get(); 
    return $query_empleados->result();
  } 
  public function delete_t($id) {
      $this->dbUse->trans_begin();
      $this->dbUse->update($this->table_name, array('pre_activo' => 0 ), array('pre_id' => $id));
      if ($this->dbUse->trans_status() === FALSE) {
          $this->dbUse->trans_rollback();
          return false;
      }
      $this->dbUse->trans_commit();
      return true;
  }
}