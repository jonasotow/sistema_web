<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  Periodos Class
 *
 *  @category:  Controlador
 *  @author:    José Manzo
 */
class Censos_Periodos extends MY_Controller {
    
    var $param;

    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('censos', TRUE);
        $this->load->library('table');
        $this->load->model('censos/periodos_model');
        $this->load->model('censos/censos_model','oEspecie');
        $this->template['module'] = 'censos';
        $this->template['titulo'] = "censos";
        $this->param = array(
            'cabecera' => array("Id","Granja","Tipo","Año","Fecha registro")
        );
    }

    /**
     * Muestra lista de periodos
     * 
     * @access public
     */
    public function index() {
        $campos = $this->periodos_model->find('result',array( 
				'fields' => array('per_id_periodo','gran_nombre','especies_desc','per_anio','per_fecha_registro'),
				'join' => array(
					'clause' => array(
						'gran_granjas_mstr' => 'gran_id_granja = per_id_granja',
						 'especies_tipos' => 'idespecies_tipos = per_id_especie'
						),
					'type' => 'INNER'
				),
				'order' => array( 'per_id_periodo' => 'DESC' ),
				'limit' => array( 10, $this->uri->segment(3) )
				));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('periodos/crear', $this->param);
        $this->template['agregar'] = anchor(site_url('periodos/crear'),' ',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('periodos/crear');
        $this->_run('tabla_ver');
    }
    
    public function crear() {
    	try{
		    $this->periodos_model->prepararForm($this->uri->segment(3));
		    $id = $this->uri->segment(3);
		    $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
			$this->form_validation->set_rules('per_anio','A&ntilde;o','trim|required');
		   	$this->form_validation->set_rules('per_id_especies','Tipo','trim|required');
		   	$datos = '';
		   	if(is_numeric($id)){

		        $this->template['agregar_contacto'] = '<a class="navbar-brand" href="'.site_url('contactos/agregarContacto'.'/'.$this->uri->segment(3).'/'.$datos['cli_tipo_cliente']).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Contacto</span></a>';
		        $this->template['agregar_granja'] = '<a class="navbar-brand" href="'.site_url('granjas/agregarGranja'.'/'.$this->uri->segment(3).'/'.$datos['cli_tipo_cliente']).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Granja</span></a>';
		        $this->template['agregar_censo'] = '<a class="navbar-brand" href="'.site_url('periodos/agregarCenso'.'/'.$this->uri->segment(3).'/'.$datos['cli_tipo_cliente']).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Censo</span></a>';

		
		   		$datos = $this->periodos_model->find('list',array('conditions' => array( 'per_id_periodo' => $id )));
	   		}
		   	$this->template['formulario'] = $this->_getForm('periodos/crear'.'/'.$id,$this->periodos_model->schema,$datos);
			if($this->form_validation->run()){
				$datos = elements($this->periodos_model->schema(),$this->input->post(NULL, TRUE));
				$this->periodos_model->save($datos);
		   			$this->template['formulario'] = $this->_getForm(
   				'periodos/agregarCenso'.'/'.$id,
   				$this->periodos_model->schema,
   				$datos,
   				"Datos Censos",
   				'form-inline',
   				'form_enviar',
   				FALSE,
   				$this->periodos_model->schema_add);
			}
		} catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }     	
			if($this->input->post('eliminar',TRUE) != NULL)
				$this->index();
			else
				$this->_run('crud');
    }
    
    public function agregarCenso() {

        $this->template['agregar_contacto'] = '<a class="navbar-brand" href="'.site_url('contactos/agregarContacto'.'/'.$this->uri->segment(3).'/'.$this->uri->segment(4)).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Contacto</span></a>';
        $this->template['agregar_granja'] = '<a class="navbar-brand" href="'.site_url('granjas/agregarGranja'.'/'.$this->uri->segment(3).'/'.$this->uri->segment(4)).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Granja</span></a>';
        $this->template['agregar_censo'] = '<a class="navbar-brand" href="'.site_url('periodos/agregarCenso'.'/'.$this->uri->segment(3).'/'.$this->uri->segment(4)).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Censo</span></a>';
	    
	    $this->periodos_model->prepararForm($this->uri->segment(3),$this->uri->segment(4));
	    $id = $this->uri->segment(3);
	    $tipo = $this->uri->segment(4);
	    $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
		$this->form_validation->set_rules('per_anio','A&ntilde;o','trim|required');
	   	$this->form_validation->set_rules('per_id_especie','Tipo','trim|required');
	   	$datos = '';
	   	if(is_numeric($id)){
	   		$datos = $this->periodos_model->find('list',array('fields' => array('per_id_periodo','per_id_especie','per_anio','per_id_granja'), 'conditions' => array( 'per_id_periodo' => $id )));
	   		$datos['per_id_periodo'] = '';
	   		$datos['per_id_especie'] = '';
	   		$datos['per_anio'] = '';
   		}
	   	$this->template['formulario'] = $this->_getForm(
   				'periodos/agregarCenso'.'/'.$id,
   				$this->periodos_model->schema,
   				$datos,
   				"Datos Censos",
   				'form-inline',
   				'form_enviar',
   				FALSE,
   				$this->periodos_model->schema_add);
		if($this->form_validation->run()){
			$datos = elements($this->periodos_model->schema(),$this->input->post(NULL, TRUE));
			try{
				$this->periodos_model->save($datos);
			}catch(Excepcion $e){}
	   			$this->template['formulario'] = $this->_getForm(
   				'periodos/agregarCenso'.'/'.$id,
   				$this->periodos_model->schema,
   				$datos,
   				"Datos Censos",
   				'form-inline',
   				'form_enviar',
   				FALSE,
   				$this->periodos_model->schema_add);
	   		redirect(site_url('clientes/crear/'.$id));
		}
		if($this->input->post('eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }
    
    public function getFormularioEspecie(){
	    $this->oEspecie->show_especieTipo($this->input->post('especie',TRUE));
   		echo $this->template['formulario_especie'] = $this->_getForm(
				'clientes/crear',
				$this->oEspecie->schema,
				$this->oEspecie->values,
				"Datos Especie",
				'form-inline',
				'especies',
				FALSE);
    }
}

/* End of file periodos.php */
/* Location: ./application/censos/controllers/periodos.php */