<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Pedidos_plantas extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('pedidos', TRUE);
        $this->load->library('upload');
        $this->load->model('pedidos/plantas_model','oPlanta');
        $this->load->model('pedidos/modelo_generico_model');
        $this->template['module'] = 'pedidos';
        $this->template['titulo'] = 'plantas';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Descripcion", "Direccion", "Imagen"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'pla_id_planta'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oPlanta->find('result', array('fields' => array('pla_id_planta','pla_nombre','pla_descripcion','pla_direccion','pla_imagen'),'conditions' => array('pla_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('plantas/crear', $this->param, 'plantas/delete');
        $this->template['action'] = site_url('plantas/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oPlanta->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('pla_nombre','Planta Nombre','trim|required');
            $this->form_validation->set_rules('pla_descripcion','Descripcion','trim|required');
            $datos = '';
            if(is_numeric($id))
                $datos = $this->oPlanta->find('list',array('conditions' => array( 'pla_id_planta' => $id )));
            $this->template['action'] = site_url('plantas/crear');    
            $this->template['formulario'] = $this->_getForm(
                                'plantas/crear'.'/'.$id,
                                $this->oPlanta->schema,
                                $datos,
                                "Planta",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oPlanta->schema_add,
                                TRUE);
            if($this->form_validation->run()){
                $datos = elements($this->oPlanta->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['pla_estatus'] = 0;
                else
                    $datos['pla_estatus'] = 1;
                $this->template['formulario'] = $this->_getForm(
                                'plantas/crear'.'/'.$id,
                                $this->oPlanta->schema,
                                $datos,
                                "Planta",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oPlanta->schema_add,
                                TRUE);
                $config['upload_path'] = './assets/upload/pedidos/img/plantas';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '1000';
                $config['max_width']  = '1024';
                $config['max_height']  = '768';
        
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->do_upload('pla_imagen');
                $this->template['error_imagen'] = $this->upload->display_errors();
                $datos['pla_imagen'] = 'pedidos/img/plantas/'.$this->upload->data()['file_name'];
                $this->oPlanta->save($datos);       
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
        $this->oPlanta->delete_t($id);
        $this->index();
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */