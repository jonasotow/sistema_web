<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');
/**
* Super Class
*
* @package None
* @subpackage None
* @category Model
* @author Author Alfredo Garcia
* @link http://localhost/sistema_web/censos.php/
*/
class Censos_model extends My_Model {
	public $table_name;
    public $schema;
    public $values;
    public $schema_add;
    public $schema_up;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {

        // Activa todo las funciones del modelo CI_Model
        parent::__construct();
        $this->load->model('censos/modelo_generico_model','oModel');
        $this->table_name = 'cam_campos_det';
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
    }

    /**
     * Muestra la consulta de cuantas granjas existente tiene la tabla gran_granjas_mstr 
     * @param  int $id_formulario Recibe el id del formulario para hacer la caonsulta y saber que formulario va a arrojar  
     * @return array $query       Regresa el formulario que estan pidiendo por medio de de su id 
     */
    function show_censo($id_periodo) {
        $query = $this->find('array',array(
        	'join' => array(
					'clause' => array('especies_tipos' => 'especies_id_formulario = cam_id_formulario', 'per_periodos_mstr' => 'per_id_especie = idespecies_tipos', 'val_valores_det' => 'val_id_campo = cam_id_campo AND val_id_periodo = per_id_periodo'),
					'type' => 'LEFT'
				),
        	'conditions' => array('per_id_periodo' => $id_periodo),
        	'order' => array( 'cam_posicion' => 'ASC' ))
        );
        $schema = array();
        $values = array();
		$schema['class'] = 'ejemplo';
		$schema['id'] = 'ejemplo';
      	foreach ($query as $censo) {
	      	$data = array();
	      	$schema[$censo->cam_name] = array(
        					'name' => $censo->cam_label,
        					'data-campo' => $censo->cam_id_campo,
        					'tipo' => 'text',
        					'lenght' => 40,
        					'null' => $censo->cam_required == 1 ? FALSE : TRUE,
        					'primary' => FALSE,
        					'update' => TRUE,
							'type' => $censo->cam_type,
							'data-id' => empty($censo->val_id_valor) !== TRUE ? $censo->val_id_valor : ''
        			);
        	if($censo->cam_value !== '' && $censo->cam_type != 'radio' && empty($censo->val_valor))
        		$data[''] = 'Seleccione un valor';
        	if(strpos($censo->cam_value,"rel[") !== false){
	        	$tabla = substr($censo->cam_value,strpos($censo->cam_value,"[") + 1,strpos($censo->cam_value,".") - strpos($censo->cam_value,"[") - 1);
	        	$campo = substr($censo->cam_value,strpos($censo->cam_value,".") + 1,strpos($censo->cam_value,"]") - strpos($censo->cam_value,".") - 1);
	        	$rows = $this->oModel->get($tabla,$campo);
	        	foreach($rows as $row){
					$data[$row->{$campo}] = $row->{$campo};
				}
        	}
        	else{
	        	foreach(explode( "\n" , $censo->cam_value) as $lista){
		        	$data[$lista] = $lista;
	        	}
        	}
        	if(!empty($data))
        		$schema[$censo->cam_name]['data'] = $data;
        		
        	if(!empty($censo->val_valor))
	        	$values[$censo->cam_name] = $censo->val_valor;
      	}
      	$this->schema['Datos'] = $schema;
      	$this->values = $values;
      	return $schema;
    }
    
     /**
     * Muestra la consulta de cuantas granjas existente tiene la tabla gran_granjas_mstr 
     * @param  int $id_formulario Recibe el id del formulario para hacer la caonsulta y saber que formulario va a arrojar  
     * @return array $query       Regresa el formulario que estan pidiendo por medio de de su id 
     */
    function show_especie($especie) {
        $query = $this->find('array',array(
        	'join' => array(
					'clause' => array('tipo_clientes' => 'tipo_formulario = cam_id_formulario', 'val_valores_det' => 'val_id_campo = cam_id_campo AND val_id_periodo = 0'),
					'type' => 'LEFT'
				),
        	'conditions' => array('idtipo_clientes' => $especie),
        	'order' => array( 'cam_posicion' => 'ASC' ))
        );
        $schema = array();
        $values = array();
		$schema['class'] = 'ejemplo';
		$schema['id'] = 'ejemplo';
      	foreach ($query as $censo) {
	      	$data = array();
	      	$schema[$censo->cam_name] = array(
        					'name' => $censo->cam_label,
        					'data-campo' => $censo->cam_id_campo,
        					'tipo' => 'text',
        					'lenght' => 40,
        					'null' => $censo->cam_required == 1 ? FALSE : TRUE,
        					'primary' => FALSE,
        					'update' => TRUE,
							'type' => $censo->cam_type,
							'data-id' => empty($censo->val_id_valor) !== TRUE ? $censo->val_id_valor : ''
        			);
        	if($censo->cam_value !== '' && $censo->cam_type != 'radio' && empty($censo->val_valor) && $censo->cam_type != 'checkbox')
        		$data[''] = 'Seleccione un valor';
        	if(strpos($censo->cam_value,"rel[") !== false){
	        	$tabla = substr($censo->cam_value,strpos($censo->cam_value,"[") + 1,strpos($censo->cam_value,".") - strpos($censo->cam_value,"[") - 1);
	        	$campo = substr($censo->cam_value,strpos($censo->cam_value,".") + 1,strpos($censo->cam_value,"]") - strpos($censo->cam_value,".") - 1);
	        	$rows = $this->oModel->get($tabla,$campo);
	        	foreach($rows as $row){
					$data[$row->{$campo}] = $row->{$campo};
				}
        	}
        	else{
	        	foreach(explode( "\n" , $censo->cam_value) as $lista){
		        	$data[$lista] = $lista;
	        	}
        	}
        	if(!empty($data))
        		$schema[$censo->cam_name]['data'] = $data;
        		
        	if(!empty($censo->val_valor))
	        	$values[$censo->cam_name] = $censo->val_valor;
      	}
      	$this->schema['Datos'] = $schema;
      	$this->values = $values;
      	return $schema;
    }
    
