<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');
/**
 * Prenomina_turnos
 *
 * @package Prenomina
 * @author Alfredo Garcìa
 **/
class Prenomina_turnos extends MY_Controller {

    var $param;
    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $this->load->model('prenomina/turnos_model','oTurnos',FALSE,'prenomina');
        $this->load->model('prenomina/modelo_generico_model',FALSE,'prenomina');
        $this->template['module'] = 'prenomina';
    }
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $this->param = array(
            'cabecera' => array("Id", "Clave", "Descripcíon", "", ""),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => 'fa fa-pencil-square-o fa-lg',
            'delete' => 'fa fa-times fa-lg',
            'url_campo' => 'tur_id'
        );
        $campos = $this->oTurnos->find('result', array('fields' => array('tur_id','tur_clave_turno','tur_descripcion')));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['titulo'] = 'Turnos';
        $this->template['table'] = $this->generate_table('turnos/crear', $this->param, 'turnos/delete');
        $this->template['action'] = site_url('turnos/crear');
        $this->_run('tabla_ver');
    }
    /**
     * [crear description]
     * @return [type] [description]
     */
    public function crear() {
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
        $this->form_validation->set_rules('descripcion','Descripcion','required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('prenomina/crear');
        $datos = $this->oTurnos->find('list',array('conditions' => array( 'idHoja_tecnica' => $id )));
        $this->template['formulario'] = $this->_getForm(
                            'prenomina/crear'.'/'.$id,
                            $this->oTurnos->schema,
                            $datos,
                            "Turnos",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oTurnos->schema_add,
                            TRUE);
        if($this->form_validation->run()){
            $datos = elements($this->oTurnos->schema(),$this->input->post(NULL, TRUE));
            $this->template['formulario'] = $this->_getForm(
                            'prenomina/crear'.'/'.$id,
                            $this->oTurnos->schema,
                            $datos,
                            "Turnos",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oTurnos->schema_add,
                            TRUE);
            $this->oTurnos->save($datos);
        }
        $this->_run('crud');
    }
    /**
     * [delete description]
     * @return [type] [description]
     */
    function delete() {
        $id = $this->uri->segment(3);
        $this->oTurnos->delete_t($id);
        $this->index();
    }
}