<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

class Proswine_Periodo_Mon extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('porcicultura',TRUE);
        $this->load->helper('date');
        $this->template['module'] = 'local';
        $this->template['titulo'] = 'titulo';
        $this->param = array(
            'cabecera' => array("Id", "Granja", "A&ntilde;o"),
            'open' => "<table class='table table-striped table-hover table-condensed'>"
        );
        $this->load->model('proswine/engordas_model');
    }
 
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->engordas_model->find('result', 
        	array('fields' => array('idengordas_mstr','granjas_mfg_addr','engordas_periodo'),
        		'conditions' => array('engordas_status' => 1),
        		'join' => array(
					'clause' => array('granjas_mstr' => 'granjas_mstr.idgranjas_mstr = engordas_mstr.idgranjas_mstr'),
					'type' => 'INNER'
				)
        	));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('periodo_mon/crear', $this->param);
        $this->template['agregar'] = anchor(site_url('periodo_mon/crear'),'Agregar',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('periodo_mon/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
	    $id = $this->uri->segment(3);
	    $this->engordas_model->prepararForm();
	    $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
		$this->form_validation->set_rules('engordas_periodo','Periodo','trim|required');
	   	$datos = '';
	   	if(is_numeric($id))
	   		$datos = $this->engordas_model->find('list',array('conditions' => array( 'idengordas_mstr' => $id )));
	   	$this->template['formulario'] = $this->_getForm('periodo_mon/crear'.'/'.$id,$this->engordas_model->schema,$datos);
		if($this->form_validation->run()){
			$datos = elements($this->engordas_model->schema(),$this->input->post(NULL, TRUE));
			$datos['engordas_status'] = 1;
			if($this->input->post('eliminar',TRUE) != NULL)
				$datos['engordas_status'] = 0;
			$this->engordas_model->save($datos);
	   		$this->template['formulario'] = $this->_getForm('periodo_mon/crear'.'/'.$id,$this->engordas_model->schema,$this->engordas_model->find('list',array('conditions' => array( 'idengordas_mstr' => $id ))));
		}
		if($this->input->post('eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */