<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Formulacion_Etapa extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'formulacion';
        $this->template['module'] = 'local';
        $this->template['back'] = 'etapa';
        $dbBase = $this->load->database('formulacion',TRUE);
        $this->load->model('formulacion/etapa_model','oEtapa');
        $this->load->model('formulacion/modelo_generico_model','oGenerico');
        $this->template['contador'] = $this->oGenerico->obtener_solicitudes_pendientes('Solicitud_lechero')+$this->oGenerico->obtener_solicitudes_pendientes('Solicitud_engorda');
        $this->param = array(
            'cabecera' => array("Id", "Etapa", "Descripcion","Rango","Subespecie","Modificar","Eliminar"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-pencil-square-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idEtapa'
        );
    }

    public function index()
    {
        $this->template['titulo'] = 'Etapas';
        $this->template['action'] = site_url('admin_etapa/crear');
        $campos = $this->oEtapa->find('result',array( 
                'fields' => array('Etapa.idEtapa','Etapa.Etapa','Detalle_etapa.Descripcion','Detalle_etapa.Rango','Subespecie.Subespecie'),
                'join' => array(
                    'clause' => array(
                        'Detalle_etapa' => 'Detalle_etapa.idEtapa = Etapa.idEtapa',
                        'Subespecie' => 'Subespecie.idSubespecie = Etapa.idSubespecie'
                    ),
                    'type' => 'INNER'
                ),
                'order' => array( 'Etapa.idEtapa' => 'ASC' )));
        $this->param   = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('etapa/crear', $this->param, 'etapa/delete');
        $this->template['action'] = site_url('etapa/crear');
        $this->_run('tabla_ver');
    }

    public function crear() {
        try{
        $this->oEtapa->prepararForm();
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('crear');
            $datos = $this->oEtapa->find('list',array('conditions' => array( 'idEtapa' => $id )));
            if($datos){
                $Descripcion = $this->oEtapa->get('Detalle_etapa','Descripcion',"idEtapa = $id");
                foreach($Descripcion as $row){
                    $datos['Descripcion'] = $row->Descripcion;
                }
            }
            
            $this->template['formulario'] = $this->_getForm(
                            'etapa/crear'.'/'.$id,
                            $this->oEtapa->schema,
                            $datos,
                            "Datos Etapa",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oEtapa->schema_up,
                            TRUE);

            if($this->form_validation->run()){
                $datos = elements($this->oEtapa->schema(),$this->input->post(NULL, TRUE));

                $datos['status'] = 1;
            
                $this->oEtapa->save($datos);

                $this->template['formulario'] = $this->_getForm(
                                'etapa/crear'.'/'.$id,
                                $this->oEtapa->schema,
                                $datos,
                                "Datos Etapa",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oEtapa->schema_up,
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
            $this->oEtapa->delete_t($id);
            $this->index();
        }
    }