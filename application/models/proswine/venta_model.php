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
class Venta_Model extends My_Model {
    public $table_name;
    public $schema;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
        $this->table_name = 'venta_mstr';
        $this->schema_add = array(
        	'Borrar' => array(
				'tipo' => 'reset',
				'label' => 'Borrar',
				'class' => 'btn btn-default',
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
	        	'venta_fecha' => array(
	        		'name' => 'Edad en dias',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'number',
	        	),
	        	'venta_tipo' => array(
	        		'name' => 'Peso esperado',
	        		'tipo' => 'dec',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
	        		'data' => array( '' ),
					'type'    => 'dropdown',
                    'data'    => array(
						''                      => 'Seleccione un Tipo',
						'Cerdo de primera'      => 'Cerdo de primera',
						'Cerdo de segunda'      => 'Cerdo de segunda',
						'Cerdo de desecho'      => 'Cerdo de desecho',
						'Canal'                 => 'Canal',
						'Semental de desecho'   => 'Semental de desecho',
						'Hembra de desecho'     => 'Hembra de desecho',
						'Lechon'                => 'Lechon',
						'Hembra de reemplazo'   => 'Hembra de reemplazo',
						'Semental de reemplazo' => 'Semental de reemplazo',
						'Otro'                  => 'Otro'
    				)
	        	),
	        	'venta_animales_vendidos' => array(
	        		'name' => 'Animales vendidos',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'venta_group' => array(
	        		'name' => 'Grupo',
	        		'tipo' => 'dec',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'venta_kilos_vendidos' => array(
	        		'name' => 'Kilos vendidos',
	        		'tipo' => 'dec',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'venta_peso_promedio' => array(
	        		'name' => 'Peso promedio',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'venta_edad_total' => array(
	        		'name' => 'Edad total/partos total',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'venta_partos_promedio' => array(
	        		'name' => 'Edad/partos promedio',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'venta_monto' => array(
	        		'name' => 'Monto venta',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'venta_peso_x_kg' => array(
	        		'name' => 'Peso x kg',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	)
	        )
        );
    }
/*    
    function prepararForm(){
		$forms = array();
	    $formularios = $this->get_value('granjas_mstr', 'idgranjas_mstr', 'granjas_desc');
	    $forms[''] = 'Seleccione una Granja';
		foreach($formularios as $formulario){
			$forms[$formulario->idgranjas_mstr] = $formulario->granjas_desc;
		}
		$this->schema['group_id_granja']['data'] = $forms;
    }
*/    
    function get_value($table, $campo1, $campo2) {
        $this->db->select($campo1 . ',' . $campo2);
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