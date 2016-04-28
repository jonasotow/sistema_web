<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Tesoreria_flujo extends MY_Controller {

    function __construct(){
        parent::__construct();
        $dbBase = $this->load->database('tesoreria',TRUE);
        $this->load->model('tesoreria/flujo_model');
        $this->load->helper('form');
        $this->template['module'] = 'tesoreria';
    }
    function index(){
	    $this->template['title'] = 'Flujo';
        $this->template['id'] = $this->uri->segment(3);
        if(!$this->template['id']){
            $this->template['une'] = $this->flujo_model->obtenerUnidades();
        }
        else{
            $this->template['une'] = $this->flujo_model->flujoindex($this->template['id']);
        }

        $this->template['contadorflujo'] = $this->flujo_model->contadorflujo();
        if($this->template['contadorflujo'] > 0){
            $this->template['datos'] = 'Datos';
        }
        else{
            $this->template['datos'] = 'Cero';
            $obtenercuentasflujo = $this->flujo_model->obtenercuentasflujo();
                foreach ($obtenercuentasflujo as $cuentas) {
                $data =  array(
                    'cued_id' => $cuentas->cue_id,
                    );
                $fecha = date('Y-m-d');    
                $this->template['agregarsaldoencero'] = $this->flujo_model->agregarsaldoencero($fecha,$data);
            }
        }
        $this->_run('flujo/home');
    }

// Flujo *****
    function data(){
        $datos = array(
            'id' => $this->input->post('cue_uninegocio_id'),
            'divisa' => $this->input->post('cue_divisa')
        );
        $id = $datos['id'];
        $divisa = $datos['divisa'];
        $this->template['divisa'] = $divisa;
        $this->template['title'] = 'Flujo';
        $this->template['movcuebanune'] = $this->flujo_model->obtenermovcuebanunes($id,$divisa);
        $this->template['saldototalune'] = $this->flujo_model->saldototalune($id,$divisa);
        $this->template['saldototalune_trapaso'] = $this->flujo_model->saldototalune_trapaso($id,$divisa);
        $this->template['obtenertodo'] = $this->flujo_model->obtenertodo($id,$divisa);
        $this->template['todo'] = $this->flujo_model->obtenertods();
        $this->template['une'] = $this->flujo_model->obtenerUnidad($id);
        $this->_run('flujo/data_flujo');
    }


    function editarflujo(){
        $this->template['title'] = 'Flujo';
        $this->template['id'] = $this->uri->segment(3);
        $this->template['obtenercuentaune'] = $this->flujo_model->obtenercuentaune($this->template['id']);
        $this->template['obternertraspasoenflujoorigen'] = $this->flujo_model->obternertraspasoenflujoorigen($this->template['id']);
        $this->template['obternertraspasoenflujodestino'] = $this->flujo_model->obternertraspasoenflujodestino($this->template['id']);
        $this->_run('flujo/editarflujo');
    }
    function updateFlujo(){
        $data = array(
            'cued_sald_ini'=> $this->input->post('cued_sald_ini'),
            'cued_cheq_circ' => $this->input->post('cued_cheq_circ'),
            'cued_cheques' => $this->input->post('cued_cheques'),
            'cued_pagos_lin' => $this->input->post('cued_pagos_lin'),
            'cued_depos_fir' => $this->input->post('cued_depos_fir'),
            'cued_depos_24h' => $this->input->post('cued_depos_24h'),
            'cued_sald_fin' => $this->input->post('cued_sald_fin')
        );

        $datos = array(
                'usuario'=> $this->input->post('usuario'),
                'datoscuenta'=> $this->input->post('datoscuenta')
        );

 //     Envio de correo       
        $cuenta = strtoupper($datos['datoscuenta']);
        $usuario = strtoupper($datos['usuario']);
        $this->template['usuario'] = $datos['usuario'];
        $this->load->library('email');
        $this->email->from('web@vimifos.com', 'Notificaciones Vimifos - SIT');
        $this->email->to('jsoto@vimifos.com');
        $this->email->subject('SE CAPTURO O MODIFICO EL SALDO DE UNA CUENTA '.$usuario);
        $this->email->message('LA CUENTA '.$cuenta .' SE CAPTURO O MODIFICADA POR '.$usuario);
        $this->email->send();
 //     Envio de correo       

        $fecha = date('Y-m-d');
        $this->template['id'] = $this->uri->segment(3);
        $this->template['flujo'] = $this->flujo_model->actualizarFlujo($this->template['id'],$data,$fecha);
        redirect(base_url('index.php/flujo/'));
    }

// Pagos vimifos
    function addpagovim(){

        $fecha = date('Y-m-d');
        $descrip = "PAGO VIMIFOS";
        $respo = "AUTOMATICO";
        $tipo = "0";
        $id_o = $this->input->post('idorigen');
        $divisa = $this->input->post('divisa');
        $id = $this->input->post('uneid');

        $result_datos_destino = $_POST['mcpagovim'];
        $separa_datos_destino = explode('|', $result_datos_destino);
        $id_d = $separa_datos_destino[0];


        $data = array(
            'pagointvim' => $this->input->post('pagointvim'),
            'descrip' => $descrip,
            'respo' => $respo,
            'tipo' => $tipo,
            );

    // Envia datos a model    
        $this->flujo_model->nuevopagovim($id_d,$id_o,$fecha,$data);


  // Regresar a flujo con datos
        $this->template['title'] = 'Flujo';
        $this->template['divisa'] = $divisa;
        $this->template['saldototalune'] = $this->flujo_model->saldototalune($id,$divisa);
        $this->template['movcuebanune'] = $this->flujo_model->obtenermovcuebanunes($id,$divisa);
        $this->template['saldototalune_trapaso'] = $this->flujo_model->saldototalune_trapaso($id,$divisa);
        $this->template['obtenertodo'] = $this->flujo_model->obtenertodo($id,$divisa);
        $this->template['une'] = $this->flujo_model->obtenerUnidad($id);
        $this->_run('flujo/data_flujo');


    }


// Traspasos *****
    function addtranspaso(){

        $result_datos_destino = $_POST['datos_destino'];
        $separa_datos_destino = explode('|', $result_datos_destino);
        $id_destino = $separa_datos_destino[0];
        $saldo_destino = $separa_datos_destino[1];
        $divisa = $separa_datos_destino[2];
        $id = $separa_datos_destino[3];

        $data = array(
                'tra_cue_orig_id' => $this->input->post('tra_cue_orig_id'),
                'tra_cue_dest_id' => $id_destino,
                'tra_monto' => $this->input->post('tra_monto'),
                'tra_descripcion' => $this->input->post('tra_descripcion'),
                'saldoori' => $this->input->post('saldoori'),
                'tra_responsable' => $this->input->post('tra_responsable'),
                'montoanterior' => $this->input->post('montoanterior'),
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
        $this->flujo_model->nuevotraspaso($data,$fecha,$id_o,$id_d);
        $this->flujo_model->actualizarsaldoorigen($saldonuevoorigen,$id_o,$fecha);
        $this->flujo_model->actualizarsaldodestino($saldonuevodestino,$id_d,$fecha);

    // Regresar a flujo con datos
        $this->template['title'] = 'Flujo';
        $this->template['divisa'] = $divisa;
        $this->template['saldototalune'] = $this->flujo_model->saldototalune($id,$divisa);
        $this->template['movcuebanune'] = $this->flujo_model->obtenermovcuebanunes($id,$divisa);
        $this->template['saldototalune_trapaso'] = $this->flujo_model->saldototalune_trapaso($id,$divisa);
        $this->template['obtenertodo'] = $this->flujo_model->obtenertodo($id,$divisa);
        $this->template['une'] = $this->flujo_model->obtenerUnidad($id);
        $this->_run('flujo/data_flujo');

    }
    // Recibe datos por JavaScript
    function montotraspaso(){
        $id_origen = $this->input->post('id_origen');
        $id_destino = $this->input->post('id_destino');
        $fecha = date('Y-m-d');
     
        $this->template['montodetrshtml'] = $this->flujo_model->montodetrshtml($id_origen,$id_destino,$fecha);  
    }  
    function montotraspasoval(){
        $id_origen = $this->input->post('id_origen');
        $id_destino = $this->input->post('id_destino');
        $fecha = date('Y-m-d');
        $this->template['montodetrsval'] = $this->flujo_model->montodetrsval($id_origen,$id_destino,$fecha);  
    
    }

    function mcpagovim(){
        $idune = $this->input->post('idune');
        $divisa = $this->input->post('divisa');
        $this->template['mcpagovim'] = $this->flujo_model->mcpagovim($idune, $divisa);  

    }


}