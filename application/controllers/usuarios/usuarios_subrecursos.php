<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Usuarios_subrecursos extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();

        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('usuarios/subrecursos_model','oSubrecurso');
        $this->load->model('usuarios/modelo_generico_model');
        $this->template['module'] = 'usuarios';
        $this->template['titulo'] = 'subrecursos';
        $this->param = array(
            'cabecera' => array("Id", "Id Recurso", "Controlador", "Accion", "Etiqueta", "Posicion"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'subrec_id'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oSubrecurso->find('result', array('fields' => array('subrec_id','subrec_recurso_id','subrec_controlador','subrec_accion','subrec_etiqueta','subrec_posicion'),'conditions' => array('subrec_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('subrecursos/crear', $this->param, 'subrecursos/delete');
        $this->template['action'] = site_url('subrecursos/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oSubrecurso->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('subrec_recurso_id','Id Recurso','trim|required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('subrecursos/crear');
                $datos = $this->oSubrecurso->find('list',array('conditions' => array( 'usu_id' => $id )));
                $this->template['formulario'] = $this->_getForm(
                                    'subrecursos/crear'.'/'.$id,
                                    $this->oSubrecurso->schema,
                                    $datos,
                                    "Subrecurso",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oSubrecurso->schema_add);

            if($this->form_validation->run()){
                $datos = elements($this->oSubrecurso->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['usu_estatus'] = 0;
                    $this->template['formulario'] = $this->_getForm(
                                    'subrecursos/crear'.'/'.$id,
                                    $this->oSubrecurso->schema,
                                    $datos,
                                    "Subrecurso",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oSubrecurso->schema_add);
                    $this->oSubrecurso->save($datos);       
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
        $this->oSubrecurso->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_subrecursos.php */
/* Location: ./application/controllers/usuarios/usuarios_subrecursos.php */