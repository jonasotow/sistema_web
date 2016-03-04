<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  campos Class
 *
 *  @category:  Controlador
 *  @author:    José Manzo
 */
class Censos_Campos extends MY_Controller {

    var $param;

    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('censos', TRUE);
        $this->load->model('censos/campos_model');
        $this->load->model('censos/formularios_model');
        $this->template['module'] = 'censos';
        $this->param = array(
            'cabecera' => array("Id", "Formulario", "Id", "Label", "Type", "Name", "Value", "Required", "Pocision", "Estatus", "Editar"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'url_campo' => 'cam_id_campo'
        );
    }

    /**
     * Muestra lista de campos
     * 
     * @access public
     */
    public function index() {
        $this->template['links'] = $this->pagination('campos/index', $this->modelo_generico_model->count('cam_campos_det'));
        $campos = $this->campos_model->find('result',array( 
				'fields' => array('cam_id_campo','form_nombre','cam_id','cam_label','cam_type','cam_value','cam_name','cam_required','cam_posicion','cam_estatus'),
				'join' => array(
					'clause' => array('form_formularios_mstr' => 'cam_id_formulario = form_id_formulario'),
					'type' => 'INNER'
				),
				'order' => array( 'cam_id_campo' => 'DESC' ),
				'limit' => array( 10, $this->uri->segment(3) )
				));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['campos'] = $this->generate_table('campos/crear', $this->param);
        $this->_run('tabla_ver');
    }
    
    public function crear() {
        try{
    	    $this->campos_model->prepararForm();
    	    $id = $this->uri->segment(3);
    	    if(!is_numeric($id))
    			$this->form_validation->set_rules('cam_id','Id Campo','trim|required|is_unique[cam_campos_det.cam_id]');
    	   	$this->form_validation->set_rules('cam_label','Etiqueta','trim|required');
    	   	$datos = '';
    	   	if(is_numeric($id))
    	   		$datos = $this->campos_model->find('list',array('conditions' => array( 'cam_id_campo' => $id )));
    	   	$this->template['formulario'] = $this->_getForm('campos/crear'.'/'.$id,$this->campos_model->schema,$datos);
    		if($this->form_validation->run()){
    			$datos = elements($this->campos_model->schema(),$this->input->post(NULL, TRUE));
    			if($this->input->post('eliminar',TRUE) != NULL)
    				$datos['cam_estatus'] = 0;
    			$this->campos_model->save($datos);
    	   		$this->template['formulario'] = $this->_getForm('campos/crear'.'/'.$id,$this->campos_model->schema,$this->campos_model->find('list',array('conditions' => array( 'cam_id_campo' => $id ))));
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

/* End of file campos.php */
/* Location: ./application/censos/controllers/campos.php */