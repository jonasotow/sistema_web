<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Usuarios_aplicaciones_roles extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();

        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('usuarios/aplicaciones_roles_model','oAplicacion_roles');
        $this->load->model('usuarios/modelo_generico_model');
        $this->template['module'] = 'usuarios';
        $this->template['titulo'] = 'aplicaciones_roles';
        $this->param = array(
            'cabecera' => array("Id", "Id aplicacion", "Id rol"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'aplrol_id'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oAplicacion_roles->find('result', array('fields' => array('aplrol_id','aplrol_aplicacion_id','aplrol_rol_id'),'conditions' => array('aplrol_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('aplicaciones_roles/crear', $this->param, 'aplicaciones_roles/delete');
        $this->template['action'] = site_url('aplicaciones_roles/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oAplicacion_roles->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('aplrol_aplicacion_id','Id Aplicacion','trim|required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('aplicaciones_roles/crear');
                $datos = $this->oAplicacion_roles->find('list',array('conditions' => array( 'aplrol_id' => $id )));
                $this->template['formulario'] = $this->_getForm(
                                    'aplicaciones_roles/crear'.'/'.$id,
                                    $this->oAplicacion_roles->schema,
                                    $datos,
                                    "Aplicacion rol",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oAplicacion_roles->schema_add);

            if($this->form_validation->run()){
                $datos = elements($this->oAplicacion_roles->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['aplrol_estatus'] = 0;
                    $this->template['formulario'] = $this->_getForm(
                                    'aplicaciones_roles/crear'.'/'.$id,
                                    $this->oAplicacion_roles->schema,
                                    $datos,
                                    "Aplicacion",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oAplicacion_roles->schema_add);
                    $this->oAplicacion_roles->save($datos);       
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
        $this->oAplicacion_roles->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_aplicaciones_roles.php */
/* Location: ./application/controllers/usuarios/usuarios_aplicaciones_roles.php */