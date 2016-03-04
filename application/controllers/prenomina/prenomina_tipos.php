<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Prenomina_tipos extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $this->load->model('prenomina/Tipos_model','oTipos',FALSE,'prenomina');
        $this->load->model('prenomina/modelo_generico_model',FALSE,'prenomina');
        $this->template['module'] = 'prenomina';
    }

   /**
    * [index description]
    * @return [type] [description]
    */
    public function index() {
        $this->param = array(
            'cabecera' => array("Id", "Inicial", "Descripcion", "", ""),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => 'fa fa-pencil-square-o fa-lg',
            'delete' => 'fa fa-times fa-lg',
            'url_campo' => 'tip_id'
        );
        $campos = $this->oTipos->find('result', array('fields' => array('tip_id','tip_inicial','tip_descripcion')));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('tipos/crear', $this->param, 'tipos/delete');
        $this->template['action'] = site_url('tipos/crear');
        $this->_run('tabla_ver');
    }

    public function crear() {
        $id = $this->uri->segment(3);
        $this->form_validation->set_rules('descripcion','Descripcion','required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('tipos/crear');
        $datos = $this->oTipos->find('list',array('conditions' => array( 'tip_id' => $id )));
        $this->template['formulario'] = $this->_getForm(
                            'tipos/crear'.'/'.$id,
                            $this->oTipos->schema,
                            $datos,
                            "Tipos",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oTipos->schema_add);
        if($this->form_validation->run()){
            $datos = elements($this->oTipos->schema(),$this->input->post(NULL, TRUE));
            $this->template['formulario'] = $this->_getForm(
                            'tipos/crear'.'/'.$id,
                            $this->oTipos->schema,
                            $datos,
                            "Tipos",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oTipos->schema_add);
            $this->oTipos->save($datos);
        }
        $this->_run('crud');
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->oTipos->delete_t($id);
        $this->index();
    }
}