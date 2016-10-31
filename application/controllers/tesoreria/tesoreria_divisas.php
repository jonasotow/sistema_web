<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Tesoreria_divisas extends MY_Controller {

    function __construct(){
        parent::__construct();
        $dbBase = $this->load->database('tesoreria',TRUE);
        $this->load->model('tesoreria/divisas_model');
        $this->load->helper('form');
        $this->template['module'] = 'tesoreria';
    }
    function index(){
        $this->template['title'] = 'Compra de divisas';
        $this->template['obtbanc'] = $this->divisas_model->obtbanc();
        $this->template['obtune'] = $this->divisas_model->obtune();
        $this->_run('divisas/add');
    }

    function transdivisas(){
        $this->template['title'] = 'Detalle de divisas';
        $this->template['trans'] = $this->divisas_model->mostrartrans();
        $this->_run('divisas/trans');
    }

    function obtcuentorig(){
        $divisa = $this->input->post('divisa');
        $une = $this->input->post('une');
        $this->template['obtcuentorig'] = $this->divisas_model->obtcuentorig($divisa, $une);  

    }    
    function obtcuentdest(){
        $divisa = $this->input->post('divisa');
        $une = $this->input->post('une');
        $this->template['obtcuentdest'] = $this->divisas_model->obtcuentdest($divisa, $une);  

    }
    function add(){

        $result_datos_destino_pago = $_POST['cuentapago'];
        $separa_datos_destino_pago = explode('|', $result_datos_destino_pago);
        $id_orig = $separa_datos_destino_pago[0];
        $saldo_orig = $separa_datos_destino_pago[1];

        $result_datos_destino_depo = $_POST['cuentadepo'];
        $separa_datos_destino_depo = explode('|', $result_datos_destino_depo);
        $id_dest = $separa_datos_destino_depo[0];
        $saldo_dest = $separa_datos_destino_depo[1];

        $fecha = date('Y-m-d');
        $descrip = "COMPRA DE DIVISAS";
        $respo = "AUTOMATICO";
        $tra_cue_orig = $id_orig;
        $tra_cue_dest = $id_dest;
        $tra_banco = $this->input->post('tra_banco');
        $tra_tipomov = $this->input->post('tra_tipomov');
        $tra_divisa = $this->input->post('tra_divisa');
        $tra_monto = $this->input->post('tra_monto');
        $tra_tc = $this->input->post('tra_tc');

       $data = array(
            'fecha' => $fecha,
            'descrip' => $descrip,
            'respo' => $respo,
            'tra_cue_orig' =>$tra_cue_orig,
            'tra_cue_dest' => $tra_cue_dest,
            'tra_banco' =>$tra_banco,
            'tra_tipomov' =>$tra_tipomov,
            'tra_divisa' => $tra_divisa,
            'tra_monto' => $tra_monto,
            'tra_tc' =>$tra_tc,);
       
       $dato = array(
            'fecha' => $fecha,
            'descrip' => "CONVERCION",
            'respo' => $respo,
            'tra_cue_orig' => $tra_cue_dest,
            'tra_cue_dest' => $tra_cue_orig,
            'tra_banco' =>$tra_banco,
            'tra_tipomov' =>$tra_tipomov,
            'tra_divisa' => $tra_divisa,
            'tra_monto' => $tra_monto,
            'tra_tc' =>$tra_tc,);

// Calculo de conversión de divisa
        $cdivisa = $tra_monto * $tra_tc;

//Nuevo saldos
        $nsaldodepo = $saldo_dest + $tra_monto;
        $nsaldopago = $saldo_orig - $cdivisa;
        $convdv = $tra_monto * $tra_tc;

        $this->divisas_model->compradivisas($data);
        $this->divisas_model->compradivisascv($dato,$convdv);
        $this->divisas_model->actsaldodepo($id_dest,$nsaldodepo,$fecha);
        $this->divisas_model->actsaldopago($id_orig,$nsaldopago,$fecha);
        redirect(base_url('divisas/completo'));
    }

    function deletedivisa(){

        $tra_cue_orig_id = $this->input->post('origen');
        $tra_cue_dest_id = $this->input->post('destino');
        $saldoctaorigen = $this->input->post('saldoctaorigen');
        $saldoctadestino = $this->input->post('saldoctadestino');
        $tra_monto = $this->input->post('tramonto');
        $tra_tc = $this->input->post('tratc');
        $tipo = "C";
        $fecha = date('Y-m-d');

        $id_dest = $tra_cue_orig_id;
        $id_orig = $tra_cue_dest_id;

        $cdivisa = $tra_monto * $tra_tc;
        $nsaldopago = $saldoctadestino - $tra_monto;
        $nsaldodepo = $saldoctaorigen + $cdivisa;
        $convdv = $tra_monto * $tra_tc;

        $this->divisas_model->deletetransdivisas($tra_cue_orig_id,$tra_cue_dest_id,$tipo,$fecha);
        $this->divisas_model->deletetransdivisasx($tra_cue_orig_id,$tra_cue_dest_id,$tipo,$fecha);
        $this->divisas_model->actsaldodepo($id_dest,$nsaldodepo,$fecha);
        $this->divisas_model->actsaldopago($id_orig,$nsaldopago,$fecha);
        redirect(base_url('divisas/transdivisas'));
    }

    function completo(){
        $this->_run('divisas/completo');
    }

    function editransdivisas(){

        $nconvx = $this->input->post('tramonton') * $this->input->post('tratcn');

        $data = array(
            'tra_cue_orig_id' => $this->input->post('origen'), 
            'tra_cue_dest_id' => $this->input->post('destino'),
            'saldoctaorigen' => $this->input->post('saldoctaorigen'),
            'saldoctadestino' => $this->input->post('saldoctadestino'),
            'tramonto' => $this->input->post('tramonto'),
            'tratc' => $this->input->post('tratc'),
            'tramonton' => $this->input->post('tramonton'),
            'tratcn' => $this->input->post('tratcn'),
            'nconv' => $nconvx,
            'tipo' => "C",
            'fecha' => date('Y-m-d'),
            );

        $fecha = date('Y-m-d');
        $id_orig = $data['tra_cue_orig_id'];
        $id_dest = $data['tra_cue_dest_id'];

        $tramonton = $data['tramonton'];
        $tratcn = $data['tratcn'];

        $tramonto = $data['tramonto'];
        $tratc = $data['tratc'];

        $conv = $tramonto * $tratc;
        $nconv = $tramonton * $tratcn;
        $nsaldodepo = $data['saldoctadestino'] - $tramonto + $tramonton;
        $nsaldopago = $data['saldoctaorigen'] + $conv - $nconv;


        $this->divisas_model->editransdivisas($data);
        $this->divisas_model->editransdivisasx($data);
        $this->divisas_model->actsaldodepo($id_dest,$nsaldodepo,$fecha);
        $this->divisas_model->actsaldopago($id_orig,$nsaldopago,$fecha);
        redirect(base_url('divisas/transdivisas'));
    }
}