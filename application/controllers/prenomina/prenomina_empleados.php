<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Prenomina_empleados extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $this->load->model('prenomina/Empleados_model','oEmpleados',FALSE,'prenomina');
        $this->load->model('prenomina/modelo_generico_model',FALSE,'prenomina');
        $this->template['module'] = 'prenomina';
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $this->param = array(
            'cabecera' => array("Id", "Numero", "Nombre", "Apellido paterno", "Apelido materno", "Ubicacion","",""),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => 'fa fa-pencil-square-o fa-lg',
            'delete' => 'fa fa-times fa-lg',
            'url_campo' => 'emp_id'
        );
        $campos = $this->oEmpleados->find('result', array('fields' => array('emp_id','emp_numero','emp_nombre','emp_apellido_paterno','emp_apellido_materno','emp_dep_ubicacion')));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['titulo'] = 'Prenomina';
        $this->template['table'] = $this->generate_table('empleados/crear', $this->param, 'empleados/delete');
        $this->template['action'] = site_url('empleados/crear');
        $this->_run('tabla_ver');
    }

    public function crear() {
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
        $this->form_validation->set_rules('descripcion','Descripcion','required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('prenomina/crear');
        $datos = $this->oEmpleados->find('list',array('conditions' => array( 'idHoja_tecnica' => $id )));
        $this->template['formulario'] = $this->_getForm(
                            'prenomina/crear'.'/'.$id,
                            $this->oEmpleados->schema,
                            $datos,
                            "Hojas Tecnicas",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oEmpleados->schema_add);
        if($this->form_validation->run()){
            $datos = elements($this->oEmpleados->schema(),$this->input->post(NULL, TRUE));
            $this->template['formulario'] = $this->_getForm(
                            'prenomina/crear'.'/'.$id,
                            $this->oEmpleados->schema,
                            $datos,
                            "Hojas Tecnicas",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oEmpleados->schema_add);
            $this->oEmpleados->save($datos);
        }
        $this->_run('crud');
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->oEmpleados->delete_t($id);
        $this->index();
    }
}