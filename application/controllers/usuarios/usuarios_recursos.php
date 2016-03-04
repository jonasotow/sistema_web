<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Usuarios_recursos extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('usuarios/recursos_model','oRecursos');
        $this->load->model('usuarios/modelo_generico_model');
        $this->template['module'] = 'usuarios';
        $this->template['titulo'] = 'recursos';
        $this->param = array(
            'cabecera' => array("Id", "Controlador", "Accion", "Etiqueta", "Posicion"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'rec_id'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oRecursos->find('result', array('fields' => array('rec_id','rec_controlador','rec_accion','rec_etiqueta','rec_posicion'),'conditions' => array('rec_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        
        $this->template['table'] = $this->generate_table('recursos/crear', $this->param, 'recursos/delete');
        $this->template['action'] = site_url('recursos/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oRecursos->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('rec_controlador','Nombre Controlador','trim|required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('recursos/crear');
                $datos = $this->oRecursos->find('list',array('conditions' => array( 'rec_id' => $id )));
                $this->template['formulario'] = $this->_getForm(
                                    'recursos/crear'.'/'.$id,
                                    $this->oRecursos->schema,
                                    $datos,
                                    "Recurso",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oRecursos->schema_add);

            if($this->form_validation->run()){
                $datos = elements($this->oRecursos->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['rec_estatus'] = 0;
                    $this->template['formulario'] = $this->_getForm(
                                    'recursos/crear'.'/'.$id,
                                    $this->oRecursos->schema,
                                    $datos,
                                    "Recurso",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oRecursos->schema_add);
                    $this->oRecursos->save($datos);       
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
        $this->oRecursos->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_recursos.php */
/* Location: ./application/controllers/usuarios/usuarios_recursos.php */