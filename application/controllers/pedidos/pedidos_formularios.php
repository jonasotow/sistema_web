<?php if (!defined('BASEPATH')) {die('No direct script access allowed');}

class Pedidos_Formularios extends MY_Controller {

	var $param;

	/**
	 * [__construct description]
	 */
	function __construct() {
		parent::__construct();
		$dbBase = $this->load->database('pedidos', TRUE);
		$this->load->helper('array');
		$this->load->model('pedidos/formularios_model', 'oFormularios');
		$this->template['module'] = 'pedidos';
		$this->template['titulo'] = 'formularios';
		$this->param              = array(
			'cabecera' => array("Id", "Nombre", "Descripcion"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'form_id_formulario'
		);
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index() {
		$campos                    = $this->oFormularios->find('result', array('fields' => array('form_id_formulario', 'form_nombre', 'form_descripcion'), 'conditions' => array('form_estatus' => 1)));
		$this->param               = array_merge($this->param, array('datos'                 => $campos));
		$this->template['table']   = $this->generate_table('formularios/crear', $this->param, 'formularios/delete');
		$this->template['agregar'] = anchor(site_url('formularios/crear'), ' ', array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
		$this->template['action']  = site_url('formularios/crear');
		$this->_run('tabla_ver');
	}

	/**
	 * [nuevo description]
	 * @return [type] [description]
	 */
	public function crear() {
		try{
			$id = $this->uri->segment(3);
			$this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
			$this->form_validation->set_rules('form_nombre', 'Nombre', 'trim|required');
			$this->form_validation->set_rules('form_descripcion', 'Descripcion', 'trim|required');
			$datos = '';
			if (is_numeric($id))
				$datos = $this->oFormularios->find('list', array('conditions' => array('form_id_formulario' => $id)));
			$this->template['formulario'] = $this->_getForm(
                                'formularios/crear'.'/'.$id,
                                $this->oFormularios->schema,
                                $datos,
                                "Planta",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oFormularios->schema_add);
			if ($this->form_validation->run()) {
				$datos = elements($this->oFormularios->schema(), $this->input->post(NULL, TRUE));
				if ($this->input->post('eliminar', TRUE) != NULL) 
					$datos['form_estatus'] = 0;
				else
					$datos['form_estatus'] = 1;
				$this->template['formulario'] = $this->_getForm(
                                'formularios/crear'.'/'.$id,
                                $this->oFormularios->schema,
                                $datos,
                                "Planta",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oFormularios->schema_add);
				$this->oFormularios->save($datos);
			}
		} catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }  	
		if ($this->input->post('eliminar', TRUE) != NULL) 
			$this->index();
		else 
			$this->_run('crud');
	}

	function delete() {
        $id = $this->uri->segment(3);
        $this->oFormularios->delete_t($id);
        $this->index();
    }
}

/* End of file formularios.php */
/* Location: ./application/pedidos/controllers/formularios.php */
