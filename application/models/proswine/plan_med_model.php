<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 * Super Class
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Author Alfredo Garcia
 * @link http://localhost/sistema_web/censos.php/
 */
class Plan_Med_Model extends My_Model {
    public $table_name;
    public $schema;
    
    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
        $this->table_name = 'pmed_mstr';
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
				'id' => 'guardar'
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
				'id' => 'guardar'
			),
			'Eliminar' => array(
				'tipo' => 'submit',
				'label' => 'Eliminar',
				'class' => 'btn btn-primary',
				'id' => 'eliminar'
			)
        );
         $this->schema = array(
         	'Datos' => array(
         		'class' => 'ejemplo',
         		'id' => 'ejemplo',
	        	'idpmed_mstr' => array(
	        		'name' => 'Id',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	),
	        	'pmed_group' => array(
	        		'name' => 'Grupo',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'pmed_week' => array(
	        		'name' => 'Semana',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'pmed_day' => array(
	        		'name' => 'Dia Manejo',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'pmed_type' => array(
	        		'name' => 'Tipo',
	        		'tipo' => 'text',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown'
	        	),
	        	'pmed_typed' => array(
	        		'name' => 'Tipo',
	        		'tipo' => 'text',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown'
	        	),
	        	'pmed_via' => array(
	        		'name' => 'Via',
	        		'tipo' => 'text',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'textarea'
	        	),
	        	'pmed_dosis' => array(
	        		'name' => 'Dosis',
	        		'tipo' => 'text',
	        		'lenght' => 1,
	        		'null' => TRUE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'textarea'
	        	),
	        	'pmed_marca' => array(
	        		'name' => 'Marca',
	        		'tipo' => 'text',
	        		'lenght' => 1,
	        		'null' => TRUE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'textarea'
	        	)
	        )
        );
    }
    
    function prepararForm(){
		$forms = array();
	    $formularios = $this->get_value('type_mstr',array('idtype_mstr', 'type_name'),array('type_status' => 1));
	    $forms[''] = 'Seleccione un Tipo';
		foreach($formularios as $formulario){
			$forms[$formulario->idtype_mstr] = $formulario->type_name;
		}
		$this->schema['Datos']['pmed_type']['data'] = $forms;
		$this->schema['Datos']['pmed_typed']['data'] = array('' => 'Seleccione un Tipo');
    }
    
    function buscarTipos($tipo){
	    $forms = array();
	    $formularios = $this->get_value('typed_det',array('idtyped_det', 'typed_desc'),array('typed_status' => 1, 'typed_type' => $tipo));
	    $forms = "<option value=''>Seleccione un Tipo</option>\n";
		foreach($formularios as $formulario){
			$forms .= "<option value='$formulario->idtyped_det'>$formulario->typed_desc</option>\n";
		}
		return $forms;
    }
    
     function get_value($table, $campos,$where = null) {
        $this->db->select($campos);
        if($where != null)
        	$this->db->where($where);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}

/* End of file granjas_model.php */
/* Location: ./application/censos/models/granjas_model.php */