<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Agendatecnicos_usuariost extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();

        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('agendatecnicos/usuarios_model','oUsuario');
        $this->load->model('agendatecnicos/modelo_generico_model');
        $this->template['module'] = 'agenda';
        $this->template['titulo'] = '';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Apellido paterno", "Apelido materno", "Email", "Usuario"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'usu_id'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() { 

        $id_relacion = $this->session->userdata('logged_user')->usu_id;

        $campos = $this->oUsuario->find('result',array( 
            'fields' => array('usu_id','usu_nombre','usu_apellido_paterno','usu_apellido_materno','usu_email', 'usu_usuario'),
            'join' => array(
                'clause' => array('usutip_usuarios_tipos_det' => 'usutip_id_usuario = usu_id'),
                'type' => 'INNER'
                ), 
            'conditions' => array('usutip_id_asignado' => $id_relacion,'usutip_id_tipo' => 2, 'usu_estatus' => 1)
        ));    

        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('usuariost/crear', $this->param, 'usuariost/delete');
        $this->template['action'] = site_url('usuariost/crear');
        $this->_run('tabla_ver');   
    }
    
     public function crear() {
        try{
        //    $this->oUsuario->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('usu_nombre','Usuario Nombre','trim|required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('usuariost/crear');
            $datos = $this->oUsuario->find('list',array('conditions' => array( 'usu_id' => $id )));
            $this->template['formulario'] = $this->_getForm(
                                'usuariost/crear'.'/'.$id,
                                $this->oUsuario->schema,
                                $datos,
                                "Usuario",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oUsuario->schema_add);

            if($this->form_validation->run()){
                $datos = elements($this->oUsuario->schema(),$this->input->post(NULL, TRUE));
                $datos['usu_password'] =  md5($datos['usu_password']);
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['usu_estatus'] = 0;
                else
                    $datos['usu_estatus'] = 1;
                 /*   $datos['usu_id_tipo'] = 2;
                    $datos['usu_id_relacion'] = $this->session->userdata('logged_user')->usu_id; */
                    $this->template['formulario'] = $this->_getForm(
                                    'usuariost/crear'.'/'.$id,
                                    $this->oUsuario->schema,
                                    $datos,
                                    "usuario",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oUsuario->schema_add);
                $id_registro = $this->oUsuario->save($datos);
                $this->oUsuario->insert_datos_tecnicos($id_registro);
                $id_relacion = $this->session->userdata('logged_user')->usu_id;
                $this->oUsuario->insert_datos_relaciones($id_registro, $id_relacion);
                $this->oUsuario->insert_usu_apl($id_registro);     
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
        $this->oUsuario->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_usuarios.php */
/* Location: ./application/controllers/usuarios/usuarios_usuarios.php */