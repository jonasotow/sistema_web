<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  Tablas_genericas Class
 *
 *  @category:  Controlador
 *  @author:   	
 */
class Censos_Tablas_genericas extends MY_Controller {
    
    var $param;

    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('censos', TRUE);
        $this->load->model('censos/tablas_genericas_model');
        $this->template['module'] = 'tablas_genericas/tablas';
        $this->param = array(
            'cabecera' => array("Id","Tabla","Descripcion","Comentarios","Editar"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'url_campo' => 'tblg_id_tabla_generica'
        );
    }

    /**
     * Recibe los datos de la nueva tabla generica
     * 
     * @access public
     */
    public function index() {
        $campos = $this->tablas_genericas_model->find();
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['tablas_genericas'] = $this->generate_table('tablas_genericas/editar', $this->param);
        $this->_run('tabla_generica');
    }

    /**
     * Carga formulario para una nueva tabla generica
     * 
     * @access public
     */
    public function nuevo() {
        $this->_run('tabla_generica_nueva');
    }

    /**
     * Recibe los datos de la nueva tabla generica
     * 
     * @access public
     */
    public function recibe_datos_nuevo() {
        $this->tablas_genericas_model->insert_tabla_generica($this->input->post(NULL, TRUE));
        redirect('tablas_genericas', 'refresh');
    }

	/**
     *  Carga formulario con datos de la tabla generica para editar
     * 
     * @access public
     */
    public function editar() {
        $this->template['id_tabla_generica'] = $this->uri->segment(3);
        $this->template['tablas_genericas'] = $this->tablas_genericas_model->find($this->template['id_tabla_generica']);
        $this->_run('tabla_generica_editar');
    }

     /**
     * Recibe los datos de la tabla generica actualizada
     * 
     * @access public
     */
    public function recibe_datos_editar() {
        $id['id_tabla_generica'] = $this->uri->segment(3);
        $this->tablas_genericas_model->update_tabla_generica($id, $this->input->post(NULL, TRUE));
        redirect('tablas_genericas', 'refresh');
    }

}

/* End of file tablas_genericas.php */
/* Location: ./application/censos/controllers/tablas_genericas.php */