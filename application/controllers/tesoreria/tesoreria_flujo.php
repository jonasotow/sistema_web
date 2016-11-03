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
        $this->template['une'] = $this->flujo_model->obtenerUnidades();
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
        $this->template['saldototalune_divisas'] = $this->flujo_model->saldototalune_divisas($id,$divisa);
        $this->template['saldototalune_pagov'] = $this->flujo_model->saldototalune_pagov($id,$divisa);
        $this->template['saldototalune_ts'] = $this->flujo_model->saldototalune_ts($id,$divisa);
        $this->template['obtenertodo'] = $this->flujo_model->obtenertodo($id,$divisa);
        $this->template['todo'] = $this->flujo_model->obtenertods();
        $this->template['une'] = $this->flujo_model->obtenerUnidad($id);
        $this->template['trapasosctaxcta'] = $this->flujo_model->trapasosctaxcta();
        $this->template['obtben'] = $this->flujo_model->obtBenef();
        $this->_run('flujo/data_flujo');
    }

    function updateFlujo(){
        $data = array(
            'cued_sald_ini'=> $this->input->post('cued_sald_ini'),
            'cued_cheq_circ' => $this->input->post('cued_cheq_circ'),
            'cued_cheques' => $this->input->post('cued_cheques'),
            'cued_depos_fir' => $this->input->post('cued_depos_fir'),
            'cued_sald_fin' => $this->input->post('cued_sald_fin')
            );

        $result_datos_destino = $_POST['cuentaretorn'];
        $separa_datos_destino = explode('|', $result_datos_destino);
        $id = $separa_datos_destino[0];
        $divisa = $separa_datos_destino[1];
        $idcuenta = $separa_datos_destino[2];

        $fecha = date('Y-m-d');
        $this->template['flujo'] = $this->flujo_model->actualizarFlujo($idcuenta,$data,$fecha);

  /* Regresar a flujo con datos
        $this->template['divisa'] = $divisa;
        $this->template['title'] = 'Flujo';
        $this->template['todo'] = $this->flujo_model->obtenertods();
        $this->template['saldototalune'] = $this->flujo_model->saldototalune($id,$divisa);
        $this->template['movcuebanune'] = $this->flujo_model->obtenermovcuebanunes($id,$divisa);
        $this->template['saldototalune_trapaso'] = $this->flujo_model->saldototalune_trapaso($id,$divisa);
        $this->template['saldototalune_divisas'] = $this->flujo_model->saldototalune_divisas($id,$divisa);
        $this->template['saldototalune_pagov'] = $this->flujo_model->saldototalune_pagov($id,$divisa);
        $this->template['saldototalune_ts'] = $this->flujo_model->saldototalune_ts($id,$divisa);
        $this->template['obtenertodo'] = $this->flujo_model->obtenertodo($id,$divisa);
        $this->template['une'] = $this->flujo_model->obtenerUnidad($id);
        $this->template['obtben'] = $this->flujo_model->obtBenef();*/
        redirect(base_url('flujo/'));
    }
    function editarflujo(){
            $this->template['title'] = 'Flujo';
            $this->template['id'] = $this->uri->segment(3);
            $this->template['todo'] = $this->flujo_model->obtenertods();
            $this->template['obtenercuentaune'] = $this->flujo_model->obtenercuentaune($this->template['id']);
            $this->template['obternertraspasoenflujoorigen'] = $this->flujo_model->obternertraspasoenflujoorigen($this->template['id']);
            $this->template['obternertraspasoenflujodestino'] = $this->flujo_model->obternertraspasoenflujodestino($this->template['id']);
            $this->_run('flujo/editarflujo');
        }
