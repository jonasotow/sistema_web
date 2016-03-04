<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

class Agendatecnicos_Granjas1 extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('censos', TRUE);
        $this->load->model('censos/granjas_model');
        $this->load->model('censos/modelo_generico_model');
        $this->template['module'] = 'agenda';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Gerente", "Direccion", "Estado"),
             'open' => "<table class='table table-striped table-hover table-condensed'>"
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->granjas_model->find('result', array('fields' => array('gran_id_granja','gran_nombre','gran_gerente_atiende','gran_direccion','gran_estado'),'conditions' => array('gran_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('granjas1/crear', $this->param);
        $this->template['agregar'] = anchor(site_url('granjas1/crear'),'Agregar Granja',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('granjas1/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
     	try{
		    $this->granjas_model->prepararForm();
		    $id = $this->uri->segment(3);
		    $this->template['titulo'] = !is_numeric($id) ? "Granja Nueva" : "Modificar Granja";
		    if(!is_numeric($id))
				$this->form_validation->set_rules('gran_nombre','Granja Nombre','trim|required');
		   	$this->form_validation->set_rules('gran_gerente_atiende','Gerente','trim|required');
		   	$datos = '';
		   	if(is_numeric($id))
			   $datos = $this->granjas_model->find('list',array('conditions' => array( 'gran_id_granja' => $id )));
		   	$this->template['formulario'] = $this->_getForm(
		   			'granjas/crear'.'/'.$id,
		   			$this->granjas_model->schema,
		   			$datos,
		   			"Datos Granjas",
	   				'form-inline',
	   				'form-inline',
	   				FALSE,
	   				$this->granjas_model->schema_up
		   		);
			if($this->form_validation->run()){
				$datos = elements($this->granjas_model->schema(),$this->input->post(NULL, TRUE));
				if($this->input->post('eliminar',TRUE) != NULL)
					$datos['form_estatus'] = 0;
				$this->granjas_model->save($datos);
		   		$this->template['formulario'] = $this->_getForm('campos/crear'.'/'.$id,$this->granjas_model->schema,$this->granjas_model->find('list',array('conditions' => array( 'gran_id_granja' => $id ))));
			}
		} catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }     	
		if($this->input->post('eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }
    
    public function agregarGranja() {
	    $links = array(
            anchor(site_url('clientes/crear'.'/'.$this->uri->segment(3)),'Ver Cliente'), 
            anchor(site_url('clientes/crear'.'/'.$this->uri->segment(3)),'Modificar Cliente'),
            anchor(site_url('contactos/agregarContacto'.'/'.$this->uri->segment(3)),'Agregar Contacto'),
            anchor(site_url('granjas/agregarGranja'.'/'.$this->uri->segment(3)),'Agregar Granja'),
            anchor(site_url('periodos/agregarCenso'.'/'.$this->uri->segment(3)),'Agregar Censo')
            );

	    $this->template['agregar'] = ul($links);
	    
	    $this->granjas_model->prepararForm();
	    $id = $this->uri->segment(3);
	    $this->template['titulo'] = !is_numeric($id) ? "Granja Nueva" : "Modificar Granja";
	    if(!is_numeric($id))
			$this->form_validation->set_rules('gran_nombre','Granja Nombre','trim|required');
	   	$this->form_validation->set_rules('gran_gerente_atiende','Gerente','trim|required');
	   	$datos = '';
	   	if(is_numeric($id)){
	   		$datos = $this->granjas_model->find('list',array('conditions' => array( 'gran_id_granja' => $id )));
	   		$datos = elements($datos,'gran_id_cliente');
   		}
	   	$this->template['formulario'] = $this->_getForm('granjas/agregarGranja'.'/'.$id,$this->granjas_model->schema,$datos);
		if($this->form_validation->run()){
			$datos = elements($this->granjas_model->schema(),$this->input->post(NULL, TRUE));
			if($this->input->post('eliminar',TRUE) != NULL)
				$datos['form_estatus'] = 0;
			$this->granjas_model->save($datos);
	   		$this->template['formulario'] = $this->_getForm('campos/agregarGranja'.'/'.$id,$this->granjas_model->schema,$this->granjas_model->find('list',array('conditions' => array( 'gran_id_granja' => $id ))));
	   		redirect(site_url('clientes/crear/'.$id));
		}
		if($this->input->post('eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */