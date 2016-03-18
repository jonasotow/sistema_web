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
        $this->template['title2'] = 'notificaciones';
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
    function saldosunes(){
        $this->template['title'] = 'reportes saldos inicales';
        $this->template['saldosunes'] = $this->reporte_model->saldosunes();
        $this->_run('reportes/saldosune');
    }    
    function saldosunes_f(){
        $data = array(
                'fecha'=> $this->input->post('fecha')
        );
        $fecha = $data['fecha'];
        $this->template['fecha'] = $data['fecha'];
        $this->template['title'] = 'reportes saldos inicales';
        $this->template['saldosunes'] = $this->reporte_model->saldosunes_f($fecha);
        $this->_run('reportes/saldosune');
    } 

    function notif_saldos(){
        $data = array(
                'usuario'=> $this->input->post('usuario')
        );
        $usuario = $data['usuario'];
        $this->template['usuario'] = $data['usuario'];
        $this->load->library('email');
        $this->email->from('web@vimifos.com', 'Notificaciones Vimifos');
        $this->email->to('jsoto@vimifos.com');
        $this->email->cc('jmquiroz@vimifos.com');
        $this->email->subject('Notificación de Captura de saldos de '.$usuario);
        $this->email->message($usuario.' a capturado el saldo inicial de sus cuentas.');
        $this->email->send();
        redirect(base_url('reportes/'));
    }
    function tipodecambio(){
        $this->template['title'] = 'Tipo de Cambio';
        $this->template['displaytipo'] = $this->reporte_model->displaytipo();        
        $this->_run('tipocambio/home');

    }
}