<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Formulacion_Formuladores extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'formulacion';
        $this->template['module'] = 'local';
        $this->template['back'] = 'formuladores';
        $dbBase = $this->load->database('formulacion',TRUE);
        $this->load->model('formulacion/formuladores_model','oFormuladores');
        $this->load->model('formulacion/modelo_generico_model','oGenerico');
        $this->template['contador'] = $this->oGenerico->obtener_solicitudes_pendientes('Solicitud_lechero')+$this->oGenerico->obtener_solicitudes_pendientes('Solicitud_engorda');
        $this->param = array(
            'cabecera' => array("Id", "Formulador", "Correo","Especie","Status","Modificar","Eliminar"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-pencil-square-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idformulador'
        );
    }
	
	public function index()
	{
        $this->template['titulo'] = 'Formuladores';
        $campos = $this->oFormuladores->find('result',array( 
                'fields' => array('Formulador.idformulador','Formulador.Formulador','Formulador.Correo','Especie.Especie','IF(Formulador.Status = "1","ACTIVO","INACTIVO")'),
                'join' => array(
                    'clause' => array(
                        'Especie' => 'Especie.idEspecie = Formulador.idEspecie'
                    ),
                    'type' => 'INNER'
                ),
                'conditions' => array('Formulador.Status' => 1),
                'order' => array( 'Formulador.idformulador' => 'ASC' )));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('formuladores/crear', $this->param, 'formuladores/delete');
        $this->template['action'] = site_url('formuladores/crear');
        $this->_run('tabla_ver');
	}

    public function crear() {
        try{
        $this->oFormuladores->prepararForm();
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $this->form_validation->set_rules('Formulador','<span style="color: #FF0000;">"FORMULADOR"</span>','trim|required');
        $this->form_validation->set_rules('Correo','<span style="color: #FF0000;">"CORREO"</span>','trim|required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('formuladores/crear');
            $datos = $this->oFormuladores->find('list',array('conditions' => array( 'idformulador' => $id )));
            $this->template['formulario'] = $this->_getForm(
                            'formuladores/crear'.'/'.$id,
                            $this->oFormuladores->schema,
                            $datos,
                            "Datos Formulador",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oFormuladores->schema_up,
                            TRUE);

            if($this->form_validation->run()){
                $datos = elements($this->oFormuladores->schema(),$this->input->post(NULL, TRUE));
                $datos['Status'] = 1;
            
                $this->oFormuladores->save($datos);

                $this->template['formulario'] = $this->_getForm(
                                'admin/crear'.'/'.$id,
                                $this->oFormuladores->schema,
                                $datos,
                                "Datos Formulador",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oFormuladores->schema_up,
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
            $this->oFormuladores->delete_t($id);
            $this->index();
        }
    }