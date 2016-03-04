<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  Tablas_genericas_valores Class
 *
 *  @category:  Controlador
 *  @author:   	
 */
class Censos_Tablas_genericas_valores extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('censos', TRUE);
        $this->load->model('censos/tablas_genericas_valores_model');
        $this->template['module'] = 'tablas_genericas/valores';
        $this->param = array(
            'cabecera' => array("Id", "Tabla generica", "Valor", "Tabla relacionar", "Editar"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'url_campo' => 'tblgval_id_tabla_generica_valor'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $this->template['links'] = $this->pagination('tablas_genericas_valores/index', $this->modelo_generico_model->count('tblgval_tablas_genericas_valores_det'));
        $campos = $this->tablas_genericas_valores_model->find(10, $this->uri->segment(3));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['tablas_genericas_valores'] = $this->generate_table('tablas_genericas_valores/editar', $this->param);
        $this->_run('tabla_generica_valor');
    }

    /**
     * [nuevo description]
     * @return [type] [description]
     */
    public function nuevo() {
        $this->_get_valores();
        $this->_run('tabla_generica_valor_nueva');
    }

    /**
     * [recibirDatos description]
     * @return [type] [description]
     */
    public function recibir_datos() {
        $this->tablas_genericas_valores_model->insert_tabla_generica_valor($this->input->post(NULL, TRUE));
        $this->index();
    }

    /**
     * [editar description]
     * @return [type] [description]
     */
    public function editar() {
        $this->_get_valores();
        $this->template['id'] = $this->uri->segment(3);
        $this->template['tablas_genericas_valores'] = $this->tablas_genericas_valores_model->find(null, null, $this->template['id']);
        $this->_run('tabla_generica_valor_editar');
    }

    /**
     * [actualizar description]
     * @return [type] [description]
     */
    public function recibe_datos_editar() {
        $id['id'] = $this->uri->segment(3);
        $this->tablas_genericas_valores_model->update_tabla_generica_valor($id, $this->input->post(NULL, TRUE));
        $this->index();
    }

    private function _get_valores() {
        $this->template['tablas_genericas'] = $this->modelo_generico_model->get_value('tblg_tablas_genericas_mstr', 'tblg_id_tabla_generica', 'tblg_tabla');
    }

}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */