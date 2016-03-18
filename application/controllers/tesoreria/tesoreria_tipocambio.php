<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Tesoreria_tipocambio extends MY_Controller {

    function __construct(){
        parent::__construct();
        $dbBase = $this->load->database('tesoreria',TRUE);
        $this->load->model('tesoreria/tipocambio_model');
        $this->load->helper('form');
        $this->template['module'] = 'tesoreria';
    }
    function index(){
        $this->template['title'] = 'Tipo de Cambio';
        $this->template['insti'] = $this->tipocambio_model->obtenerinstituciones();
        $this->_run('tipocambio/add');

    }
    function add(){
        $data = array(
            'tcd_insti_id' => $this->input->post('tcd_insti_id'),
            'tcd_fecha' => $this->input->post('tcd_fecha'),
            'tcd_hora' => $this->input->post('tcd_hora'),
            'tcd_tc_compra' => $this->input->post('tcd_tc_compra'),
            'tcd_tc_venta' => $this->input->post('tcd_tc_venta'),
            'tcd_descripcion' => $this->input->post('tcd_descripcion'),
        );
        $this->tipocambio_model->ntipocambio($data);
        redirect(base_url('tipocambio/'));
    }

}