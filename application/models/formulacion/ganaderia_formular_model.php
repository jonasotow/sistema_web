<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Ganaderia_Formular_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "origenes";
        $this->schema_add = array(
            'Borrar' => array(
                'tipo' => 'reset',
                'label' => 'Borrar',
                'class' => 'btn btn-primary',
                'id' => 'borrar'
            ),
            'Guardar' => array(
                'tipo' => 'submit',
                'label' => 'Siguiente',
                'class' => 'btn btn-primary',
                'id' => 'guardar_especie'
            )
        );
        $this->schema_up = array(
            'Borrar' => array(
                'tipo' => 'reset',
                'label' => 'Borrar',
                'class' => 'btn btn-primary',
                'id' => 'borrar'
            ),
            'Guardar' => array(
                'tipo' => 'submit',
                'label' => 'Siguiente',
                'class' => 'btn btn-primary',
                'id' => 'guardar_especie'
            )
        );
        $this->schema = array(
            'Paso 1' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
                'idorigen' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'solicitanta' => array(
                    'name' => 'Solicitante',
                    'tipo' => 'varchar',
                    'lenght' => 50,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'fecha' => array(
                    'name' => 'Fecha',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => false,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'tipo_solicitante' => array(
                    'name' => 'Tipo de solicitante',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => false,
                    'type' => 'radio',
                    'class' => 'form-control',
                    'data' => array(1 => 'Cliente: ', 
                                    2 => 'Prospecto: ')
                ),
                'nombre' => array(
                    'name' => 'Nombre Cliente',
                    'tipo' => 'varchar',
                    'lenght' => 50,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => false,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'telefono' => array(
                    'name' => 'Telefono/Fax',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => false,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'correo' => array(
                    'name' => 'Email',
                    'tipo' => 'varchar',
                    'lenght' => 40,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => false,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'no_cabezas' => array(
                    'name' => 'Numero de Cabezas',
                    'tipo' => 'varchar',
                    'lenght' => 5,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => false,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'tipo_mezclado' => array(
                    'name' => 'Tipo de mezclado',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => false,
                    'type' => 'radio',
                    'class' => 'form-control',
                    'data' => array(1 => 'Manual: ', 
                                    2 => 'Mezcladora Horizontal: ', 
                                    3 => 'Mezcladora Vertical: ',
                                    4 => 'Carro Mezclador: ')
                )
            )
        );
    }

    function prepararForm(){
        $forms = array();
        $formularios = $this->get('Estado','idestado,descripcion');
        $forms[0] = 'Seleccione un Estado';
        foreach($formularios as $formulario){
            $forms[$formulario->idestado] = $formulario->descripcion;
        }
        $this->schema['Datos Origen']['idestado']['data'] = $forms;
        $forms = array();
        $formularios = $this->get('ciudad','idciudad,descripcion');
        $forms[0] = 'Seleccione una Ciudad';
        foreach($formularios as $formulario){
            $forms[$formulario->idciudad] = $formulario->descripcion;
        }
        $this->schema['Datos Origen']['idciudad']['data'] = $forms;
    }

    function get($tabla,$campos = null,$where = null,$order = null){
        if (!is_null($campos))
            $this->db->select($campos); 
        if (!is_null($where))
            $this->db->where($where);
        if (!is_null($order))
            $this->db->order_by($order);
        $query = $this->db->get($tabla);
        return $query->result();
    }

    public function delete_t($id) {
    $this->db->trans_begin();
    $this->db->update('tipo', array('tipo_status' => 0 ), array('idtipo' => $id));
    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
    }
    $this->db->trans_commit();
    return true;
  }
}