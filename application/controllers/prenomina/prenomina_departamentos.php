<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Prenomina_departamentos extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $this->load->model('prenomina/Departamentos_model','oDepartamentos',FALSE,'prenomina');
        $this->load->model('prenomina/modelo_generico_model',FALSE,'prenomina');
        $this->template['module'] = 'prenomina';
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $this->param = array(
            'cabecera' => array("Id", "Ubicacion", "", "",),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => 'fa fa-pencil-square-o fa-lg',
            'delete' => 'fa fa-times fa-lg',
            'url_campo' => 'dep_id'
        );
        $campos = $this->oDepartamentos->find('result', array('fields' => array('dep_id','dep_ubicacion')));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['titulo'] = 'Prenomina';
        $this->template['table'] = $this->generate_table('pre_nomina/crear', $this->param, 'pre_nomina/delete');
        $this->template['action'] = site_url('pre_nomina/crear');
        $this->_run('tabla_ver');
    }

    public function crear() {
            $id = $this->uri->segment(3);
            $this->form_validation->set_rules('descripcion','Descripcion','required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('prenomina/crear');
            $datos = $this->oDepartamentos->find('list',array('conditions' => array( 'dep_id' => $id )));
            $this->template['formulario'] = $this->_getForm(
                                'prenomina/crear'.'/'.$id,
                                $this->oDepartamentos->schema,
                                $datos,
                                "Departamentos",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oDepartamentos->schema_add);
            if($this->form_validation->run()){
                $datos = elements($this->oDepartamentos->schema(),$this->input->post(NULL, TRUE));
                $this->template['formulario'] = $this->_getForm(
                                'prenomina/crear'.'/'.$id,
                                $this->oDepartamentos->schema,
                                $datos,
                                "Departamentos",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oDepartamentos->schema_add);
                $this->oDepartamentos->save($datos);
            }        
        $this->_run('crud');
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->oDepartamentos->delete_t($id);
        $this->index();
    }
}