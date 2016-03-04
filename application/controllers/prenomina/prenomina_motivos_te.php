<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Prenomina_motivos_te extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $this->load->model('prenomina/Motivos_te_model','oMotivosTE',FALSE,'prenomina');
        $this->load->model('prenomina/modelo_generico_model',FALSE,'prenomina');
        $this->template['module'] = 'prenomina';
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $this->param = array(
            'cabecera' => array("Id", "Clave", "Descripcion", "", ""),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => 'fa fa-pencil-square-o fa-lg',
            'delete' => 'fa fa-times fa-lg',
            'url_campo' => 'mte_id'
        );
        $campos = $this->oMotivosTE->find('result', array('fields' => array('mte_id','mte_clave','mte_descripcion')));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('motivos_te/crear', $this->param, 'motivos_te/delete');
        $this->template['action'] = site_url('motivos_te/crear');
        $this->_run('tabla_ver');
    }

    public function crear() {
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
        $this->form_validation->set_rules('descripcion','Descripcion','required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('prenomina/crear');
        $datos = $this->oMotivosTE->find('list',array('conditions' => array( 'idHoja_tecnica' => $id )));
        $this->template['formulario'] = $this->_getForm(
                            'prenomina/crear'.'/'.$id,
                            $this->oMotivosTE->schema,
                            $datos,
                            "Hojas Tecnicas",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oMotivosTE->schema_add);
        if($this->form_validation->run()){
            $datos = elements($this->oMotivosTE->schema(),$this->input->post(NULL, TRUE));
            $this->template['formulario'] = $this->_getForm(
                            'prenomina/crear'.'/'.$id,
                            $this->oMotivosTE->schema,
                            $datos,
                            "Hojas Tecnicas",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oMotivosTE->schema_add);
            $this->oMotivosTE->save($datos);
        }
        $this->_run('crud');
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->oMotivosTE->delete_t($id);
        $this->index();
    }
}