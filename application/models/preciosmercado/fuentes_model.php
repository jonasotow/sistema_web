<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fuentes_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('preciosmercado/modelo_generico_model');
        $this->table_name = "fuente";
        $this->schema_add = array(
            'Borrar' => array(
                'tipo' => 'reset',
                'label' => 'Borrar',
                'class' => 'btn btn-primary',
                'id' => 'borrar'
            ),
            'Guardar' => array(
                'tipo' => 'submit',
                'label' => 'Guardar',
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
                'label' => 'Guardar',
                'class' => 'btn btn-primary',
                'id' => 'guardar_especie'
            )
        );
        $this->schema = array(
            'Datos Fuentes' => array(
                'class' => '',
                'id' => '',
                'idfuente' => array(
                    'name' => 'Id',
                    'tipo' => 'int',
                    'lenght' => 11,
                    'null' => FALSE,
                    'primary' => TRUE,
                    'update' => FALSE,
                    'type' => 'hidden',
                    'class' => 'form-control'
                ),
                'idtipo_clase' => array(
                    'name' => 'Clase',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'idregion' => array(
                    'name' => 'Region',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'dropdown',
                    'class' => 'form-control'
                ),
                'fuente' => array(
                    'name' => 'Fuente',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'contacto' => array(
                    'name' => 'Contacto',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'pagina' => array(
                    'name' => 'Pagina',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'correo' => array(
                    'name' => 'Correo',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                ),
                'telefono' => array(
                    'name' => 'Telefono',
                    'tipo' => 'varchar',
                    'lenght' => 30,
                    'null' => FALSE,
                    'primary' => FALSE,
                    'update' => TRUE,
                    'type' => 'text',
                    'class' => 'form-control'
                )
            )
        );
    }

    function prepararForm(){
        $forms = array();
        $formularios = $this->get('region','idregion,region','region_status = 1');
        $forms[''] = 'Seleccione una Region';
        foreach($formularios as $formulario){
            $forms[$formulario->idregion] = $formulario->region;
        }
        $this->schema['Datos Fuentes']['idregion']['data'] = $forms;

        $forms = array();
        $formularios = $this->modelo_generico_model->get_tipo_clase();
        $forms[0] = 'Seleccione una Clase';
        foreach($formularios as $formulario){
            $forms[$formulario->idtipo_clase] = $formulario->clase;
        }
        $this->schema['Datos Fuentes']['idtipo_clase']['data'] = $forms;
    }

    function get($tabla,$campos = null,$where = null){
        if (!is_null($campos))
            $this->db->select($campos); 
        if (!is_null($where))
            $this->db->where($where);
        $query = $this->db->get($tabla);
        return $query->result();
    }

    public function delete_t($id) {
        $this->db->trans_begin();
        $this->db->update('fuente', array('fuente_status' => 0 ), array('idfuente' => $id));
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

}