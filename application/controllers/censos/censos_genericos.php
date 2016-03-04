<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

class Censos_Genericos extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('censos', TRUE);
        $this->load->model('censos/genericos_model');
        $this->template['module'] = 'genericos';
        $this->param = array(
            'cabecera' => array("fieldname", "Valor", "Descripcion", "Comentario"),
            'open' => '<table class="table table-striped table-hover table-condensed">'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
	    $name = $this->uri->segment(3);
        $campos = $this->genericos_model->find('result', array(
        	'fields' => array('code_fldname','code_value','code_desc','code_cmmt'),
        	'conditions' => array('code_status' => 1, 'code_fldname' => $name)
        	));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('genericos/crear', $this->param);
        $this->template['agregar'] = anchor(site_url('genericos/crear'),' ',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('genericos/crear');
        $this->_run('generico');
    }
    
     public function crear() {
        try{
    	    $id = $this->uri->segment(3);
    	    if(!is_numeric($id))
    			$this->form_validation->set_rules('code_value','Valor','trim|required');
    	   	$this->form_validation->set_rules('code_desc','Descripcion','trim|required');
    	   	$datos = '';
    	   	if(is_numeric($id))
    	   		$datos = $this->granjas_model->find('list',array('conditions' => array( 'code_value' => $id )));
    	   	$this->template['formulario'] = $this->_getForm('granjas/crear'.'/'.$id,$this->granjas_model->schema,$datos);
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
			$this->_run('granja_update');
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */