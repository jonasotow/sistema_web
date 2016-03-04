<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

class Proswine_Granjas_Mon extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('porcicultura',TRUE);
        $this->template['module'] = 'local';
         $this->template['titulo'] = 'local';
        $this->param = array(
            'cabecera' => array("Id", "Cliente", "Descripcion", "Direccion", "Telefono"),
            'open' => "<table class='table table-striped table-hover table-condensed'>"
        ); 
        $this->load->model('proswine/granjas_mon_model');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
	    $campos = $this->granjas_mon_model->find('result', array('fields' => array('idgranjas_mstr','granjas_desc','granjas_mfg_addr','granjas_dir','granjas_tel'),'conditions' => array('granjas_status' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('periodo_mon/crear', $this->param);
        $this->template['agregar'] = anchor(site_url('granjas_mon/crear'),'Agregar',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('granjas_mon/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
	    $id = $this->uri->segment(3);
	    $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
		$this->form_validation->set_rules('granjas_mfg_addr','Granja Cliente','trim|required');
	   	$this->form_validation->set_rules('granjas_desc','Nombre','trim|required');
	   	$datos = '';
	   	if(is_numeric($id))
	   		$datos = $this->granjas_mon_model->find('list',array('conditions' => array( 'idgranjas_mstr' => $id )));
	   	$this->template['formulario'] = $this->_getForm('granjas_mon/crear'.'/'.$id,$this->granjas_mon_model->schema,$datos,'Granjas',null,null,false,$this->granjas_mon_model->schema_add);
		if($this->form_validation->run()){
			$datos = elements($this->granjas_mon_model->schema(),$this->input->post(NULL, TRUE));
			$datos['granjas_status'] = 1;
			if($this->input->post('eliminar',TRUE) != NULL)
				$datos['granjas_status'] = 0;
			$this->granjas_mon_model->save($datos);
	   		$this->template['formulario'] = $this->_getForm('granjas_mon/crear'.'/'.$id,$this->granjas_mon_model->schema,$this->granjas_mon_model->find('list',array('conditions' => array( 'idgranjas_mstr' => $id ))));
		}
		if($this->input->post('eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */