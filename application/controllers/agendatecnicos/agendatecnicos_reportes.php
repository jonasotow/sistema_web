<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  contactos Class
 *
 *  @category:  Controlador
 *  @author:    José Manzo
 */
class Agendatecnicos_reportes extends MY_Controller {

    var $param;

    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('agenda', TRUE);
        $this->load->model('agendatecnicos/reportes_model','oReportes');
        $this->load->model('agendatecnicos/cal_model','oCal');
        $this->template['module'] = 'reportes';

     //   $this->load->model('agendatecnicos/reportes/vista');
    }

    /**
     * Muestra lista de contactos
     * 
     * @access public
     */
    public function index() {
        //echo $this->input->post('user')." ".$this->input->post('fch_inicio')." ".$this->input->post('fch_final');
        //print_r($this->input->post('user'));
        //$this->template['registros'] = $this->oCal->reportes($this->input->post('user'),$this->input->post('fch_inicio'),$this->input->post('fch_final'));
        $this->template['registros'] = $this->oCal->viewReporte($this->input->post('user'),$this->input->post('fch_inicio'),$this->input->post('fch_final'));
        $this->template['usuarios'] = $this->oReportes->regresaUsuarios();
        $this->_run('vista');  
    }

}

/* End of file contactos.php */
/* Location: ./application/censos/controllers/contactos.php */
