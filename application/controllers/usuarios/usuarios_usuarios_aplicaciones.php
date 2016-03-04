<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Usuarios_usuarios_aplicaciones extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();

        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('usuarios/usuarios_aplicaciones_model','oUsuario_aplicacion');
        $this->load->model('usuarios/modelo_generico_model');
        $this->template['module'] = 'usuarios';
        $this->template['titulo'] = 'asuarios_aplicaciones';
        $this->param = array(
            'cabecera' => array("Id", "Id usuario", "Id aplicacion"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'usuapl_id'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oUsuario_aplicacion->find('result', array('fields' => array('usuapl_id','usuapl_usuario_id','usuapl_aplicacion_id'),'conditions' => array('usuapl_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('usuarios_aplicaciones/crear', $this->param, 'usuarios_aplicaciones/delete');
        $this->template['action'] = site_url('usuarios_aplicaciones/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oUsuario_aplicacion->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('usuapl_usuario_id','Id Usuario','trim|required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('usuarios_aplicaciones/crear');
                $datos = $this->oUsuario_aplicacion->find('list',array('conditions' => array( 'usuapl_id' => $id )));
                $this->template['formulario'] = $this->_getForm(
                                    'usuarios_aplicaciones/crear'.'/'.$id,
                                    $this->oUsuario_aplicacion->schema,
                                    $datos,
                                    "Usuario aplicacion",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oUsuario_aplicacion->schema_add);

            if($this->form_validation->run()){
                $datos = elements($this->oUsuario_aplicacion->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['usuapl_estatus'] = 0;
                    $this->template['formulario'] = $this->_getForm(
                                    'usuarios_aplicaciones/crear'.'/'.$id,
                                    $this->oUsuario_aplicacion->schema,
                                    $datos,
                                    "usuario aplicacion",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oUsuario_aplicacion->schema_add);
                    $this->oUsuario_aplicacion->save($datos);       
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
        $this->oUsuario_aplicacion->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_usuarios.php */
/* Location: ./application/controllers/usuarios/usuarios_usuarios.php */