    /**
     * Muestra la consulta de cuantas granjas existente tiene la tabla gran_granjas_mstr 
     * @param  int $id_formulario Recibe el id del formulario para hacer la caonsulta y saber que formulario va a arrojar  
     * @return array $query       Regresa el formulario que estan pidiendo por medio de de su id 
     */
    function show_especieTipo($especie) {
        $query = $this->find('array',array(
        	'join' => array(
					'clause' => array('especies_tipos' => 'especies_id_formulario = cam_id_formulario', 'val_valores_det' => 'val_id_campo = cam_id_campo AND val_id_periodo = 0'),
					'type' => 'LEFT'
				),
        	'conditions' => array('idespecies_tipos' => $especie),
        	'order' => array( 'cam_posicion' => 'ASC' ))
        );
        $schema = array();
        $values = array();
		$schema['class'] = 'ejemplo';
		$schema['id'] = 'ejemplo';
      	foreach ($query as $censo) {
	      	$data = array();
	      	$schema[$censo->cam_name] = array(
        					'name' => $censo->cam_label,
        					'data-campo' => $censo->cam_id_campo,
        					'tipo' => 'text',
        					'lenght' => 40,
        					'null' => $censo->cam_required == 1 ? FALSE : TRUE,
        					'primary' => FALSE,
        					'update' => TRUE,
							'type' => $censo->cam_type,
							'data-id' => empty($censo->val_id_valor) !== TRUE ? $censo->val_id_valor : ''
        			);
        	if($censo->cam_value !== '' && $censo->cam_type != 'radio' && empty($censo->val_valor) && $censo->cam_type != 'checkbox')
        		$data[''] = 'Seleccione un valor';
        	if(strpos($censo->cam_value,"rel[") !== false){
	        	$tabla = substr($censo->cam_value,strpos($censo->cam_value,"[") + 1,strpos($censo->cam_value,".") - strpos($censo->cam_value,"[") - 1);
	        	$campo = substr($censo->cam_value,strpos($censo->cam_value,".") + 1,strpos($censo->cam_value,"]") - strpos($censo->cam_value,".") - 1);
	        	$rows = $this->oModel->get($tabla,$campo);
	        	foreach($rows as $row){
					$data[$row->{$campo}] = $row->{$campo};
				}
        	}
        	else{
	        	foreach(explode( "\n" , $censo->cam_value) as $lista){
		        	$data[$lista] = $lista;
	        	}
        	}
        	if(!empty($data))
        		$schema[$censo->cam_name]['data'] = $data;
        		
        	if(!empty($censo->val_valor))
	        	$values[$censo->cam_name] = $censo->val_valor;
      	}
      	$this->schema['Datos'] = $schema;
      	$this->values = $values;
      	return $schema;
    }

    /**
     * Cuenta los registros de la consulta
     * @param   int $id_formulario Recibe el id del formulario para hacer la consulta y saber que formulario va a contar
     * @return  array $query       Regresa el numero de campos que pertenecen a ese formulario
     */
    function count_campos ($id_formulario) {
        $this->db->where('cam_id_formulario', $id_formulario);
        $this->db->from('cam_campos_det');
        $query = $this->db->count_all_results();

        if ($query > 0) return $query;
        else return false;
    }

    /**
     * inserta los valores de los formularios creados dinamicamente
     * @param  array $data trae los datos otenidos del formulario
     * @return boolean       regresa false si no se insertan los datos en la BD y true si si hizo la inserción
     */
    function insert_censo($data) {
        $this->db->trans_begin();
        $this->db->insert('val_valores_det', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    /**
     * muestra los periodos que existen
     * @return array regresa los periodos que existen
     */
    function show_periodo() {
        $query = $this->db->get_where('per_periodos_mstr');
        if ($query->num_rows() > 0) return $query->row();
        else return false;
    }
}
/* End of file censos_model.php */
/* Location: ./application/censos/models/censos_model.php */