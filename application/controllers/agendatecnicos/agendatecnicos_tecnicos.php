<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  contactos Class
 *
 *  @category:  Controlador
 *  @author:    José Manzo
 */
class Agendatecnicos_Tecnicos extends MY_Controller {

    var $param;

    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('agenda', TRUE);
        $this->load->model('agendatecnicos/tecnicos_model','oTec');
        $this->template['module'] = 'agenda';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Apellidos", "Regi&oacute;n", "Domicilio", "Ciudad", "Estado", "Tel&eacute;fono", "Celular"),
            'open' => "<table class='table table-striped table-hover table-condensed'>"
        );
        $this->template['titulo'] = "Tecnicos Existentes";
    }
    /**
     * Muestra lista de contactos
     * 
     * @access public
     */
    public function index() {
	    //$this->template['titulo'] = "Tecnicos Existentes";
        //$this->template['links'] = $this->pagination('tecnicos/index', $this->oTec->count('tecnicos'));

        $campos = $this->oTec->find('result',array( 
				'fields' => array('tec_id','tec_nombre','tec_apellidos','tec_region','tec_domicilio','tec_ciudad','tec_estado','tec_telefono','tec_celular'),
				'order' => array( 'tec_id' => 'DESC' ),
				'limit' => array( 10, $this->uri->segment(3) )
				));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['agregar'] = anchor(site_url('tecnicos/crear'),'Agregar Tecnico',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('tecnicos/crear');
        $this->template['table'] = $this->generate_table('tecnicos/crear', $this->param);
        $this->_run('tabla_ver');  
    }
    
    public function crear() {
	    try{		    	    	
		    $id = $this->uri->segment(3);
		    $this->template['titulo'] = !is_numeric($id) ? "AÑADIR TÉCNICO" : "EDITAR TÉCNICO";
			$this->form_validation->set_rules('usu_nombre','Nombre','trim|required');
		   	$datos = '';
		   	if(is_numeric($id)){
			   	$datos = $this->oTec->find('list',array('conditions' => array( 'tec_id' => $id )));
			   	$this->template['formulario'] = $this->_getForm(
		   			'tecnicos/crear'.'/'.$id,
		   			$this->oTec->schema,
		   			$datos,
		   			"Datos Tecnicos",
	   				'form-inline',
	   				'form-inline',
	   				FALSE,
	   				$this->oTec->schema_up
		   		);
	   		}
	   		else	 	   		    	  		
	   			$this->template['formulario'] = $this->_getForm(
		   			'tecnicos/crear'.'/'.$id,
		   			$this->oTec->schema,
		   			$datos,
		   			"Datos Tecnicos",
	   				'form-inline',
	   				'form-inline',
	   				TRUE,
	   				$this->oTec->schema_add
		   		);	   	

			if($this->form_validation->run()){				
				$datos = elements($this->oTec->schema(),$this->input->post(NULL, TRUE));
				if($this->input->post('Eliminar',TRUE) != NULL)										
					$datos['tec_estatus'] = 0;
				else
				 	$datos['tec_estatus'] = 1;
		   		$this->template['formulario'] = $this->_getForm(
		   			'tecnicos/crear'.'/'.$id,
		   			$this->oTec->schema,
		   			$datos,
		   			"Datos Tecnicos",
	   				'form-inline',
	   				'form-inline',
	   				FALSE,
	   				$this->oTec->schema_up
		   		);
		   		$this->oTec->save($datos);
			}
		} catch(Excepcion $e){
			$this->template['mensajes'] = $e->__toString();
		}
		if($this->input->post('Eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }
}

/* End of file contactos.php */
/* Location: ./application/censos/controllers/contactos.php */
    