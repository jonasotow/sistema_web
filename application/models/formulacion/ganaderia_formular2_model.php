<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tipo_model.php
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Daniel Villa
 */

class Ganaderia_Formular2_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "";
        $this->schema_add = array(
            'Atras' => array(
                'tipo' => 'back',
                'label' => 'Atras',
                'class' => 'btn btn-primary',
                'id' => 'atras'
            ),
            'Guardar' => array(
                'tipo' => 'submit',
                'label' => 'Siguiente',
                'class' => 'btn btn-primary',
                'id' => 'guardar_especie'
            )
        );
        $this->schema_up = array(
            'Atras' => array(
                'tipo' => 'back',
                'label' => 'Atras',
                'class' => 'btn btn-primary',
                'id' => 'atras'
            ),
            'Guardar' => array(
                'tipo' => 'submit',
                'label' => 'Siguiente',
                'class' => 'btn btn-primary',
                'id' => 'guardar_especie'
            )
        );
        $this->schema = array(
            'Paso 2' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
                'idSubespecie' => array(
                    'id' => 'idEspecie',
                    'name' => 'Especie',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'idEtapa' => array(
                    'id' => 'idEtapa',
                    'name' => 'Etapa',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'idProducto' => array(
                    'id' => 'idProducto',
                    'name' => 'Producto',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'Precio' => array(
                    'name' => 'Precio',
                    'tipo' => 'varchar',
                    'lenght' => 20,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
            )
        );
    }

    function prepararForm(){
        $forms = array();
        $formularios = $this->get('Subespecie','idSubespecie,Subespecie');
        $forms[0] = 'Seleccione una Subespecie';
        foreach($formularios as $formulario){
            $forms[$formulario->idSubespecie] = $formulario->Subespecie;
        }
        $this->schema['Paso 2']['idSubespecie']['data'] = $forms;
        $forms = array();
        $formularios = $this->get('Etapa','idEtapa,Etapa');
        $forms[0] = 'Seleccione una Etapa';
        foreach($formularios as $formulario){
            $forms[$formulario->idEtapa] = $formulario->Etapa;
        }
        $this->schema['Paso 2']['idEtapa']['data'] = $forms;
        $forms = array();
        $formularios = $this->get('Producto','idProducto,Producto');
        $forms[0] = 'Seleccione un Producto';
        foreach($formularios as $formulario){
            $forms[$formulario->idProducto] = $formulario->Producto;
        }
        $this->schema['Paso 2']['idProducto']['data'] = $forms;
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