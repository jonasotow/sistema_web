<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Fletes_Unidades extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'fletes';
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('fletes',TRUE);
        $this->load->model('fletes/unidad_model','oUnidad');
        $this->template['titulo'] = 'Unidades';
        $this->template['action'] = site_url('unidades/crear');
        $this->param = array(
            'cabecera' => array("Id", "Tipo de Unidad", "Capacidad en Ton.","Capacidad en Tarimas"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-pencil-square-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idunidad'
        );
    }
	
	public function index()
	{
        $campos = $this->oUnidad->find('result',array( 
                'fields' => array('idunidad','descripcion','capacidad','tarimas'),
                'conditions' => array('status' => 1),
                'order' => array( 'idunidad' => 'ASC' )));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('unidades/crear', $this->param, 'unidades/delete');
        $this->template['action'] = site_url('unidades/crear');
        $this->_run('tabla_ver');		
	}

    public function crear() {
        try{
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $this->form_validation->set_rules('descripcion','<span style="color: #FF0000;">"DESCRIPCIÓN"</span>','trim|required');
        $this->form_validation->set_rules('capacidad','<span style="color: #FF0000;">"CAPACIDAD EN KG"</span>','trim|required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('unidades/crear');
            $datos = $this->oUnidad->find('list',array('conditions' => array( 'idunidad' => $id )));
            $this->template['formulario'] = $this->_getForm(
                            'unidades/crear'.'/'.$id,
                            $this->oUnidad->schema,
                            $datos,
                            "Datos Unidad",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oUnidad->schema_up,
                            TRUE);

            if($this->form_validation->run()){
                $datos = elements($this->oUnidad->schema(),$this->input->post(NULL, TRUE));

                $datos['status'] = 1;
            
                $this->oUnidad->save($datos);

                $this->template['formulario'] = $this->_getForm(
                                'unidad/crear'.'/'.$id,
                                $this->oUnidad->schema,
                                $datos,
                                "Datos Unidad",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oUnidad->schema_up,
                                TRUE);
            }

        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }  
        
        if($this->input->post('eliminar',TRUE) != NULL)
            $this->index();
        else
            $this->_run('crud');
        }

        function delete() {
            $id = $this->uri->segment(3);
            $this->oUnidad->delete_t($id);
            $this->index();
        }
    }