<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Productos_detalles_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Author Alfredo Garcia
 * @link http://localhost/sistema_web/pedidos.php/
 */
class Productos_detalles_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct($db = null) {
        // llamma el Modelo constructor
        parent::__construct($db);
        $this->load->model('pedidos/modelo_generico_model');
        $this->table_name = 'profie_productos_fields_det';
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
            'Datos Productos detalles' => array(
                'class' => 'ejemplo',
                'id' => 'ejemplo',
            	'profie_id_fields' => array(
            		'name' => 'Id',
            		'tipo' => 'int',
            		'lenght' => 11,
            		'null' => FALSE,
            		'primary' => TRUE,
            		'update' => FALSE,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	),

            	'profie_id_producto' => array(
            		'name' => 'Id_producto',
            		'tipo' => 'int',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'profie_nombre' => array(
            		'name' => 'Nombre',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'profie_formato' => array(
            		'name' => 'Formato',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'profie_posibles' => array(
            		'name' => 'Posibles',
            		'tipo' => 'varchar',
            		'lenght' => 30,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'textarea',
                    'class' => 'form-control'
            	),

            	'profie_obligatorio' => array(
            		'name' => 'Obligatorio',
            		'tipo' => 'boolean',
            		'lenght' => 1,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'text',
                    'class' => 'form-control'
            	),

            	'pla_estatus' => array(
            		'name' => 'Estatus',
            		'tipo' => 'boolean',
            		'lenght' => 1,
            		'null' => FALSE,
            		'primary' => FALSE,
            		'update' => TRUE,
    				'type' => 'hidden',
                    'class' => 'form-control'
            	)
            )    
        );
    }
/* 
    function prepararForm(){
	    $forms = array();
	    $formularios = $this->modelo_generico_model->get_estados();
	    $forms[''] = 'Seleccione un Estado';
		foreach($formularios as $formulario){
			$forms[$formulario->est_estado] = $formulario->est_estado;
		}
		$this->schema['pla_estado']['data'] = $forms;
		$forms = array();
	    $formularios = $this->modelo_generico_model->get_valor_tabla_generica('esp_especie');
	    $forms[''] = 'Seleccione una Especie';
		foreach($formularios as $formulario){
			$forms[$formulario->tblgval_valor] = $formulario->tblgval_valor;
		}
		$this->schema['pla_especie']['data'] = $forms;
    }
*/

     public function delete_t($id) {
        $this->dbUse->trans_begin();
        $this->dbUse->update('profie_productos_fields_det', array('profie_estatus' => 0 ), array('profie_id_fields' => $id));
        if ($this->dbUse->trans_status() === FALSE) {
            $this->dbUse->trans_rollback();
            return false;
        }
        $this->dbUse->trans_commit();
        return true;
    }
    
    /**
     * Muestra la consulta de cuantas granjas existente tiene la tabla gran_granjas_mstr 
     * @param  int $id_formulario Recibe el id del formulario para hacer la caonsulta y saber que formulario va a arrojar  
     * @return array $query       Regresa el formulario que estan pidiendo por medio de de su id 
     */
    function show($id_producto) {
	    $this->schema = null;
        $query = $this->find('array',array('conditions' => array('profie_estatus' => 1, 'profie_id_producto' => $id_producto), 'order' => array('profie_posicion' => 'ASC')));
        $schema = array();
        $values = array();
		$schema['class'] = 'ejemplo';
		$schema['id'] = 'ejemplo';
		$i = 0;
      	foreach ($query as $prod_det) {
	      	$data = array();
	      	$schema[$prod_det->profie_nombre] = array(
        					'name' => $prod_det->profie_label,
        					'data-campo' => $prod_det->profie_id_fields,
        					'tipo' => 'text',
        					'lenght' => 40,
        					'null' => $prod_det->profie_obligatorio == 1 ? FALSE : TRUE,
        					'primary' => FALSE,
        					'update' => TRUE,
							'type' => $prod_det->profie_formato,
							'visible' => $i !== 0 ? 'none' : null,
							'js' => $i < count($query) - 1 ? 'onchange="buscarAtributo('.$id_producto.",'".$query[0]->profie_nombre."','".$prod_det->profie_nombre."','".$query[$i + 1]->profie_nombre."'".')"' : ''
        			);
            $i++;
        	if($prod_det->profie_posibles !== '' && $prod_det->profie_formato != 'radio' && $prod_det->profie_formato != 'checkbox')
        		$data[''] = 'Seleccione un valor';
        	if(strpos($prod_det->profie_posibles,"rel[") !== false){
	        	$tabla = substr($prod_det->profie_posibles,strpos($prod_det->profie_posibles,"[") + 1,strpos($prod_det->profie_posibles,".") - strpos($prod_det->profie_posibles,"[") - 1);
	        	$campo = substr($prod_det->profie_posibles,strpos($prod_det->profie_posibles,".") + 1,strpos($prod_det->profie_posibles,"]") - strpos($prod_det->profie_posibles,".") - 1);
	        	$where = array('profiedet_producto_id' => $id_producto);
	        	$rows = $this->get($tabla,$campo,$where);
	        	foreach($rows as $row){
					$data[$row->{$campo}] = $row->{$campo};
				}
        	}
        	else{
	        	foreach(explode( "\n" , $prod_det->profie_posibles) as $lista){
		        	$data[$lista] = $lista;
	        	}
        	}
        	if(!empty($data))
        		$schema[$prod_det->profie_nombre]['data'] = $data;
      	}
      	$this->schema['Datos'] = $schema;
      	return $schema;
    }
    
    function get($tabla,$campos = null,$where = null){
		if (!is_null($campos))
			$this->dbUse->select($campos);	
		if (!is_null($where))
			$this->dbUse->where($where);
		$this->dbUse->distinct();
		$query = $this->dbUse->get($tabla);
		return $query->result();
	}
	
	function get_array($tabla,$campos = null,$where = null){
		if (!is_null($campos))
			$this->dbUse->select($campos);	
		if (!is_null($where))
			$this->dbUse->where($where);
		$this->dbUse->distinct();
		$query = $this->dbUse->get($tabla);
		return $query->result_array();
	}
	
	public function _getFormProductos($action,$schema,$datos = NULL,$nombre = NULL,$class = NULL, $id = NULL, $read = FALSE, $botones = NULL, $upload = NULL){
   		$update = is_array($datos) == TRUE ? TRUE : FALSE;
   		$formulario = "";
	   	foreach($schema as $fieldset => $fields){
		   	foreach($fields as $field => $data){
			   	if(is_array($data)){
				   	$required = "";
			   	   	if($update){
					   	if(!$data['update'] OR $read)
							$required = $data['type'] != 'dropdown' ? 'readonly' : 'disabled';
					}
				   	else
				   		$required = $data['null'] == FALSE ? 'required' : '';
				   	$required .= empty($data['data-campo']) == FALSE ? ' data-campo='.$data['data-campo'] : '';
				   	$required .= empty($data['data-id']) == FALSE ? ' data-id='.$data['data-id'] : '';
				   	$required .= empty($data['js']) == FALSE ? ' '.$data['js'] : '';
				   	$required .= empty($data['visible']) == FALSE && $data['type'] != 'checkbox' ? $data['visible'] != null ? ' style="display: '.$data['visible'].';"' : '' : '';
				   	$input = array(
				   		'type'		=> $data['type'],
				   		'name'		=> $field,
				   		'id'		=> $field,
				   		'value'		=> $datos !== NULL ? element($field,$datos,NULL) : set_value($field),
				   		'maxlength'	=> $data['lenght'],
				   		'size'		=> $data['lenght'],
				   		'class'		=> 'form-control'
		            );
		            $estilo = empty($data['visible']) == FALSE && $data['visible'] != null && $data['type'] != 'checkbox' ? array('style' => 'display: none','class' => 'estilo_pedidos') : array('class' => 'estilo_pedidos');
		            $div = $data['type'] == 'checkbox' ? 'style=display:none; id='.'check'.$field .' ' : '';
		            $formulario .= "<div class='form-group' ".$div.">";
				   	$formulario .= $data['type'] != 'hidden' ? form_label($data['name'].":",$field,$estilo)."\n" : '';
				   	switch($data['type']){
					   	case 'dropdown':
							$formulario .= form_dropdown($field,$data['data'],$datos !== NULL ? element($field,$datos,'') : '', 'class="form-control"'.$required." id=".$field)."\n";
							break;
						case 'checkbox':
							if (empty($data['data'])){
								$formulario .= '<label>'.$field."\n";
								$formulario .= form_checkbox($field.'[]',1,FALSE,$required)."\n";
								$formulario .= '</label>'."\n";
							}
		 					else{
		 						foreach($data['data'] as $campo){
			 						$campo = trim($campo);
			 						$checked = $datos !== NULL ? in_array($campo,explode("\n",element($field,$datos,''))) !== FALSE ? TRUE : FALSE : FALSE;
			 						$formulario .= '<label class="estilo_pedidos">'.$campo.'&nbsp';
			 						if($campo !== 'Otros'){
		 								$formulario .= form_checkbox($field.'[]',$campo,$checked,$required)."\n";
		 								$formulario .= '</label>';
	 								}
		 							else{
			 							$otros = array(
								              'name'        => 'otros',
								              'id'          => 'otros',
								              'value'       => '',
								              'maxlength'   => '100',
								              'size'        => '50',
								              'class'		=> 'form-control'
								            );
		 								$formulario .= form_input($otros).'</label>';
	 								}
		 						}
		 					}
							break;
						case 'radio':
							if (empty($data['data'])){
								$formulario .= '<label>'.$field."\n";
								$formulario .= form_radio($field,1,FALSE,$required)."\n";
								$formulario .= '</label>'."\n";
							}
		 					else{
		 						foreach($data['data'] as $campo){
			 						$checked = $datos !== NULL ? element($field,$datos,'') == $campo ? TRUE : FALSE : FALSE;
			 						$formulario .= '<br /><label>'.$campo;
		 							$formulario .= form_radio($field,$campo,$checked,$required)."\n";
		 							$formulario .= '</label>';
		 						}
		 					}
							break;
						case 'file':
							$formulario .= form_upload($input,'',$required)."\n";
							break;
						case 'password':
							$formulario .= form_password($input,'',$required)."\n";
							break;
						case 'hidden':
							$formulario .= form_hidden($field,$datos !== NULL ? element($field,$datos,NULL) : $data['value'])."\n";
							break;
						case 'textarea':
							$input = array(
							   		'type'		=> $data['type'],
							   		'name'		=> $field,
							   		'id'		=> $field,
							   		'value'		=> $datos !== NULL ? element($field,$datos,NULL) : set_value($field),
							   		'rows'		=>  4,
							   		'cols'		=> $data['lenght'],
							   		'class'		=> 'form-control'
					            );
							$formulario .= form_textarea($input,'',$required)."\n";
							break;
						default:
							$formulario .= form_input($input,'',$required)."\n";
							break;
				   	}
				   	$formulario .= "</div><br />\n";
			   	}
		   	}
	   	}
	   	return $formulario;
   	}
}
/* End of file productos_detalles_model.php */
/* Location: ./application/models/pedidos/productos_detalles_model.php */