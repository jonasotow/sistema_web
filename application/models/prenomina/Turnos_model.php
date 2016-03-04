<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Turnos_model class
 *
 * @package Prenomina
 * @author Alfredo García
 **/
class Turnos_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct($db = null) {
        // llamma el Modelo constructor
        parent::__construct($db);
        $this->table_name = 'tur_turnos_mstr';
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
        'Turnos' => array(
          'class'  => 'ejemplo',
          'id'     => 'ejemplo',
          'tur_id' => array(
            'name'    => 'Id',
            'tipo'    => 'int',
            'lenght'  => 11,
            'null'    => FALSE,
            'primary' => TRUE,
            'update'  => FALSE,
            'type'    => 'hidden',
            'class'   => 'form-control'
          ),
          'tur_clave_turno' => array(
            'name'    => 'Descripcion',
            'tipo'    => 'varchar',
            'lenght'  => 100,
            'null'    => FALSE,
            'primary' => FALSE,
            'update'  => TRUE,
            'type'    => 'text',
            'class'   => 'form-control'
          ),
          'tur_descripcion' => array(
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
    public function TurnosDiarios(){
      $this->dbUse->select('tur_id,tur_clave_turno');
      $query_Turnos = $this->dbUse->get_where($this->table_name, array('tur_activo' => '1'));
      return $query_Turnos->result();
    }
    /**
     * Elimina los turnos
     * @param  int $id    entra el id para compara que turno sera eliminado
     * @return bolean     regresa TRUE si realiza la eliminacíon
     */
    public function delete_t($id) {
        $this->dbUse->trans_begin();
        $this->dbUse->update('tur_turnos_mstr', array('tur_activo' => 0 ), array('tur_id' => $id));
        if ($this->dbUse->trans_status() === FALSE) {
            $this->dbUse->trans_rollback();
            return false;
        }
        $this->dbUse->trans_commit();
        return true;
    }
}