<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Formulacion_Micro extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'formulacion';
        $this->template['module'] = 'local';
        $this->template['back'] = 'micro';
        $dbBase = $this->load->database('formulacion',TRUE);
        $this->load->model('formulacion/micro_model','oMicro');
        $this->load->model('formulacion/modelo_generico_model','oGenerico');
        $this->template['contador'] = $this->oGenerico->obtener_solicitudes_pendientes('Solicitud_lechero')+$this->oGenerico->obtener_solicitudes_pendientes('Solicitud_engorda');
        $this->param = array(
            'cabecera' => array("Id", "Micro", "Descripcion","Subespecie","Modificar","Eliminar"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-pencil-square-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idProducto'
        );
    }
	
	public function index()
	{
        $this->template['titulo'] = 'Micro';
        $campos = $this->oMicro->find('result',array( 
                'fields' => array('Producto.idProducto','Producto.Producto','Producto.Descripcion','CONCAT(Etapa.Etapa,"->",Subespecie.Subespecie)'),
                'join' => array(
                    'clause' => array(
                        'Etapa' => 'Etapa.idEtapa = Producto.idEtapa',
                        'Subespecie' => 'Etapa.idSubespecie = Subespecie.idSubespecie'
                    ),
                    'type' => 'INNER'
                ),
                'conditions' => array('Producto.Status' => 1),
                'order' => array( 'Producto.idProducto' => 'ASC' )));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('micro/crear', $this->param, 'micro/delete');
        $this->template['action'] = site_url('micro/crear');
        $this->_run('tabla_ver');
	}

    public function crear() {
        try{
        $this->oMicro->prepararForm();
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $this->form_validation->set_rules('Producto','<span style="color: #FF0000;">"PRODUCTO"</span>','trim|required');
        $this->form_validation->set_rules('Descripcion','<span style="color: #FF0000;">"DESCRIPCION"</span>','trim|required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('micro/crear');
            $datos = $this->oMicro->find('list',array('conditions' => array( 'idProducto' => $id )));
            $this->template['formulario'] = $this->_getForm(
                            'micro/crear'.'/'.$id,
                            $this->oMicro->schema,
                            $datos,
                            "Micro",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oMicro->schema_up,
                            TRUE);

            if($this->form_validation->run()){
                $datos = elements($this->oMicro->schema(),$this->input->post(NULL, TRUE));
                $datos['Status'] = 1;
            
                $this->oMicro->save($datos);

                $this->template['formulario'] = $this->_getForm(
                                'micro/crear'.'/'.$id,
                                $this->oMicro->schema,
                                $datos,
                                "Micro",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oMicro->schema_up,
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
            $this->oMicro->delete_t($id);
            $this->index();
        }
    }