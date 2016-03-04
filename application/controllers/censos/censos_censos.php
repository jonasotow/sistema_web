<?php if (!defined('BASEPATH')) die('No direct script access allowed');

class Censos_Censos extends MY_Controller {
	
	/**
	 * [__construct description]
	 */
	function __construct(){
		parent::__construct();	
		$dbBase = $this->load->database('censos', TRUE);
		$this->load->model('censos/censos_model');
		$this->load->model('censos/valores_model','oValor');
		$this->load->model('censos/periodos_model','oPeriodo');
		$this->load->model('censos/modelo_generico_model','oMod');
		$this->template['module'] = 'censos';
	}
	
	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function editar() {
		try{
			$this->template['periodos'] = $this->censos_model->show_periodo();
			$this->censos_model->show_censo( $this->uri->segment(3) );
			$periodo = $this->oPeriodo->find('list',array('fields' => array('per_id_periodo','per_id_especie','per_anio','per_id_granja'), 'conditions' => array( 'per_id_periodo' => $this->uri->segment(3) )));
			$oGranja = $this->oMod->get('gran_granjas_mstr','*',array('gran_id_granja' => $periodo['per_id_granja']));
			$oCliente = $this->oMod->get('cli_clientes_mstr','*',array('cli_id_cliente' => $oGranja[0]->gran_id_cliente));
			
			$links = array(
	            anchor(site_url('clientes/crear'.'/'.$oCliente[0]->cli_id_cliente),'Ver Cliente'), 
	            anchor(site_url('clientes/crear'.'/'.$oCliente[0]->cli_id_cliente),'Modificar Cliente'),
	            anchor(site_url('contactos/agregarContacto'.'/'.$oCliente[0]->cli_id_cliente),'Agregar Contacto'),
	            anchor(site_url('granjas/agregarGranja'.'/'.$oCliente[0]->cli_id_cliente),'Agregar Granja'),
	            anchor(site_url('periodos/agregarCenso'.'/'.$oCliente[0]->cli_id_cliente.'/'.$oCliente[0]->cli_tipo_cliente),'Agregar Censo')
	            );

		    $this->template['agregar'] = ul($links);
			$this->template['formulario'] = $this->_getForm(
				'censos/recibirDatosForm'.'/'.$this->uri->segment(3),
				$this->censos_model->schema,
				$this->censos_model->values,
				'Censo del Cliente',
				'horizontalform',
				'censos',
				FALSE,
				$this->censos_model->schema_up	
				);
		} catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }     			
		$this->_run('crud');
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index() {
		$this->template['periodos'] = $this->censos_model->show_periodo();
		$this->template['censos'] = $this->censos_model->show_censo( $this->uri->segment(3) );
		$this->template['num_registros'] = $this->censos_model->count_campos( $this->uri->segment(3) );
		$this->_run('censo_nueva');
	}

	/**
	 * [recibirDatos description]
	 * @return [type] [description]
	 */
	public function recibirDatos() {
		$json = json_decode($this->input->post('datos',TRUE));
		$form = json_decode($this->input->post('formulario',TRUE));
		
		$periodo = array(		
			'per_id_periodo' => '',
		   	'per_id_especie' => $form[2]->value,
		   	'per_anio' => $form[3]->value,
		   	'per_mes' => $form[4]->value,
		   	'per_id_granja' => $form[1]->value
		   );
		   
		$datos = $this->oPeriodo->find('list',array('fields' => array('per_id_periodo','per_id_especie','per_anio','per_id_granja'), 
	   		'conditions' => array( 'per_id_especie' => $periodo['per_id_especie'], 'per_anio' => $periodo['per_anio'], 'per_mes' => $periodo['per_mes'], 'per_id_granja' => $periodo['per_id_granja'] )));
	   		
	   	if(isset($datos['per_id_periodo']))
	   		echo "Ya existe un periodo con esos datos";
	   	else{		   	
		   	try{
			   	$this->oPeriodo->save($periodo);
		   	} catch(Excepcion $e){}
		   	
		   	$datos = $this->oPeriodo->find('list',array('fields' => array('per_id_periodo','per_id_especie','per_anio','per_id_granja'), 
		   		'conditions' => array( 'per_id_especie' => $periodo['per_id_especie'], 'per_anio' => $periodo['per_anio'], 'per_mes' => $periodo['per_mes'], 'per_id_granja' => $periodo['per_id_granja'] )));
	
			foreach($json as $dato){
			$field = array(
				'val_id_valor' => isset($dato->id) !== FALSE ? $dato->id : '',
				'val_id_campo' => $dato->campo,
				'val_id_periodo' => $this->uri->segment(3),
				'val_valor' => $dato->value
				);
				$fields[] = $field;			
			}
			$val = "";
			$valor = "";
			foreach($fields as $key => $value){
				if ($val === $value['val_id_campo']){
					$valor .= "\n".$value['val_valor'];
					$fields[$key]['val_valor'] = $valor;
				}
				else {
					$val = $value['val_id_campo'];
					$valor = $value['val_valor'];
				}
			}
			foreach($fields as $field){
				try{
	 				$this->oValor->save($field);
		 		} catch(Excepcion $e){}
			}
		}
	}
	
	/**
	 * [recibirDatos description]
	 * @return [type] [description]
	 */
	public function recibirDatosForm() {
		$json = json_decode($this->input->post('datos',TRUE));
		$fields = array();
		foreach($json as $dato){
			$field = array(
				'val_id_valor' => isset($dato->id) !== FALSE ? $dato->id : '',
				'val_id_campo' => $dato->campo,
				'val_id_periodo' => $this->uri->segment(3),
				'val_valor' => $dato->value
			);
			$fields[] = $field;			
		}
		$val = "";
		$valor = "";
		foreach($fields as $key => $value){
			if ($val === $value['val_id_campo']){
				$valor .= "\n".$value['val_valor'];
				$fields[$key]['val_valor'] = $valor;
			}
			else {
				$val = $value['val_id_campo'];
				$valor = $value['val_valor'];
			}
		}
		foreach($fields as $field){
			try{
 				$this->oValor->save($field);
	 		} catch(Excepcion $e){}
		}
	}
}
/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */