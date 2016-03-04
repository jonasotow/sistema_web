<?php if ( ! defined('BASEPATH')) die('No dirolt script access allowed');

class Usuarios_roles extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();

        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('usuarios/roles_model','oRoles');
        $this->load->model('usuarios/modelo_generico_model');
        $this->template['module'] = 'usuarios';
        $this->template['titulo'] = 'roles';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Descripcion"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'rol_id'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oRoles->find('result', array('fields' => array('rol_id','rol_nombre','rol_descripcion'),'conditions' => array('rol_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('roles/crear', $this->param, 'roles/delete');
        $this->template['action'] = site_url('roles/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oRoles->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('rol_nombre','Nombre Rol','trim|required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('roles/crear');
                $datos = $this->oRoles->find('list',array('conditions' => array( 'rol_id' => $id )));
                $this->template['formulario'] = $this->_getForm(
                                    'roles/crear'.'/'.$id,
                                    $this->oRoles->schema,
                                    $datos,
                                    "Rol",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oRoles->schema_add);
            if($this->form_validation->run()){
                $datos = elements($this->oRoles->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['rol_estatus'] = 0;
                    $this->template['formulario'] = $this->_getForm(
                                    'roles/crear'.'/'.$id,
                                    $this->oRoles->schema,
                                    $datos,
                                    "Rol",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oRoles->schema_add);
                    $this->oRoles->save($datos);       
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
        $this->oRoles->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_roles.php */
/* Location: ./application/controllers/usuarios/usuarios_roles.php */