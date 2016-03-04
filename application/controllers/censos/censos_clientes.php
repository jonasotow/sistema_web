<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

class Censos_Clientes extends MY_Controller {

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
		$this->load->model('censos/censos_model','oEspecie');
        $this->load->model('censos/modelo_generico_model');
        $this->template['module'] = 'censos';
        $this->template['titulo'] = 'clientes';
        $this->template['action'] = site_url('clientes/crear');
        $this->param = array(
            'cabecera' => array("Id", "Clave MFG", "Nombre", "Direccion"),
            'open' => "<table class='table table-striped table-hover table-condensed'>"
        );
    }
    
    public function crear() {
	    try{
		    $this->oCliente->prepararForm();
		    $id = $this->uri->segment(3);
		    $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
		    
		    if(!is_numeric($id))
				$this->form_validation->set_rules('cli_cve_cliente','Id Cliente','trim|required|is_unique[cli_clientes_mstr.cli_cve_cliente]');
			else{
				$contactos = array('cabecera' => array("Id", "Clave cliente", "Nombre cliente", "Nombre", "Email", "Telefono", "Celular"), 'leyenda' => 'Contactos del Cliente', 'open' => '<table data-name="contactos" class="table">');
				$granjas = array('cabecera' => array("Id", "Nombre", "Gerente", "Direccion", "Estado"), 'leyenda' => 'Granjas del Cliente', 'open' => '<table data-name="granjas" class="table">');
				$censos = array('cabecera' => array("Id", "Clave Cliente", "Granja", "Censo", "Año","Mes"), 'leyenda' => 'Censos disponibles del Cliente', 'open' => '<table data-name="censos" class="table">');
				$campos = $this->oGranjas->find('result', array(
					'fields' => array('gran_id_granja','gran_nombre','gran_gerente_atiende','gran_direccion','gran_estado'),
					'join' => array(
						'clause' => array('cli_clientes_mstr' => 'cli_id_cliente = gran_id_cliente'),
						'type' => 'INNER'
					),
					'conditions' => array('gran_estatus' => 1,'cli_id_cliente' => $id)));
	        	$granjas = array_merge($granjas, array('datos' => $campos));
	        	$this->template['granjas'] = $this->generate_table('granjas/crear', $granjas);
	        	$campos = $this->oContacto->find('result',array( 
					'fields' => array('con_id_contacto','cli_cve_cliente','cli_nombre','con_nombre','con_email','con_telefono','con_celular'),
					'join' => array(
						'clause' => array('cli_clientes_mstr' => 'cli_id_cliente = con_id_cliente'),
						'type' => 'INNER'
					),
					'conditions' => array('cli_id_cliente' => $id),
					'order' => array( 'con_id_contacto' => 'DESC' )
					));
		        $contactos = array_merge($contactos, array('datos' => $campos));
		        $this->template['contactos'] = $this->generate_table('contactos/crear', $contactos);
		        $campos = $this->oPeriodo->find('result',array( 
					'fields' => array('per_id_periodo','cli_cve_cliente','gran_nombre','especies_desc','per_anio','per_mes'),
					'join' => array(
						'clause' => array('gran_granjas_mstr' => 'gran_id_granja = per_id_granja', 'especies_tipos' => 'idespecies_tipos = per_id_especie', 'cli_clientes_mstr' => 'cli_id_cliente = gran_id_cliente'),
						'type' => 'INNER'
					),
					'conditions' => array('cli_id_cliente' => $id,'gran_estatus' => 1),
					'order' => array( 'gran_nombre' => 'ASC', 'idespecies_tipos'=> 'ASC', 'per_mes' => 'ASC', 'per_anio' => 'ASC' )
					));
		        $censos = array_merge($censos, array('datos' => $campos));
		        $this->template['censos'] = $this->generate_table('censos/crear', $censos);
			}
		   	$this->form_validation->set_rules('cli_nombre','Nombre','trim|required');
		   	$datos = '';
		   	if(is_numeric($id)){
		   		$datos = $this->oCliente->find('list',array('conditions' => array( 'cli_id_cliente' => $id )));

		        $this->template['agregar_contacto'] = '<a class="navbar-brand" href="'.site_url('contactos/agregarContacto'.'/'.$this->uri->segment(3).'/'.$datos['cli_tipo_cliente']).'"><i class="fa fa-plus-square"></i><span class="nav-text">Contacto</span></a>';
		        $this->template['agregar_granja'] = '<a class="navbar-brand" href="'.site_url('granjas/agregarGranja'.'/'.$this->uri->segment(3).'/'.$datos['cli_tipo_cliente']).'"><i class="fa fa-plus-square"></i><span class="nav-text">Granja</span></a>';
		        $this->template['agregar_censo'] = '<a class="navbar-brand" href="'.site_url('periodos/agregarCenso'.'/'.$this->uri->segment(3).'/'.$datos['cli_tipo_cliente']).'"><i class="fa fa-plus-square"></i><span class="nav-text">Censo</span></a>';

	
		    	
		   		$this->oCliente->Municipios($datos['cli_estado']);
		   		if($datos['cli_tipo_cliente'] != 0){
			   		$this->oEspecie->show_especie($datos['cli_tipo_cliente']);
			   		$this->template['formulario_especie'] = $this->_getForm(
		   				'clientes/crear'.'/'.$id,
		   				$this->oEspecie->schema,
		   				$this->oEspecie->values,
		   				"Datos Especie",
		   				'form-inline',
		   				'especies',
		   				FALSE);
		   		}
	   		}
	   		$this->template['formulario'] = $this->_getForm(
	   				'clientes/crear'.'/'.$id,
	   				$this->oCliente->schema,
	   				$datos,
	   				"Datos Clientes",
	   				'form-inline',
	   				'form_enviar',
	   				FALSE,
	   				$this->oCliente->schema_up);
			if($this->form_validation->run()){
				$datos = elements($this->oCliente->schema(),$this->input->post(NULL, TRUE));
				if($this->input->post('eliminar',TRUE) != NULL)
					$datos['cli_estatus'] = 0;
				else
					$datos['cli_estatus'] = 1;
				$this->template['formulario'] = $this->_getForm(
	   				'clientes/crear'.'/'.$id,
	   				$this->oCliente->schema,
	   				$datos,
	   				"Datos Clientes",
	   				'form-inline',
	   				'form_enviar',
	   				FALSE,
	   				$this->oCliente->schema_up);
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
	    $this->template['links'] = $this->pagination('campos/index', $this->modelo_generico_model->count('cli_clientes_mstr'));
        $campos = $this->oCliente->find('result', array('fields' => array('cli_id_cliente','cli_cve_cliente','cli_nombre','cli_direccion')));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('clientes/editar', $this->param);
        $this->template['agregar'] = anchor(site_url('clientes/crear'),'Agregar Cliente',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
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
    
    public function getMunicipios(){
	    echo json_encode($this->oCliente->prepararMunicipios($this->input->post('estado',TRUE)));
    }
    
    public function getFormularioEspecie(){
	    $this->oEspecie->show_especie($this->input->post('especie',TRUE));
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

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */