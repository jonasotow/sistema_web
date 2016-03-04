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
class entrada_salida_model extends My_Model {
    public $table_name;
    public $schema;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
        $this->table_name = 'ent_sal_mstr';
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
	        	'ent_sal_group' => array(
	        		'name' => 'Grupo',
	        		'tipo' => 'int',
	        		'lenght' => 11,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'text',
	        	),
	        	'ent_sal_fecha_inicial' => array(
	        		'name' => 'Fecha final',
	        		'tipo' => 'int',
	        		'lenght' => 11,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'date',
	        	),
	        	'ent_sal_fecha_final' => array(
	        		'name' => 'Fecha final',
	        		'tipo' => 'int',
	        		'lenght' => 11,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'date',
	        	),
	        	'ent_sal_tipo' => array(
	        		'name' => 'Tipo',
	        		'tipo' => 'int',
	        		'lenght' => 100,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type'    => 'dropdown',
                    'data'    => array(
						''               => 'Seleccione un tipo',
						'Preiniciadores' => 'Preiniciadores',
						'Engorda'        => 'Engorda',
						'Reproductores'  => 'Reproductores',
    				)
	        	),
	        	'ent_sal_etapa' => array(
	        		'name' => 'Etapa',
	        		'tipo' => 'dec',
	        		'lenght' => 11,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
	        		'data' => array( '' ),
					'type'    => 'dropdown',
                    'data'    => array(
						''                      => 'Seleccione un etapa',
						'Stress Figther'        => 'Stress Figther',
						'Vital Premiere Fase 0' => 'Vital Premiere Fase 0',
						'Vital Premiere Fase 1' => 'Vital Premiere Fase 1',
						'Vital Premiere Fase 2' => 'Vital Premiere Fase 2',
						'Vital Premiere Fase 3' => 'Vital Premiere Fase 3',
						'Iniciador'             => 'Iniciador',
						'Crecimiento'           => 'Crecimiento',
						'Desarrollo'            => 'Desarrollo',
						'Engorda'               => 'Engorda',
						'Finalizador'           => 'Finalizador',
						'Gestación'             => 'Gestación',
						'Lactancia Adultas'     => 'Lactancia Adultas',
						'Lactancia Primerizas'  => 'Lactancia Primerizas',
						'Reemplazo 1'           => 'Reemplazo 1',
						'Reemplazo 2'           => 'Reemplazo 2',
						'Strong Male'           => 'Strong Male',
    				)
	        	),
	        	'ent_sal_inventario_inicial' => array(
	        		'name' => 'Inventario Inicial',
	        		'tipo' => 'dec',
	        		'lenght' => 100,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'ent_sal_entrada_registrada' => array(
	        		'name' => 'Entrada Registrada',
	        		'tipo' => 'dec',
	        		'lenght' => 100,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'ent_sal_salida_registrada' => array(
	        		'name' => 'Salida Registrada',
	        		'tipo' => 'int',
	        		'lenght' => 100,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'ent_sal_inventario_final_real' => array(
	        		'name' => 'Inventario final real',
	        		'tipo' => 'int',
	        		'lenght' => 100,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'ent_sal_consumo_dia' => array(
	        		'name' => 'Consumo x dia',
	        		'tipo' => 'int',
	        		'lenght' => 100,
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
  
    function get_value($table, $campo1, $campo2) {
        $this->db->select($campo1 . ',' . $campo2);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
*/      
}

/* End of file granjas_model.php */
/* Location: ./application/censos/models/granjas_model.php */