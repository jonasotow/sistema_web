<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Tesoreria_inversion extends MY_Controller {

    function __construct(){
        parent::__construct();
        $dbBase = $this->load->database('tesoreria',TRUE);
        $this->load->model('tesoreria/inversion_model');
        $this->load->helper('form');
        $this->template['module'] = 'tesoreria';
    }
    function index(){
	    $this->template['title'] = 'Inversión';
        $this->template['contadorflujo'] = $this->inversion_model->contadorflujo();
        if($this->template['contadorflujo'] > 0){
            $this->template['datos'] = 'Datos';
        }
        else{
            $this->template['datos'] = 'Cero';
            $obtenercuentasflujo = $this->inversion_model->obtenercuentasflujo();
                foreach ($obtenercuentasflujo as $cuentas) {
                $data =  array(
                    'cued_id' => $cuentas->cue_id,
                    );
                $fecha = date('Y-m-d');    
                $this->template['agregarsaldoencero'] = $this->inversion_model->agregarsaldoencero($fecha,$data);
            }
        }

        $this->template['cuentasinv'] = $this->inversion_model->cuentasinversion();
        $this->_run('inversion/home');
    }

}