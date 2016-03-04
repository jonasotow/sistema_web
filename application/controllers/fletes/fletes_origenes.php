<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Fletes_Origenes extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'fletes';
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('fletes',TRUE);
        $this->load->model('fletes/origen_model','oOrigen');
        $this->template['titulo'] = 'Origen';
        $this->template['action'] = site_url('origenes/crear');
        $this->param = array(
            'cabecera' => array("Id", "Descripcion", "Estado" , "Ciudad"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => true,
            'delete' => true,
            'url_campo' => 'idorigen'
        );
    }
	
	public function index()
	{
        $campos = $this->oOrigen->find('result',array( 
                'fields' => array('idorigen','origenes.descripcion as org','Estado.descripcion as est','ciudad.descripcion as ciu'),
                'join' => array(
                    'clause' => array(
                        'Estado' => 'Estado.idestado = origenes.idestado',
                        'ciudad' => 'ciudad.idciudad = origenes.idciudad'
                    ),
                    'type' => 'INNER'
                ),
                'conditions' => array('origenes.status' => 1),
                'order' => array( 'origenes.idorigen' => 'ASC' )));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('origenes/crear', $this->param, 'origenes/delete');
        $this->template['action'] = site_url('origenes/crear');
        $this->_run('tabla_ver');		
	}

    public function crear() {
        try{
        $this->oOrigen->prepararForm();
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('origenes/crear');
            $datos = $this->oOrigen->find('list',array('conditions' => array( 'idorigen' => $id )));
            $this->template['formulario'] = $this->_getForm(
                            'origenes/crear'.'/'.$id,
                            $this->oOrigen->schema,
                            $datos,
                            "Datos Origen",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oOrigen->schema_up,
                            TRUE);

            if($this->form_validation->run()){
                $datos = elements($this->oOrigen->schema(),$this->input->post(NULL, TRUE));

                $datos['status'] = 1;
            
                $this->oOrigen->save($datos);

                $this->template['formulario'] = $this->_getForm(
                                'origenes/crear'.'/'.$id,
                                $this->oOrigen->schema,
                                $datos,
                                "Datos Origen",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oOrigen->schema_up,
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
            $this->oOrigen->delete_t($id);
            $this->index();
        }
    }