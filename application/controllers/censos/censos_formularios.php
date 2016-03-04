<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

class Censos_Formularios extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('censos', TRUE);
        $this->load->helper('array');
        $this->load->model('censos/formularios_model');
        $this->template['module'] = 'censos';
        $this->param = array(
            'cabecera' => array("Id","Nombre","Descripcion")
        );
    }

     /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->formularios_model->find('result',array('fields' => array('form_id_formulario','form_nombre','form_descripcion'),'conditions' => array( 'form_estatus' => 1 )));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('formularios/crear', $this->param);
        $this->template['agregar'] = anchor(site_url('formularios/crear'),' ',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('formularios/crear');
        $this->_run('tabla_ver');
    }

    /**
     * [nuevo description]
     * @return [type] [description]
     */
    public function crear() {
        try{
    	    $id = $this->uri->segment(3);
    	    if(!is_numeric($id))
    			$this->form_validation->set_rules('form_nombre','Nombre','trim|required|is_unique[form_formularios_mstr.form_nombre]');
    	   	$this->form_validation->set_rules('form_descripcion','Descripcion','trim|required');
    	   	$datos = '';
    	   	if(is_numeric($id))
    	   		$datos = $this->formularios_model->find('list',array('conditions' => array( 'form_id_formulario' => $id )));
    	   	$this->template['formulario'] = $this->_getForm('formularios/crear'.'/'.$id,$this->formularios_model->schema,$datos);
    		if($this->form_validation->run()){
    			$datos = elements($this->formularios_model->schema(),$this->input->post(NULL, TRUE));
    			if($this->input->post('eliminar',TRUE) != NULL)
    				$datos['form_estatus'] = 0;
    			$this->formularios_model->save($datos);
    	   		$this->template['formulario'] = $this->_getForm('formularios/crear'.'/'.$id,$this->formularios_model->schema,$this->formularios_model->find('list',array('conditions' => array( 'form_id_formulario' => $id ))));
    		}
        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }         
		if($this->input->post('eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }
}

/* End of file formularios.php */
/* Location: ./application/censos/controllers/formularios.php */
