<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Fletes_Gastos extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'fletes';
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('fletes',TRUE);
        $this->load->model('fletes/requerimiento_model','oRequerimiento');
        $this->template['titulo'] = 'Otros Gastos';
        $this->template['action'] = site_url('gastos/crear');
        $this->param = array(
            'cabecera' => array("Id", "Descripción", "Costo"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-pencil-square-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idrequerimiento'
        );
    }
	
	public function index()
	{
        $campos = $this->oRequerimiento->find('result',array( 
                'fields' => array('idrequerimiento','descripcion',"CONCAT('$',' ',FORMAT(costo,2))"),
                'conditions' => array('status' => 1),
                'order' => array( 'idrequerimiento' => 'ASC' )));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('gastos/crear', $this->param, 'unidades/delete');
        $this->template['action'] = site_url('gastos/crear');
        $this->_run('tabla_ver');		
	}

    public function crear() {
        try{
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $this->form_validation->set_rules('descripcion','<span style="color: #FF0000;">"DESCRIPCIÓN"</span>','trim|required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('gastos/crear');
            $datos = $this->oRequerimiento->find('list',array('conditions' => array( 'idrequerimiento' => $id )));
            $this->template['formulario'] = $this->_getForm(
                            'gastos/crear'.'/'.$id,
                            $this->oRequerimiento->schema,
                            $datos,
                            "Datos Requerimiento",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oRequerimiento->schema_up,
                            TRUE);

            if($this->form_validation->run()){
                $datos = elements($this->oRequerimiento->schema(),$this->input->post(NULL, TRUE));

                $datos['status'] = 1;
            
                $this->oRequerimiento->save($datos);

                $this->template['formulario'] = $this->_getForm(
                                'gastos/crear'.'/'.$id,
                                $this->oRequerimiento->schema,
                                $datos,
                                "Datos Requerimiento",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oRequerimiento->schema_up,
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
            $this->oRequerimiento->delete_t($id);
            $this->index();
        }
    }