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
        $this->template['title'] = 'Inversiones';
        $this->template['cuentasinv'] = $this->inversion_model->flujocuentasinversion();
        $this->template['todo'] = $this->inversion_model->obtenertods();
        $this->template['ctainversion'] = $this->inversion_model->cuentasinversion();
        $this->_run('inversion/flujoinv');
    }

    function saldoant(){
        
        $datos = array(
                    'cueinv_id' => $this->input->post('cueinv_id'),
                    'cueinv_sald_ini' => $this->input->post('cueinv_sald_ini'),
                    'cueinv_sald_fin'=> $this->input->post('cueinv_sald_fin'),
                    'cueinv_dias'=> $this->input->post('cueinv_dias')
                );

        $fecha = date('Y-m-d');
        $id = $datos['cueinv_id'];
        $cueinv_sald_ini = $datos['cueinv_sald_ini']; 
        $cueinv_sald_fin = $datos['cueinv_sald_fin']; 

        $saldoi = $cueinv_sald_ini; 
        $saldod = $datos['cueinv_sald_fin']; 
        $dias =  $datos['cueinv_dias'];
        $rendi = $saldod - $saldoi;
        $tasan = ($rendi / $saldoi * 360 / $dias) * 100; 
        $tasab = $tasan + 0.6 ;

        $this->template['actualizardatosinv'] = $this->inversion_model->actualizardatosinv($id,$cueinv_sald_ini,$datos,$fecha,$rendi,$tasab,$tasan); 
        $this->template['actualizarsaldof'] = $this->inversion_model->actualizarsaldof($id,$datos,$fecha,$cueinv_sald_ini,$cueinv_sald_fin); 
        redirect(base_url('inversion/'));

    }

// Traspasos *****
    function addtranspaso(){

        $result_datos_destino = $_POST['mcpagovim'];
        $separa_datos_destino = explode('|', $result_datos_destino);
        $id_destino = $separa_datos_destino[0];
        $saldo_destino = $separa_datos_destino[1];

        $tipo = "1";
        $descrip = "TRASPASOS INVERSIÓN";
        $respo = "AUTOMATICO";

        $data = array(
                'tra_cue_dest_id' => $id_destino,
                'tra_descripcion' => $descrip,
                'tra_responsable' => $respo,
                'saldoori' => $this->input->post('saldooripg'),
                'tra_monto' => $this->input->post('pagointvim'),
                'tra_cue_orig_id' => $this->input->post('idorigen'),
                'montoanterior' => $this->input->post('montoanterior'),
                'tipo' => $tipo,
                 );

        $fecha = date('Y-m-d');
        $tra_monto = $data['tra_monto'];
        $montoanterior = $data['montoanterior'];
    // Saldo anterior *****

    // Restar traspaso a origen *****
        $id_o = $data['tra_cue_orig_id'];
        $saldoori = $data['saldoori']; 
        $stuori = $saldoori + $montoanterior;
        $saldonuevoorigen = $stuori - $tra_monto;

    // Sumar traspaso a destino *****
        $id_d = $id_destino;
        $saldodest = $saldo_destino;
        $studes = $saldodest - $montoanterior;
        $saldonuevodestino = $studes + $tra_monto;

    // Envia datos a model    
        $this->inversion_model->nuevotraspaso($data,$fecha,$id_o,$id_d);
        $this->inversion_model->actualizarsaldoorigen($saldonuevoorigen,$id_o,$fecha);
        $this->inversion_model->actualizarsaldoinv($saldonuevoorigen,$id_o,$fecha);
        $this->inversion_model->actualizarsaldodestino($saldonuevodestino,$id_d,$fecha);

        redirect(base_url('inversion/'));

    }




}