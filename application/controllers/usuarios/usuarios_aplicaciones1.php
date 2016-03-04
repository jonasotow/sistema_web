<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Usuarios_aplicaciones1 extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();

        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('usuarios/aplicaciones_model','oAplicacion');
        $this->load->model('usuarios/modelo_generico_model');
        $this->template['module'] = 'usuarios';
        $this->template['titulo'] = 'aplicaciones';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Descripcion"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'apl_id'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oAplicacion->find('result', array('fields' => array('apl_id','apl_nombre','apl_descripcion'),'conditions' => array('apl_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('aplicaciones1/crear', $this->param, 'aplicaciones1/delete');
        $this->template['action'] = site_url('aplicaciones1/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oAplicacion->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('apl_nombre','Aplicacion Nombre','trim|required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('aplicaciones1/crear');
                $datos = $this->oAplicacion->find('list',array('conditions' => array( 'apl_id' => $id )));
                $this->template['formulario'] = $this->_getForm(
                                    'aplicaciones1/crear'.'/'.$id,
                                    $this->oAplicacion->schema,
                                    $datos,
                                    "Aplicacion",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oAplicacion->schema_add);

            if($this->form_validation->run()){
                $datos = elements($this->oAplicacion->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['apl_estatus'] = 0;
                    $this->template['formulario'] = $this->_getForm(
                                    'aplicaciones1/crear'.'/'.$id,
                                    $this->oAplicacion->schema,
                                    $datos,
                                    "Aplicacion",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oAplicacion->schema_add);
                    $this->oAplicacion->save($datos);       
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
        $this->oAplicacion->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_usuarios.php */
/* Location: ./application/controllers/usuarios/usuarios_usuarios.php */