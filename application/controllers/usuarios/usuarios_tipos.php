<?php if ( ! defined('BASEPATH')) die('No dirolt script access allowed');

class Usuarios_tipos extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();

        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('usuarios/tipos_model','oTipos');
        $this->load->model('usuarios/modelo_generico_model');
        $this->template['module'] = 'usuarios';
        $this->template['titulo'] = 'tipos';
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
        $campos = $this->oTipos->find('result', array('fields' => array('rol_id','rol_nombre','rol_descripcion'),'conditions' => array('rol_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('tipos/crear', $this->param, 'tipos/delete');
        $this->template['action'] = site_url('tipos/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oTipos->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('tip_nombre','Nombre Rol','trim|required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('tipos/crear');
                $datos = $this->oTipos->find('list',array('conditions' => array( 'tip_id' => $id )));
                $this->template['formulario'] = $this->_getForm(
                                    'tipos/crear'.'/'.$id,
                                    $this->oTipos->schema,
                                    $datos,
                                    "Tipo",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oTipos->schema_add);
            if($this->form_validation->run()){
                $datos = elements($this->oTipos->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['tip_estatus'] = 0;
                    $this->template['formulario'] = $this->_getForm(
                                    'tipos/crear'.'/'.$id,
                                    $this->oTipos->schema,
                                    $datos,
                                    "Tipo",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oTipos->schema_add);
                    $this->oTipos->save($datos);       
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
        $this->oTipos->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_tipos.php */
/* Location: ./application/controllers/usuarios/usuarios_tipos.php */