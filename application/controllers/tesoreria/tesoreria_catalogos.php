<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Tesoreria_catalogos extends MY_Controller {

    function __construct(){
        parent::__construct();
        $dbBase = $this->load->database('tesoreria',TRUE);
        $this->load->model('tesoreria/tesoreria_model');
        $this->load->helper('form');
        $this->template['module'] = 'tesoreria';
    }
    function index(){
        $this->_run('catalogos/catalogos');
    }

// Catalogos de Bancos -->
    function bancos(){
        $this->template['title'] = 'Banco';
        $this->template['titles'] = 'Bancos';
        $this->template['segmento'] = $this->uri->segment(3);
        $this->template['id'] = $this->uri->segment(3);
        $this->template['ban'] = $this->tesoreria_model->obtenerBancos($this->template['id']);
        $this->_run('catalogos/bancos/addshow');
    }
    function editarBanco(){ 
        $this->template['title'] = 'Banco';
        $this->template['titles'] = 'Bancos';
        $this->template['id'] = $this->uri->segment(3);
        $this->template['banco'] = $this->tesoreria_model->obtenerBanco($this->template['id']);
        $this->_run('catalogos/bancos/editar');
    }
    function addbank(){
    	$data = array(
    		'nombre_bancos' => $this->input->post('nombre_bancos')
    	);
        $this->tesoreria_model->nuevoBanco($data);
        $this->template['ban'] = $this->tesoreria_model->obtenerBancos();
        redirect(base_url('catalogos/bancos'));
    }
    function updatebank (){
        $data = array(
            'nombre_bancos' => $this->input->post('nombre_bancos')
        );
        $this->template['ban'] = $this->tesoreria_model->actualizarBanco($this->uri->segment(3),$data);
        redirect(base_url('catalogos/bancos'));
    }
    function deletebank(){
        $id = $this->uri->segment(3);
        $this->tesoreria_model->deleteBanco($id);
        redirect(base_url('catalogos/bancos'));
    }

// Catalogos de Beneficiarios -->
    function beneficiarios(){
        $this->template['title'] = 'Beneficiario';        
        $this->template['titles'] = 'Beneficiarios';        
        $this->template['segmento'] = $this->uri->segment(3);
        if(!$this->template['segmento']){
            $this->template['ben'] = $this->tesoreria_model->obtenerBeneficiarios();
        }
        else{
            $this->template['ben'] = $this->tesoreria_model->obtenerBeneficiario($this->template['segmento']);
        }
        $this->template['id'] = $this->uri->segment(3);
        $this->template['beneficiario'] = $this->tesoreria_model->obtenerBeneficiario($this->template['id']);
        $this->_run('catalogos/beneficiario/addshow');
    }
    function editarBeneficiario(){
        $this->template['title'] = 'Beneficiarios';     
        $this->template['id'] = $this->uri->segment(3);
        $this->template['beneficiario'] = $this->tesoreria_model->obtenerBeneficiario($this->template['id']);
        $this->_run('catalogos/beneficiario/editar');
    }
    function addBeneficiario(){
        $data = array(
            'nombre_beneficiarios' => $this->input->post('nombre_beneficiarios')
        );
        $this->tesoreria_model->nuevoBeneficiario($data);
        $this->template['ben'] = $this->tesoreria_model->obtenerBeneficiarios();
        redirect(base_url('index.php/catalogos/beneficiarios'));
    }
    function updateBeneficiario(){
        $data = array(
            'nombre_beneficiarios' => $this->input->post('nombre_beneficiarios')
        );
        $this->template['ben'] = $this->tesoreria_model->actualizarBeneficiario($this->uri->segment(3),$data);
        redirect(base_url('index.php/catalogos/beneficiarios'));
    }
    function deleteBeneficiario(){
        $id = $this->uri->segment(3);
        $this->tesoreria_model->deleteBeneficiario($id);
        redirect(base_url('index.php/catalogos/beneficiarios'));
    }

// Catalogos de Unidad de Negocios -->
    function une(){
        $this->template['title'] = 'Unidad de Negocios';
        $this->template['titles'] = 'Unidades de Negocios';
        $this->template['segmento'] = $this->uri->segment(3);
        if(!$this->template['segmento']){
            $this->template['une'] = $this->tesoreria_model->obtenerUnidades();
        }
        else{
            $this->template['une'] = $this->tesoreria_model->obtenerUnidad($this->template['segmento']);
        }
        $this->template['id'] = $this->uri->segment(3);
        $this->template['unidad'] = $this->tesoreria_model->obtenerUnidad($this->template['id']);
        $this->_run('catalogos/unidades/addshow');
    }
    function editarunidad(){
        $this->template['title'] = 'Unidad de Negocios';
        $this->template['titles'] = 'Unidades de Negocios';
        $this->template['id'] = $this->uri->segment(3);
        $this->template['unidad'] = $this->tesoreria_model->obtenerUnidad($this->template['id']);
        $this->_run('catalogos/unidades/editar');
    }
    function addUnidad(){
        $data = array(
            'nombre_unidades' => $this->input->post('nombre_unidades')
        );
        $this->tesoreria_model->nuevoUnidad($data);
        $this->template['une'] = $this->tesoreria_model->obtenerUnidades();
        redirect(base_url('index.php/catalogos/une'));
    }
    function updateUnidad(){
        $data = array(
            'nombre_unidades' => $this->input->post('nombre_unidades')
        );
        $this->template['unidad'] = $this->tesoreria_model->actualizarUnidad($this->uri->segment(3),$data);
        redirect(base_url('index.php/catalogos/une'));
    }
    function deleteUnidad(){
        $id = $this->uri->segment(3);
        $this->tesoreria_model->deleteUnidad($id);
        redirect(base_url('index.php/catalogos/une'));
    }
    
// Catalogos de Lineas -->
    function lineas(){
        $this->template['title'] = 'Linea';
        $this->template['titles'] = 'Lineas';
        $this->template['ban'] = $this->tesoreria_model->obtenerBancos();
        $this->template['lin'] = $this->tesoreria_model->obtenerLineas();
        $this->template['linban'] = $this->tesoreria_model->obtenerLineasBancos();
        $this->_run('catalogos/lineas/addshow');
    }
    function editarLinea(){
        $this->template['title'] = 'Linea';
        $this->template['titles'] = 'Lineas';
        $this->template['id'] = $this->uri->segment(3);
        $this->template['ids'] = $this->uri->segment(3);
        $this->template['lin'] = $this->tesoreria_model->obtenerLinea($this->template['id']);
        $this->template['ban'] = $this->tesoreria_model->obtenerBancos();
        $this->template['linbans'] = $this->tesoreria_model->obtenerLineasBanco($this->template['ids']);
        $this->_run('catalogos/lineas/editar');
    }
    function addLinea(){
        $data = array(
            'lin_banco_id'=> $this->input->post('lin_banco_id'),
            'linea_descripcion' => $this->input->post('linea_descripcion'),
            'lin_autorizado' => $this->input->post('lin_autorizado'),
            'lin_disponible' => $this->input->post('lin_disponible'),
            'lin_es_largo_plazo' => $this->input->post('lin_es_largo_plazo')
        );
        $this->tesoreria_model->nuevoLinea($data);
        $this->template['lin'] = $this->tesoreria_model->obtenerLineas();
        redirect(base_url('index.php/catalogos/lineas'));
    }
    function deleteLinea(){
        $id = $this->uri->segment(3);
        $this->tesoreria_model->deleteLinea($id);
        redirect(base_url('index.php/catalogos/lineas'));
    }
    function updatelinea(){
        $data = array(
            'lin_banco_id'=> $this->input->post('lin_banco_id'),
            'linea_descripcion' => $this->input->post('linea_descripcion'),
            'lin_autorizado' => $this->input->post('lin_autorizado'),
            'lin_disponible' => $this->input->post('lin_disponible'),
            'lin_es_largo_plazo' => $this->input->post('lin_es_largo_plazo')
        );
        $this->template['lin'] = $this->tesoreria_model->actualizarLinea($this->uri->segment(3),$data);
        redirect(base_url('index.php/catalogos/lineas'));
    }

// Catalogos de Cuentas -->
    function cuentas(){
        $this->template['title'] = 'Cuenta';
        $this->template['titles'] = 'Cuentas';
        $this->template['ban'] = $this->tesoreria_model->obtenerBancos();
        $this->template['une'] = $this->tesoreria_model->obtenerUnidades();
        $this->template['ctabanune'] = $this->tesoreria_model->obtenerCuentasBancosUne();
        $this->template['contarcuentas'] = $this->tesoreria_model->contarcuentas();
        $this->_run('catalogos/cuentas/addshow');
    }
    function editarCuenta(){
        $this->template['titles'] = 'Cuentas';
        $this->template['id'] = $this->uri->segment(3);
        $this->template['ban'] = $this->tesoreria_model->obtenerBancos();
        $this->template['une'] = $this->tesoreria_model->obtenerUnidades();
        $this->template['ctabanune'] = $this->tesoreria_model->obtenerCuentasBancosUnes($this->uri->segment(3));
        $this->_run('catalogos/cuentas/editar');
    }
    function addCuenta(){
        $data = array(
            'cue_banco_id'=> $this->input->post('cue_banco_id'),
            'cue_uninegocio_id' => $this->input->post('cue_uninegocio_id'),
            'cue_numero' => $this->input->post('cue_numero'),
            'cue_nombre' => $this->input->post('cue_nombre'),
            'cue_descripcion' => $this->input->post('cue_descripcion'),
            'cue_divisa' => $this->input->post('cue_divisa'),
            'cue_es_inversion' => $this->input->post('cue_es_inversion')
        );

        $cids = $this->input->post('cids');
        $ncids = $cids + 1;
        $fecha = date('Y-m-d');

        $this->tesoreria_model->nuevoCuenta($data,$ncids);
        $this->tesoreria_model->nuevoCuentaCero($ncids,$fecha);
        $this->template['cta'] = $this->tesoreria_model->obtenerCuentas();
        redirect(base_url('index.php/catalogos/cuentas'));
    }
    function deleteCuenta(){
        $id = $this->uri->segment(3);
        $this->tesoreria_model->deleteCuenta($id);
        redirect(base_url('index.php/catalogos/cuentas'));
    }
    function updateCuenta(){
        $data = array(
            'cue_banco_id'=> $this->input->post('cue_banco_id'),
            'cue_uninegocio_id' => $this->input->post('cue_uninegocio_id'),
            'cue_numero' => $this->input->post('cue_numero'),
            'cue_nombre' => $this->input->post('cue_nombre'),
            'cue_descripcion' => $this->input->post('cue_descripcion'),
            'cue_divisa' => $this->input->post('cue_divisa'),
            'cue_es_inversion' => $this->input->post('cue_es_inversion')
        );
        $this->template['cta'] = $this->tesoreria_model->actualizarCuenta($this->uri->segment(3),$data);
        redirect(base_url('index.php/catalogos/cuentas'));
    }
}