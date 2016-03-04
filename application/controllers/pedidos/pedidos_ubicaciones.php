<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Pedidos_ubicaciones extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('pedidos', TRUE);
        $this->load->model('pedidos/ubicaciones_model','oUbicaciones');
        $this->load->model('pedidos/modelo_generico_model');
        $this->template['module'] = 'pedidos';
        $this->template['titulo'] = 'ubicaciones';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Ubicacion", "", ""),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'ubi_id_ubicacion'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oUbicaciones->find('result', array('fields' => array('ubi_id_ubicacion','ubi_nombre','ubi_direccion'),'conditions' => array('ubi_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('ubicaciones/crear', $this->param, 'ubicaciones/delete');
        $this->template['action'] = site_url('ubicaciones/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oUbicaciones->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('ubi_nombre','Ubicacion','trim|required');
            $this->form_validation->set_rules('ubi_direccion','Direccion','trim|required');
            $datos = '';
            if(is_numeric($id))
                $datos = $this->oUbicaciones->find('list',array('conditions' => array( 'ubi_id_ubicacion' => $id )));
            $this->template['action'] = site_url('ubicaciones/crear');    
            $this->template['formulario'] = $this->_getForm(
                                'ubicaciones/crear'.'/'.$id,
                                $this->oUbicaciones->schema,
                                $datos,
                                "Ubicacion",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oUbicaciones->schema_add,
                                TRUE);
            if($this->form_validation->run()){
                $datos = elements($this->oUbicaciones->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['ubi_estatus'] = 0;
                else
                    $datos['ubi_estatus'] = 1;
                $this->template['formulario'] = $this->_getForm(
                                'ubicaciones/crear'.'/'.$id,
                                $this->oUbicaciones->schema,
                                $datos,
                                "Ubicacion",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oUbicaciones->schema_add,
                                TRUE);
                $this->oUbicaciones->save($datos);   
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
        $this->oUbicaciones->delete_t($id);
        $this->index();
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */