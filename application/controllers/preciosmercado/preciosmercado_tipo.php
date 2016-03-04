<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Preciosmercado_Tipo extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'preciosmercado';
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('precios',TRUE);
        $this->load->model('preciosmercado/tipo_model','oTipo');
        $this->template['titulo'] = 'tipo';
        $this->template['action'] = site_url('tipo/crear');
        $this->param = array(
            'cabecera' => array("Id", "Tipo"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => true,
            'delete' => true,
            'url_campo' => 'idtipo'
        );
    }
	
	public function index()
	{
        $campos = $this->oTipo->find('result',array( 
                'fields' => array('idtipo','tipo'),
                'conditions' => array('tipo_status' => 1),
                'order' => array( 'idtipo' => 'ASC' )));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('tipo/crear', $this->param, 'tipo/delete');
        $this->template['action'] = site_url('tipo/crear');
        $this->_run('tabla_ver');		
	}

    public function crear() {
        try{
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $this->form_validation->set_rules('tipo','Tipo','trim|required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('tipo/crear');
            $datos = $this->oTipo->find('list',array('conditions' => array( 'idtipo' => $id )));
            $this->template['formulario'] = $this->_getForm(
                            'tipo/crear'.'/'.$id,
                            $this->oTipo->schema,
                            $datos,
                            "Datos Tipo",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oTipo->schema_up,
                            TRUE);

            if($this->form_validation->run()){
                $datos = elements($this->oTipo->schema(),$this->input->post(NULL, TRUE));

                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['tipo_status'] = 0;
                else
                    $datos['tipo_status'] = 1;
            
                $this->oTipo->save($datos);

                $this->template['formulario'] = $this->_getForm(
                                'tipo/crear'.'/'.$id,
                                $this->oTipo->schema,
                                $datos,
                                "Datos Tipo",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oTipo->schema_up,
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
            $this->oTipo->delete_t($id);
            $this->index();
        }
    }