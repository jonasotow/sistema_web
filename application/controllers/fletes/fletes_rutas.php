<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * fletes_rutas.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Fletes_Rutas extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'fletes';
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('fletes',TRUE);
        $this->load->model('fletes/rutas_model','oRutas');
        $this->template['titulo'] = 'Rutas';
        $this->template['action'] = site_url('rutas/crear');
        $this->param = array(
            'cabecera' => array("Id", "Ruta", "Tipo Unidad"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-pencil-square-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idruta'
        );
        $this->param2 = array(
            'cabecera' => array("Id", "Posición","Estado", "Ciudad","Costo","Tipo Movimiento"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            /*'edit' => "fa fa-pencil-square-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",*/
            'url_campo' => 'iddetalle_ruta'
        );
    }
	
	public function index()
	{
        $campos = $this->oRutas->find('result',array( 
                'fields' => array('rutas.idruta', 'rutas.descripcion as rut', 'unidad.descripcion as uni'),
                'join' => array(
                    'clause' => array(
                        'unidad' => 'unidad.idunidad = rutas.idunidad',
                    ),
                    'type' => 'INNER'
                ),
                'conditions' => array('rutas.status' => 1),
                'order' => array( 'rutas.idruta' => 'ASC' )));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('ver/crear', $this->param, 'rutas/delete');
        $this->template['action'] = site_url('rutas/ver');
        $this->_run('tabla_ver');		
	}

    public function ver()
    {
        $campos = $this->oRutas->find('result',array( 
                'fields' => array('detalle_ruta.iddetalle_ruta','detalle_ruta.posicion','Estado.descripcion as estado','ciudad.descripcion as ciudad','detalle_ruta.monto','detalle_ruta.traslado'),
                'join' => array(
                    'clause' => array(
                        'detalle_ruta' => 'detalle_ruta.idruta = rutas.idruta',
                        'Estado' => 'Estado.idestado = detalle_ruta.idestado',
                        'ciudad' => 'ciudad.idciudad = detalle_ruta.idciudad'
                    ),
                    'type' => 'INNER'
                ),
                'conditions' => array('detalle_ruta.idruta' => $this->uri->segment(3)),
                'order' => array( 'rutas.idruta' => 'ASC' )));
        $this->param2 = array_merge($this->param2, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('rutas/crear', $this->param2, 'rutas/delete');
        $this->template['action'] = site_url('rutas/crear');
        $this->_run('tabla_ver');       
    }

    public function crear(){

        $idunidad = $this->oRutas->list_generic('unidad');
        $idestado = $this->oRutas->list_generic('Estado');
        $idciudad = $this->oRutas->list_generic('ciudad');

        $unidad = "<option value='0'>Seleccione una Unidad</option>";
        foreach($idunidad as $rows){
            $unidad .= "<option value=".$rows->idunidad.">".$rows->descripcion."</option>";
        }
        $estado = "<option value='0'>Seleccione un Estado</option>";
        foreach($idestado as $rows){
            $estado .= "<option value=".$rows->idestado.">".$rows->descripcion."</option>";
        }
        $ciudad = "<option value='0'>Seleccione un Ciudad</option>";
        foreach($idciudad as $rows){
            $ciudad .= "<option value=".$rows->idciudad.">".$rows->descripcion."</option>";
        }
            $this->template['idunidad'] = $unidad;
            $this->template['idestado'] = $estado;
            $this->template['idciudad'] = $ciudad;
            json_encode($ciudad);
            json_encode($estado);
            $this->_run('rutas');
    }

    public function crear_ruta(){
        $this->oRutas->guardar_ruta();
        redirect("rutas");
    }

    function delete() {
            $id = $this->uri->segment(3);
            $this->oRutas->delete_t($id);
            $this->index();
        }
    }