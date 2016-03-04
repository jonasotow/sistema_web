<?php if ( ! defined('BASEPATH')) die('No dirolt script access allowed');

class Usuarios_roles_recursos extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();

        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('usuarios/roles_recursos_model','oRoles_recursos');
        $this->load->model('usuarios/modelo_generico_model');
        $this->template['module'] = 'usuarios';
        $this->template['titulo'] = 'roles_recursos';
        $this->param = array(
            'cabecera' => array("Id", "Id rol", "Id recurso",),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'rolrec_id'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oRoles_recursos->find('result', array('fields' => array('rolrec_id','rolrec_rol_id','rolrec_recurso_id'),'conditions' => array('rolrec_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('roles_recursos/crear', $this->param, 'roles_recursos/delete');
        $this->template['action'] = site_url('roles_recursos/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oRoles_recursos->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('rolrec_rol_id','Id rol','trim|required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('roles_recursos/crear');
                $datos = $this->oRoles_recursos->find('list',array('conditions' => array( 'rolrec_id' => $id )));
                $this->template['formulario'] = $this->_getForm(
                                    'roles_recursos/crear'.'/'.$id,
                                    $this->oRoles_recursos->schema,
                                    $datos,
                                    "Rol Recurso",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oRoles_recursos->schema_add);
            if($this->form_validation->run()){
                $datos = elements($this->oRoles_recursos->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['rolrec_estatus'] = 0;
                $this->template['formulario'] = $this->_getForm(
                                'roles/crear'.'/'.$id,
                                $this->oRoles_recursos->schema,
                                $datos,
                                "Rol Recurso",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oRoles_recursos->schema_add);
                $this->oRoles_recursos->save($datos);       
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
        $this->oRoles_recursos->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_roles.php */
/* Location: ./application/controllers/usuarios/usuarios_roles.php */