<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Pedidos_Campos extends MY_Controller {

    var $param;

    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('pedidos', TRUE);
        $this->load->model('pedidos/campos_model', 'oCampos');
        $this->load->model('pedidos/formularios_model');
        $this->template['module'] = 'pedidos';
        $this->template['titulo'] = 'campos';
        $this->param = array(
            'cabecera' => array("Id", "Formulario", "Id Campo", "Etiqueta", "Tipo", "Nombre", "Valores", "Requerido", "Pocision", "", ""),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'cam_id_campo'
        );
    }

    /**
     * Muestra lista de campos
     * 
     * @access public
     */
    public function index() {
        $this->template['links'] = $this->pagination('campos/index', $this->modelo_generico_model->count('cam_campos_det'));
        $campos = $this->oCampos->find('result',array( 
                'fields' => array('cam_id_campo','form_nombre','cam_id','cam_label','cam_type','cam_value','cam_name','cam_required','cam_posicion'),
                'join' => array(
                    'clause' => array('form_formularios_mstr' => 'cam_id_formulario = form_id_formulario'),
                    'type' => 'INNER'
                ),
                'order' => array( 'cam_id_campo' => 'DESC' ),
                'limit' => array( 10, $this->uri->segment(3) )
                ));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('campos/crear', $this->param, 'campos/delete');
        $this->template['agregar'] = anchor(site_url('campos/crear'),'Nuevo',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('campos/crear');
        $this->_run('tabla_ver');
    }
    
    public function crear() {
        try{
            $this->oCampos->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('cam_id','Id Campo','trim|required|is_unique[cam_campos_det.cam_id]');
            $this->form_validation->set_rules('cam_label','Etiqueta','trim|required');
            $datos = '';
            if(is_numeric($id))
                $datos = $this->oCampos->find('list',array('conditions' => array( 'cam_id_campo' => $id )));
            $this->template['formulario'] = $this->_getForm(
                                    'campos/crear'.'/'.$id,
                                    $this->oCampos->schema,
                                    $datos,
                                    "Planta",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oCampos->schema_add);
            if($this->form_validation->run()){
                $datos = elements($this->oCampos->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['cam_estatus'] = 0;
                else
                    $datos['cam_estatus'] = 1;
                $this->template['formulario'] = $this->_getForm(
                                    'campos/crear'.'/'.$id,
                                    $this->oCampos->schema,
                                    $datos,
                                    "Planta",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oCampos->schema_add);
                $this->oCampos->save($datos);
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
        $this->oCampos->delete_t($id);
        $this->index();
    }
}

/* End of file campos.php */
/* Location: ./application/pedidos/controllers/campos.php */