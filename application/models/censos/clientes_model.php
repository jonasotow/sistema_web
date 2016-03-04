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
class Clientes_model extends My_Model {
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
        $this->load->model('censos/modelo_generico_model');
        $this->table_name = 'cli_clientes_mstr';
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
			),
			'Eliminar' => array(
				'tipo' => 'submit',
				'label' => 'Eliminar',
				'class' => 'btn btn-primary',
				'id' => 'eliminar'
			)
        );
        $this->schema = array(
       		'Datos Clientes' => array(
       			'class' => 'ejemplo',
       			'id' => 'ejemplo',
	        	'cli_id_cliente' => array(
	        		'name' => 'Id',
	        		'tipo' => 'int',
	        		'lenght' => 11,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'hidden',
					'class' => 'form-control'
	        	),
	        	'cli_cve_cliente' => array(
	        		'name' => 'Clave MFG',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'cli_grupo' => array(
	        		'name' => 'Grupo Empresarial',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'cli_nombre' => array(
	        		'name' => 'Nombre',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'cli_direccion' => array(
	        		'name' => 'Direcci&oacute;n',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'textarea',
					'class' => 'form-control'
	        	),
	        	'cli_entidad' => array(
	        		'name' => 'Entidad',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'data' => array(
						'Noroeste' => 'Noroeste',
						'Occidente' => 'Occidente'
					),
					'class' => 'form-control'
	        	),
	        	'cli_gerente' => array(
	        		'name' => 'Gerente',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'cli_rfc' => array(
	        		'name' => 'RFC',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'cli_estado' => array(
	        		'name' => 'Estado',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'cli_municipio' => array(
	        		'name' => 'Municipio',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	),
	        	'cli_cp' => array(
	        		'name' => 'CP',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'text',
					'class' => 'form-control'
	        	),
	        	'cli_tipo_cliente' => array(
	        		'name' => 'Tipo Cliente',
	        		'tipo' => 'varchar',
	        		'lenght' => 30,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown',
					'class' => 'form-control'
	        	)
        	)
        );
    }
    
     function prepararForm(){
	    $forms = array();
	    $formularios = $this->modelo_generico_model->get_estados();
	    $forms[''] = 'Seleccione un Estado';
		foreach($formularios as $formulario){
			$forms[$formulario->id] = $formulario->estado;
		}
		$this->schema['Datos Clientes']['cli_estado']['data'] = $forms;
		$forms = array();
		$forms[''] = 'Seleccione un Estado';
		$this->schema['Datos Clientes']['cli_municipio']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get('grupo_empresarial','',array('active' => 1));
	    $forms[0] = 'Seleccione un Grupo';
		foreach($formularios as $formulario){
			$forms[$formulario->id] = $formulario->nombre;
		}
		$this->schema['Datos Clientes']['cli_grupo']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get('gerente','',array('active' => 1));
	    $forms[0] = 'Seleccione un Gerente';
		foreach($formularios as $formulario){
			$forms[$formulario->id] = $formulario->nombre;
		}
		$this->schema['Datos Clientes']['cli_gerente']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get('tipo_clientes','',array('tipo_status' => 1));
	    $forms[0] = 'Seleccione un Tipo';
		foreach($formularios as $formulario){
			$forms[$formulario->idtipo_clientes] = $formulario->tipo_tipo;
		}
		$this->schema['Datos Clientes']['cli_tipo_cliente']['data'] = $forms;
    }
    
    function prepararFormEspecie($especie){
	    
    }
    
    function Municipios($entidad){
	    $forms = array();
	    $formularios = $this->modelo_generico_model->get_municipios($entidad);
		foreach($formularios as $formulario){
			$forms[$formulario->cve_mun] = $formulario->nom_mun;
		}
		$this->schema['Datos Clientes']['cli_municipio']['data'] = $forms;
    }
    
    function prepararMunicipios($entidad){
	    $forms = array();
	    $formularios = $this->modelo_generico_model->get_municipios($entidad);
		foreach($formularios as $formulario){
			$forms[$formulario->cve_mun] = $formulario->nom_mun;
		}
		return $forms;
    }
}

/* End of file granjas_model.php */
/* Location: ./application/censos/models/granjas_model.php */