<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Tesoreria_reportes extends MY_Controller {

    function __construct(){
        parent::__construct();
        $dbBase = $this->load->database('tesoreria',TRUE);
        $this->load->model('tesoreria/reporte_model');
        $this->load->helper('form');
        $this->template['module'] = 'tesoreria';
    }
    function index(){
        $this->template['title'] = 'reportes';
        $this->_run('reportes/home');

    }
    function rtraspasoactual(){

        $this->template['title'] = 'reportes traspaso';
        $this->template['reportetrapasos'] = $this->reporte_model->reportetrapasos();
        $this->_run('reportes/reportetraspasosactual');

    }
    function reportetrapasos_f(){
        $data = array(
                'fecha'=> $this->input->post('fecha')
        );
        $fecha = $data['fecha'];
        $this->template['fecha'] = $data['fecha'];
        $this->template['title'] = 'reportes traspaso';
        $this->template['reportetrapasos'] = $this->reporte_model->reportetrapasos_f($fecha);
        $this->_run('reportes/reportetraspasosactual');

    }    


}