// Pagos vimifos
    function addpagovim(){

        $fecha = date('Y-m-d');
        $descrip = "PAGO VIMIFOS";
        $respo = "AUTOMATICO";
        $tipo = "0";
        $tip = "X";
        $id_o = $this->input->post('idorigen');
        $divisa = $this->input->post('divisa');
        $id = $this->input->post('uneid');
        $pagoanterior = $this->input->post('montoanteriorpg');

        $result_datos_destino = $_POST['mcpagovim'];
        $separa_datos_destino = explode('|', $result_datos_destino);
        $id_d = $separa_datos_destino[0];
        $saldo_destino = $separa_datos_destino[1];
        $pagos_lin = $separa_datos_destino[2];

        $data = array(
            'pagointvim' => $this->input->post('pagointvim'),
            'descrip' => $descrip,
            'respo' => $respo,
            'tipo' => $tipo,
            'saldooripg' => $this->input->post('saldooripg'),
            );

        $tra_monto = $data['pagointvim'];
// Pagos
        $saldodepagos = $tra_monto;

// Restar traspaso a origen *****
        $saldoori = $data['saldooripg']; 
        $stuori = $saldoori + $pagoanterior;
        $saldonuevoorigen = $stuori - $tra_monto;

// Sumar traspaso a destino *****
        $saldodest = $saldo_destino;
        $studes = $saldodest - $pagoanterior;
        $saldonuevodestino = $studes + $tra_monto;

// Envia datos a model    
        $this->flujo_model->nuevopagovim($id_d,$id_o,$fecha,$data,$tipo);
        $this->flujo_model->nuevopagovimp($id_d,$id_o,$fecha,$data,$tip);
        $this->flujo_model->grabrarnvosalpagoslin($id_d,$fecha,$saldodepagos);
        $this->flujo_model->actualizarsaldoorigenpgo($saldonuevoorigen,$id_o,$fecha);
        $this->flujo_model->actualizarsaldodestinopgo($saldonuevodestino,$id_d,$fecha);

  // Regresar a flujo con datos
        $this->template['title'] = 'Flujo';
        $this->template['divisa'] = $divisa;
        $this->template['todo'] = $this->flujo_model->obtenertods();
        $this->template['saldototalune'] = $this->flujo_model->saldototalune($id,$divisa);
        $this->template['movcuebanune'] = $this->flujo_model->obtenermovcuebanunes($id,$divisa);
        $this->template['saldototalune_trapaso'] = $this->flujo_model->saldototalune_trapaso($id,$divisa);
        $this->template['saldototalune_divisas'] = $this->flujo_model->saldototalune_divisas($id,$divisa);
        $this->template['saldototalune_pagov'] = $this->flujo_model->saldototalune_pagov($id,$divisa);
        $this->template['saldototalune_ts'] = $this->flujo_model->saldototalune_ts($id,$divisa);
        $this->template['obtenertodo'] = $this->flujo_model->obtenertodo($id,$divisa);
        $this->template['une'] = $this->flujo_model->obtenerUnidad($id);
        $this->template['obtben'] = $this->flujo_model->obtBenef();
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
        $tipo = "1";
        $tipos = "S";

        $data = array(
                'tra_cue_orig_id' => $this->input->post('tra_cue_orig_id'),
                'tra_cue_dest_id' => $id_destino,
                'tra_monto' => $this->input->post('tra_monto'),
                'tra_descripcion' => $this->input->post('tra_descripcion'),
                'saldoori' => $this->input->post('saldoori'),
                'tra_responsable' => $this->input->post('tra_responsable'),
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
        $this->flujo_model->nuevotraspaso($data,$fecha,$id_o,$id_d,$tipo);
        $this->flujo_model->nuevotraspasosl($data,$fecha,$id_o,$id_d,$tipos);
        $this->flujo_model->actualizarsaldoorigen($saldonuevoorigen,$id_o,$fecha);
        $this->flujo_model->actualizarsaldodestino($saldonuevodestino,$id_d,$fecha);

    // Regresar a flujo con datos
        $this->template['title'] = 'Flujo';
        $this->template['divisa'] = $divisa;
        $this->template['todo'] = $this->flujo_model->obtenertods();
        $this->template['saldototalune'] = $this->flujo_model->saldototalune($id,$divisa);
        $this->template['movcuebanune'] = $this->flujo_model->obtenermovcuebanunes($id,$divisa);
        $this->template['saldototalune_trapaso'] = $this->flujo_model->saldototalune_trapaso($id,$divisa);
        $this->template['saldototalune_divisas'] = $this->flujo_model->saldototalune_divisas($id,$divisa);
        $this->template['saldototalune_pagov'] = $this->flujo_model->saldototalune_pagov($id,$divisa);
        $this->template['saldototalune_ts'] = $this->flujo_model->saldototalune_ts($id,$divisa);
        $this->template['obtenertodo'] = $this->flujo_model->obtenertodo($id,$divisa);
        $this->template['une'] = $this->flujo_model->obtenerUnidad($id);
        $this->template['obtben'] = $this->flujo_model->obtBenef();
        $this->_run('flujo/data_flujo');

    }
    // Recibe datos por JavaScript
    function montopago(){
        $id_origen = $this->input->post('id_destino');
        $id_destino = $this->input->post('id_origen');
        $fecha = date('Y-m-d');
        $tipo = "X";
        $this->template['montodetrshtml'] = $this->flujo_model->montodetrshtml($id_origen,$id_destino,$fecha,$tipo);  
    }  
    function montopagoval(){
        $id_origen = $this->input->post('id_destino');
        $id_destino = $this->input->post('id_origen');
        $fecha = date('Y-m-d');
        $tipo = "X";
        $this->template['montodetrsval'] = $this->flujo_model->montodetrsval($id_origen,$id_destino,$fecha,$tipo);  
    }

    function montotraspaso(){
        $id_origen = $this->input->post('id_origen');
        $id_destino = $this->input->post('id_destino');
        $fecha = date('Y-m-d');
        $tipo = "1";
        $this->template['montodetrshtml'] = $this->flujo_model->montodetrshtml($id_origen,$id_destino,$fecha,$tipo);  
    }  
    function montotraspasoval(){
        $id_origen = $this->input->post('id_origen');
        $id_destino = $this->input->post('id_destino');
        $fecha = date('Y-m-d');
        $tipo = "1";
        $this->template['montodetrsval'] = $this->flujo_model->montodetrsval($id_origen,$id_destino,$fecha,$tipo);  
    }

    function mcpagovim(){
        $idune = $this->input->post('idune');
        $divisa = $this->input->post('divisa');
        $cueogin = $this->input->post('cueogin');
        $this->template['mcpagovim'] = $this->flujo_model->mcpagovim($idune, $cueogin, $divisa);  
    }
    function obtbnf(){
        $this->template['obtben'] = $this->flujo_model->obtBenefsql();

    }
    function ctaft(){
        $idune = $this->input->post('une');
        $divisa = $this->input->post('divisa');
        $cueogin = $this->input->post('ctaorig');
        $this->template['mcpagovim'] = $this->flujo_model->mcpagovim($idune, $cueogin, $divisa);  

    }

    function pagobendls(){
        $this->template['title'] = 'Pago a Beneficiarios';
        $this->template['obtben'] = $this->flujo_model->obtBenef();
        $this->template['movcuebanune'] = $this->flujo_model->ctatotal();
        $this->template['une'] = $this->flujo_model->obtenerUnidades();
        $this->_run('flujo/pagobendls');
    }

    function pagob(){
        $result_datos_destino = $_POST['cuentapago'];
        $separa_datos_destino = explode('|', $result_datos_destino);
        $id_destino = $separa_datos_destino[0];
        $saldo_total = $separa_datos_destino[1];
        $saldo_pago = $separa_datos_destino[2];

        $ben = $this->input->post('ben');
        $monto = $this->input->post('tra_monto');
        $cuentapago = $id_destino;
        $saldonuevo = $saldo_total - $monto;
        $fecha = date('Y-m-d');
        $nsaldopago = $saldo_pago  -($monto);

        $this->template['pagoben'] = $this->flujo_model->pagoben($ben,$monto,$cuentapago,$fecha);        
        $this->template['mpagoben'] = $this->flujo_model->mpagoben($nsaldopago,$cuentapago, $fecha,$saldonuevo);
        redirect(base_url('flujo/completo'));
    }

    function completo(){
        $this->_run('flujo/completo');
    }

    function obtcta(){
        $divisa = $this->input->post('divisa');
        $une = $this->input->post('une');
        $this->template['obtcta'] = $this->flujo_model->obtcta($divisa, $une);  

    }  


}

 /*     Envio de correo       
        $cuenta = strtoupper($datos['datoscuenta']);
        $usuario = strtoupper($datos['usuario']);
        $this->template['usuario'] = $datos['usuario'];
        $this->load->library('email');
        $this->email->from('web@vimifos.com', 'Notificaciones Vimifos - SIT');
        $this->email->to('jsoto@vimifos.com');
        $this->email->subject('SE CAPTURO O MODIFICO EL SALDO DE UNA CUENTA '.$usuario);
        $this->email->message('LA CUENTA '.$cuenta .' SE CAPTURO O MODIFICADA POR '.$usuario);
        $this->email->send();
 */  