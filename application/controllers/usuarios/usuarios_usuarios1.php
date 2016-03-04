<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Usuarios_usuarios1 extends MY_Controller {

    var $param;
    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();

        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('usuarios/usuarios_model','oUsuario',FALSE,'usuarios');
        $this->load->model('usuarios/aplicaciones_model','oAplicaciones',FALSE,'usuarios');
        $this->load->model('usuarios/roles_model','oRoles',FALSE,'usuarios');
        $this->template['module'] = 'usuarios';
        $this->template['titulo'] = 'usuarios1';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Apellido paterno", "Apelido materno", "Email", "Usuario","",""),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => 'fa fa-pencil-square-o fa-lg',
            'delete' => 'fa fa-times fa-lg',
            'url_campo' => 'usu_id'
        );
    } 

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oUsuario->find('result', array('fields' => array('usu_id','usu_nombre','usu_apellido_paterno','usu_apellido_materno','usu_email', 'usu_usuario'),'conditions' => array('usu_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('usuarios1/crear', $this->param, 'usuarios1/delete');
        $this->template['action'] = site_url('usuarios1/crear');
        $this->_run('tabla_ver');
    }

    public function crear() {
        try{
        //    $this->oUsuario->prepararForm();
            $this->template['controller_script'] = 'usuarios1/applications';
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('usu_nombre','Usuario Nombre','trim|required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('usuarios1/crear');
            $datos = $this->oUsuario->find('list',array('conditions' => array( 'usu_id' => $id )));
            $this->template['formulario'] = $this->_getForm(
                                'usuarios1/crear'.'/'.$id,
                                $this->oUsuario->schema,
                                $datos,
                                "Usuario",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                FALSE);
            if($this->form_validation->run()){
                $datos = elements($this->oUsuario->schema(),$this->input->post(NULL, TRUE));
                $datos['usu_password'] =  md5($datos['usu_password']);
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['usu_estatus'] = 0;
                else
                    $datos['usu_estatus'] = 1;
                    $this->template['formulario'] = $this->_getForm(
                                    'usuarios1/crear'.'/'.$id,
                                    $this->oUsuario->schema,
                                    $datos,
                                    "usuario",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    FALSE);
                    $this->oUsuario->save($datos);
                //    $this->oUsuario->save($datos);
                //    $this->oUsuario->save($datos);
            }
        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }
        if($this->input->post('eliminar',TRUE) != NULL)
            $this->index();
        else
            $this->_run('crud');
    }

    public function applications(){
        echo json_encode($this->oAplicaciones->show_applications());
    }

    public function roles(){
        echo json_encode($this->oRoles->show_roles());
    }

    public function delete() {
        $id = $this->uri->segment(3);
        $this->oUsuario->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_usuarios.php */
/* Location: ./application/controllers/usuarios/usuarios_usuarios.php */