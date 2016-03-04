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
class Group_Detalle_Model extends My_Model {
    public $table_name;
    public $schema;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
        $this->table_name = 'groupd_det';
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
//          	 'Tipo de Monitor' => array(
//          	 		'class' => 'ejemplo',
//          	 		'id' => 'ejemplo',
//          	 		'sitio' => array(
//          	 			'name' => 'Monitores',
//          	 			'tipo' => 'text',
//          	 			'lenght' => 25,
// 		        		'null' => FALSE,
// 		        		'primary' => TRUE,
// 		        		'update' => TRUE,
// 						'type' => 'dropdown',
// 						'data' => array(0 => 'Seleccione un Tipo', 1 => 'Montas', 2 => 'Engordas')
// 						)
//          	 ),
	         'Datos' => array(
	         		'class' => 'ejemplo',
	         		'id' => 'ejemplo',
	        	'idgroupd_det' => array(
	        		'name' => 'Id',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	),
	        	'groupd_id_group' => array(
	        		'name' => 'Grupo',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'number'
	        	),
	        	'groupd_inv' => array(
	        		'name' => 'Inv Inicial',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'groupd_week' => array(
	        		'name' => 'Semana',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'groupd_qty' => array(
	        		'name' => 'Cantidad',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'groupd_site' => array(
	        		'name' => 'Sitio',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'hidden',
					'data' => array('Sitio 1','Sitio 2','Sitio 3')
	        	),
	        	'groupd_type' => array(
	        		'name' => 'Tipo',
	        		'tipo' => 'boolean',
	        		'lenght' => 1,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	),
	        	'groupd_cmmt' => array(
	        		'name' => 'Observaciones',
	        		'tipo' => 'text',
	        		'lenght' => 1,
	        		'null' => TRUE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'textarea'
	        	)
	        )
        );
    }
    
    function prepararForm(){
		$forms = array();
	    $formularios = $this->get_value('granjas_mstr', 'idgranjas_mstr', 'granjas_desc');
	    $forms[''] = 'Seleccione una Granja';
		foreach($formularios as $formulario){
			$forms[$formulario->idgranjas_mstr] = $formulario->granjas_desc;
		}
		$this->schema['group_id_granja']['data'] = $forms;
    }
    
    function get_value($table, $campo1, $campo2) {
        $this->db->select($campo1 . ',' . $campo2);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function buscarTitulo($idGrupo){
	    $this->db->select('granjas_desc');
	    $this->db->where('idgranjas_mstr',$idGrupo);
	    $query = $this->db->get('granjas_mstr');
	    $row = $query->row(1);
	    return $row->granjas_desc;
    }
}

/* End of file granjas_model.php */
/* Location: ./application/censos/models/granjas_model.php */