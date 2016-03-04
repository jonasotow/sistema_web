<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Formulacion_admin extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'formulacion';
        $this->template['module'] = 'local';
        $this->template['back'] = 'admin';
        $dbBase = $this->load->database('formulacion',TRUE);
        $this->load->model('formulacion/admin_model','oAdmin');
        $this->load->model('formulacion/modelo_generico_model','oGenerico');
        $this->template['contador'] = $this->oGenerico->obtener_solicitudes_pendientes('Solicitud_lechero')+$this->oGenerico->obtener_solicitudes_pendientes('Solicitud_engorda');
        $this->param = array(
            'cabecera' => array("Id", "Ingrediente", "Clasificación","Especie","Modificar","Eliminar"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-pencil-square-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idIngrediente'
        );
    }
	
	public function index()
	{
        $this->template['titulo'] = 'Ingredientes';
        $campos = $this->oAdmin->find('result',array( 
                'fields' => array('Ingrediente.idIngrediente','Ingrediente.Ingrediente','Ingrediente.Clasificacion','Especie.Especie'),
                'join' => array(
                    'clause' => array(
                        'Especie' => 'Especie.idEspecie = Ingrediente.idEspecie'
                    ),
                    'type' => 'INNER'
                ),
                'conditions' => array('Ingrediente.Status' => 1),
                'order' => array( 'Ingrediente.idIngrediente' => 'ASC' )));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('admin/crear', $this->param, 'admin/delete');
        $this->template['action'] = site_url('admin/crear');
        $this->_run('tabla_ver');
	}

    public function crear() {
        try{
        $this->oAdmin->prepararForm();
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $this->form_validation->set_rules('Ingrediente','<span style="color: #FF0000;">"INGREDIENTE"</span>','trim|required');
        $this->form_validation->set_rules('Clasificacion','<span style="color: #FF0000;">"CLASIFICACION"</span>','trim|required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('admin/crear');
            $datos = $this->oAdmin->find('list',array('conditions' => array( 'idIngrediente' => $id )));
            $this->template['formulario'] = $this->_getForm(
                            'admin/crear'.'/'.$id,
                            $this->oAdmin->schema,
                            $datos,
                            "Datos Ingrediente",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oAdmin->schema_up,
                            TRUE);

            if($this->form_validation->run()){
                $datos = elements($this->oAdmin->schema(),$this->input->post(NULL, TRUE));
                $datos['Status'] = 1;
            
                $this->oAdmin->save($datos);

                $this->template['formulario'] = $this->_getForm(
                                'admin/crear'.'/'.$id,
                                $this->oAdmin->schema,
                                $datos,
                                "Datos Ingrediente",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oAdmin->schema_up,
                                TRUE);
            }

        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }  
        
        if($this->input->post('eliminar',TRUE) != NULL)
            $this->index();
        else
            $this->_run('crudn');
        }


        function delete() {
            $id = $this->uri->segment(3);
            $this->oAdmin->delete_t($id);
            $this->index();
        }
    }