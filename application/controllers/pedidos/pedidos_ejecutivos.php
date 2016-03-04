<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Pedidos_ejecutivos extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('pedidos', TRUE);
        $this->load->model('pedidos/ejecutivos_model','oEjecutivo');
        $this->load->model('pedidos/modelo_generico_model');
        $this->template['module'] = 'pedidos';
        $this->template['titulo'] = 'Ejecutivos';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Apellido paterno", "Apellido materno", "Planta", "Correo", "", ""),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'eje_id_ejecutivo'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oEjecutivo->find('result', array('fields' => array('eje_id_ejecutivo','eje_nombre','eje_apellido_paterno','eje_apellido_materno','eje_planta','eje_correo'),'conditions' => array('eje_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('ejecutivos/crear', $this->param, 'ejecutivos/delete');
        $this->template['action'] = site_url('ejecutivos/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
            $this->oEjecutivo->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('eje_nombre','Ejecutivo Nombre','trim|required');
            $this->form_validation->set_rules('eje_apellido_paterno','Descripcion','trim|required');
            $datos = '';
            if(is_numeric($id))
                $datos = $this->oEjecutivo->find('list',array('conditions' => array( 'eje_id_ejecutivo' => $id )));
            $this->template['action'] = site_url('ejecutivos/crear');    
            $this->template['formulario'] = $this->_getForm(
                                'ejecutivos/crear'.'/'.$id,
                                $this->oEjecutivo->schema,
                                $datos,
                                "Ejecutivo",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oEjecutivo->schema_add,
                                TRUE);
            if($this->form_validation->run()){
                $datos = elements($this->oEjecutivo->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['eje_estatus'] = 0;
                else
                    $datos['eje_estatus'] = 1;
                $this->template['formulario'] = $this->_getForm(
                                'ejecutivos/crear'.'/'.$id,
                                $this->oEjecutivo->schema,
                                $datos,
                                "Ejecutivo",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oEjecutivo->schema_add,
                                TRUE);
                $this->oEjecutivo->save($datos);   
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
        $this->oEjecutivo->delete_t($id);
        $this->index();
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */