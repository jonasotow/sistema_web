<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');
/**
 * Motivos_te_model
 *
 * @package Prenomina
 * @author Alfredo Garcìa
 */
class Motivos_te_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
  /**
   * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
   */
  function __construct($db = null) {
    // llamma el Modelo constructor
    parent::__construct($db);
    $this->table_name = 'mte_motivos_tiempo_extra_mstr';
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
      'Motivos tiempo extra' => array(
        'class'  => 'ejemplo',
        'id'     => 'ejemplo',
        'mte_id' => array(
          'name'    => 'Id',
          'tipo'    => 'int',
          'lenght'  => 11,
          'null'    => FALSE,
          'primary' => TRUE,
          'update'  => FALSE,
          'type'    => 'hidden',
          'class'   => 'form-control'
        ),
        'mte_clave' => array(
          'name'    => 'Descripcion',
          'tipo'    => 'varchar',
          'lenght'  => 100,
          'null'    => FALSE,
          'primary' => FALSE,
          'update'  => TRUE,
          'type'    => 'text',
          'class'   => 'form-control'
        ),
        'mte_descripcion' => array(
          'name'    => 'Subdescripcion',
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
    
  public function motivosTiempoExtra(){
    $this->dbUse->select('mte_id,mte_descripcion');
    $query_motivos_te = $this->dbUse->get_where($this->table_name, array('mte_activo' => '1'));
    return $query_motivos_te->result();
  }
  public function delete_t($id) {
      $this->dbUse->trans_begin();
      $this->dbUse->update($this->table_name, array('mte_activo' => 0 ), array('mte_id' => $id));
      if ($this->dbUse->trans_status() === FALSE) {
          $this->dbUse->trans_rollback();
          return false;
      }
      $this->dbUse->trans_commit();
      return true;
  }
}