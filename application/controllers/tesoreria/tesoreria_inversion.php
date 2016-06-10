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
        $this->template['cuentasinv'] = $this->inversion_model->flujocuentasinversion();
        if($this->template['contadorflujo'] > 0){
            $this->template['datos'] = 'Datos';
        }
        else{
            $this->template['datos'] = 'Cero';
// Ceros *****
            $cuentasflujo = $this->inversion_model->cuentasflujo();
                foreach ($cuentasflujo as $cuentas) {
                $data =  array(
                    'cued_id' => $cuentas->cue_id,
                    );
                $fecha = date('Y-m-d');    
            $this->template['agregarsaldoencero'] = $this->inversion_model->agregarsaldoencero($fecha,$data);
            }
// Saldo anterior *****  
            $flujoinvfecha = $this->inversion_model->flujoinvfecha();
                foreach ($flujoinvfecha as $flujoinvfecha) {
            $this->template['fs'] = $flujoinvfecha->cued_fecha;

            }
            $fech = $this->template['fs'];
            $cuentasflujoinv = $this->inversion_model->cuentasflujoinv($fech);
                foreach ($cuentasflujoinv as $cuentass) {
                    $datos = array(
                        'cued_id' => $cuentass->cue_id,
                        'cued_sald_fin' => $cuentass->cued_sald_fin,
                    );
            $fecha = date('Y-m-d');    
            $this->template['agregarsaldoant'] = $this->inversion_model->agregarsaldoant($fecha,$datos); 
            $this->template['agregarsaldoantinv'] = $this->inversion_model->agregarsaldoantinv($fecha,$datos);
          
            }
        }


        $this->_run('inversion/home');
    }

    function flujoinversion(){
        $this->template['title'] = 'Flujo Inversión';
        $this->template['cuentasinv'] = $this->inversion_model->flujocuentasinversion();
        $this->_run('inversion/flujoinv');
    }

    function addinversion(){
        $this->template['title'] = 'Captura de Saldo de Inversión';
        $this->template['ctainversion'] = $this->inversion_model->cuentasinversion();
        $this->_run('inversion/addinv');
    }

    function saldoant(){
        $result_datos_destino = $_POST['ctainv'];
        $separa_datos_destino = explode('|', $result_datos_destino);
        $id = $separa_datos_destino[0];
        $cueinv_sald_ini = $separa_datos_destino[2];
        $fecha = date('Y-m-d');

        $datos = array(
                    'cueinv_sald_fin'=> $this->input->post('cueinv_sald_fin'),
                    'cueinv_dias'=> $this->input->post('cueinv_dias')
                );

        $saldoi = $cueinv_sald_ini; 
        $saldod = $datos['cueinv_sald_fin']; 
        $dias =  $datos['cueinv_dias'];
        $rendi = $saldod - $saldoi;
        $tasan = ($rendi / $saldoi * 360 / $dias) * 100; 
        $tasab = $tasan + 0.6 ;

        $this->template['actualizardatosinv'] = $this->inversion_model->actualizardatosinv($id,$cueinv_sald_ini,$datos,$fecha,$rendi,$tasab,$tasan); 
        $this->template['actualizarsaldof'] = $this->inversion_model->actualizarsaldof($id,$datos,$fecha,$cueinv_sald_ini); 

        $this->template['title'] = 'Captura de Saldo de Inversión';
        $this->template['ctainversion'] = $this->inversion_model->cuentasinversion();
        $this->_run('inversion/addinv');

    }

}