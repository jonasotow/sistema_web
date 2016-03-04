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
class Censos_Contactos extends MY_Controller {

    var $param;

    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('censos', TRUE);
        $this->load->model('censos/contactos_model');
        $this->load->model('censos/modelo_generico_model');
        $this->load->model('censos/clientes_model','oCliente');
        $this->template['module'] = 'censos';
        $this->template['titulo'] = 'contactos';
        $this->template['action'] = site_url('contactos/crear');
        $this->param = array(
            'cabecera' => array("Id", "Clave cliente", "Nombre cliente", "Nombre", "Email", "Telefono", "Celular"),
            'open' => "<table class='table table-striped table-hover table-condensed'>"
        );
    }

    /**
     * Muestra lista de contactos
     * 
     * @access public
     */
    public function index() {
        $this->template['links'] = $this->pagination('contactos/index', $this->modelo_generico_model->count('con_contactos_mstr'));
        $campos = $this->contactos_model->find('result',array( 
				'fields' => array('con_id_contacto','cli_cve_cliente','cli_nombre','con_nombre','con_email','con_telefono','con_celular'),
				'join' => array(
					'clause' => array('cli_clientes_mstr' => 'cli_id_cliente = con_id_cliente'),
					'type' => 'INNER'
				),
				'order' => array( 'con_id_contacto' => 'DESC' ),
				'limit' => array( 10, $this->uri->segment(3) )
				));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['agregar'] = anchor(site_url('contactos/crear'),' ',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['table'] = $this->generate_table('contactos/crear', $this->param);
        $this->_run('tabla_ver');
    }
    
    public function editar() {
	    $this->contactos_model->prepararForm();
	    $id = $this->uri->segment(3);
	    $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
		$this->form_validation->set_rules('con_nombre','Nombre','trim|required');
	   	$datos = '';
	   	if(is_numeric($id)){
	   		$datos = $this->contactos_model->find('list',array('conditions' => array( 'con_id_contacto' => $id )));
	   		$cliente = $this->oCliente->find('list',array('conditions' => array( 'cli_id_cliente' => $datos['con_id_cliente'] )));
			$this->template['agregar_contacto'] = '<a class="navbar-brand" href="'.site_url('contactos/agregarContacto'.'/'.$this->uri->segment(3).'/'.$cliente['cli_tipo_cliente']).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Contacto</span></a>';
		    $this->template['agregar_granja'] = '<a class="navbar-brand" href="'.site_url('granjas/agregarGranja'.'/'.$this->uri->segment(3).'/'.$cliente['cli_tipo_cliente']).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Granja</span></a>';
		    $this->template['agregar_censo'] = '<a class="navbar-brand" href="'.site_url('periodos/agregarCenso'.'/'.$this->uri->segment(3).'/'.$cliente['cli_tipo_cliente']).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Censo</span></a>';

   		}
	   	$this->template['formulario'] = $this->_getForm(
	   			'contactos/crear'.'/'.$id,
	   			$this->contactos_model->schema,
	   			$datos,
	   			"Datos Contactos",
   				'form-inline',
   				'form-inline',
   				FALSE,
   				$this->contactos_model->schema_up
	   		);
		if($this->form_validation->run()){
			$datos = elements($this->contactos_model->schema(),$this->input->post(NULL, TRUE));
			if($this->input->post('eliminar',TRUE) != NULL)
				$datos['con_estatus'] = 0;
			$this->contactos_model->save($datos);
	   		$this->template['formulario'] = $this->_getForm(
	   			'contactos/crear'.'/'.$id,
	   			$this->contactos_model->schema,
	   			$this->contactos_model->find('list',array('conditions' => array( 'con_id_contacto' => $id ))),
	   			"Datos Contactos",
   				'form-inline',
   				'form-inline',
   				FALSE,
   				$this->contactos_model->schema_up
	   		);
		}
		if($this->input->post('eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }
    
    public function crear() {
	    $this->contactos_model->prepararForm();
	    $id = $this->uri->segment(3);
	    $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
		$this->form_validation->set_rules('con_nombre','Nombre','trim|required');
	   	$datos = '';
	   	if(is_numeric($id))
	   		$datos = $this->contactos_model->find('list',array('conditions' => array( 'con_id_contacto' => $id )));
	   	$this->template['formulario'] = $this->_getForm(
	   			'contactos/crear'.'/'.$id,
	   			$this->contactos_model->schema,
	   			$datos,
	   			"Datos Contactos",
   				'form-inline',
   				'form-inline',
   				FALSE,
   				$this->contactos_model->schema_up
	   		);
		if($this->form_validation->run()){
			$datos = elements($this->contactos_model->schema(),$this->input->post(NULL, TRUE));
			if($this->input->post('eliminar',TRUE) != NULL)
				$datos['con_estatus'] = 0;
			$this->contactos_model->save($datos);
	   		$this->template['formulario'] = $this->_getForm(
	   			'contactos/crear'.'/'.$id,
	   			$this->contactos_model->schema,
	   			$this->contactos_model->find('list',array('conditions' => array( 'con_id_contacto' => $id ))),
	   			"Datos Contactos",
   				'form-inline',
   				'form-inline',
   				FALSE,
   				$this->contactos_model->schema_up
	   		);
		}
		if($this->input->post('eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }
    
    public function agregarContacto() {

	    $this->template['agregar_contacto'] = '<a class="navbar-brand" href="'.site_url('contactos/agregarContacto'.'/'.$this->uri->segment(3).'/'.$this->uri->segment(4)).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Contacto</span></a>';
        $this->template['agregar_granja'] = '<a class="navbar-brand" href="'.site_url('granjas/agregarGranja'.'/'.$this->uri->segment(3).'/'.$this->uri->segment(4)).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Granja</span></a>';
        $this->template['agregar_censo'] = '<a class="navbar-brand" href="'.site_url('periodos/agregarCenso'.'/'.$this->uri->segment(3).'/'.$this->uri->segment(4)).'"><i class="fa fa-plus-square fa-lg"></i><span class="nav-text">Censo</span></a>';
	    
	    $this->contactos_model->prepararForm();
	    $id = $this->uri->segment(3);
	    $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
		$this->form_validation->set_rules('con_nombre','Nombre','trim|required');
	   	$datos = '';
	   	$datos = array('con_id_cliente' => $id);
	   	$this->template['formulario'] = $this->_getForm('contactos/agregarContacto'.'/'.$id,$this->contactos_model->schema,$datos,'','','',FALSE,$this->contactos_model->schema_add);
		if($this->form_validation->run()){
			$datos = elements($this->contactos_model->schema(),$this->input->post(NULL, TRUE));
			if($this->input->post('eliminar',TRUE) != NULL)
				$datos['con_estatus'] = 0;
			else
				$datos['con_estatus'] = 1;
			try{
				$this->contactos_model->save($datos);
			}catch(Excepcion $e) {}
	   		$this->template['formulario'] = $this->_getForm('contactos/agregarContacto'.'/'.$id,$this->contactos_model->schema,$this->contactos_model->find('list',array('conditions' => array( 'con_id_contacto' => $id ))),'','','',FALSE,$this->contactos_model->schema_up);
	   		redirect(site_url('clientes/crear/'.$id));
		}
		if($this->input->post('eliminar',TRUE) != NULL)
			$this->index();
		else
			$this->_run('crud');
    }
}

/* End of file contactos.php */
/* Location: ./application/censos/controllers/contactos.php */
    