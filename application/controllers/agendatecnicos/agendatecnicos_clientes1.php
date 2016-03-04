<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

class Agendatecnicos_Clientes1 extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbCensos = $this->load->database('censos', TRUE);
        $this->load->model('censos/clientes_model','oCliente');
         $this->load->model('censos/granjas_model','oGranjas');
         $this->load->model('censos/contactos_model','oContacto');
         $this->load->model('censos/periodos_model','oPeriodo');
        $this->template['titulo'] = "Clientes Existentes";
        $this->load->model('censos/modelo_generico_model');
        $this->template['module'] = 'agenda';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Direccion", "Estado"),
            'open' => "<table class='table table-striped table-hover table-condensed'>"
        );
    }
    
    public function crear() {
	    try{
		    $this->oCliente->prepararForm();
		    $id = $this->uri->segment(3);
		    $this->template['titulo'] = !is_numeric($id) ? "Cliente Nuevo" : "Modificar Cliente";
			$this->form_validation->set_rules('cli_cve_cliente','Id Cliente','trim|required|is_unique[cli_clientes_mstr.cli_cve_cliente]');
		   	$this->form_validation->set_rules('cli_nombre','Nombre','trim|required');
		   	$datos = '';
		   	if(is_numeric($id))
		   		$datos = $this->oCliente->find('list',array('conditions' => array( 'cli_id_cliente' => $id )));
	   		$this->template['formulario'] = $this->_getForm(
	   				'clientes/crear'.'/'.$id,
	   				$this->oCliente->schema,
	   				$datos,
	   				"Datos Clientes",
	   				'form-inline',
	   				'form-inline',
	   				FALSE,
	   				$this->oCliente->schema_up);
			if($this->form_validation->run()){
				$datos = elements($this->oCliente->schema(),$this->input->post(NULL, TRUE));
				if($this->input->post('eliminar',TRUE) != NULL)
					$datos['form_estatus'] = 0;
				$this->template['formulario'] = $this->_getForm(
	   				'clientes/crear'.'/'.$id,
	   				$this->oCliente->schema,
	   				$datos,
	   				"Datos Clientes",
	   				'form-inline',
	   				'form-inline',
	   				FALSE);
				$this->oCliente->save($datos);
			}
		} catch(Excepcion $e){
			$this->template['mensajes'] = $e->__toString();
		}		
		if($this->input->post('eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
	    $this->template['titulo'] = "Clientes Existentes";
	    $this->template['links'] = $this->pagination('campos/index', $this->modelo_generico_model->count('cli_clientes_mstr'));
        $campos = $this->oCliente->find('result', array('fields' => array('cli_id_cliente','cli_nombre','cli_direccion','cli_estado')));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('clientes1/editar', $this->param);
        $this->template['agregar'] = anchor(site_url('clientes1/crear'),'Agregar Cliente',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('clientes1/crear');
        $this->_run('tabla_ver');
    }
    
    public function buscar(){
	    $campos = $this->oCliente->find('result', array(
	    	'fields' => array('cli_id_cliente','cli_nombre','cli_direccion','cli_estado'),
	    	'like' => array('cli_nombre' => $this->input->post('buscar',TRUE)),
	    	'order' => array( 'cli_id_cliente' => 'DESC' ),
			'limit' => array( 10, $this->uri->segment(3) )
	    	));
	    $this->param = array_merge($this->param, array('datos' => $campos));
	    echo $this->generate_table('clientes/editar', $this->param);
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */