<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Pedidos_transportes extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('pedidos', TRUE);
        $this->load->model('pedidos/transportes_model','oTransportes');
        $this->template['module'] = 'pedidos';
        $this->template['titulo'] = 'transportes';
        $this->param = array(
            'cabecera' => array("Id", "Modelo", "Imagen", "Descripcion", "Minima", "Maxima", "", ""),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'tra_id_transporte'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oTransportes->find('result', array('fields' => array('tra_id_transporte','tra_nombre','tra_imagen','tra_descripcion','tra_capacidad_min','tra_capacidad_max'),'conditions' => array('tra_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos, 'edit' => '1'));
        $this->template['table'] = $this->generate_table('transportes/crear', $this->param, 'transportes/delete');
        $this->template['agregar'] = anchor(site_url('transportes/crear'),' ',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('transportes/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oTransportes->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('tra_nombre','Planta Nombre','trim|required');
            $this->form_validation->set_rules('tra_descripcion','Descripcion','trim|required');
            $datos = '';
            if(is_numeric($id))
                $datos = $this->oTransportes->find('list',array('conditions' => array( 'tra_id_transporte' => $id )));
            $this->template['formulario'] = $this->_getForm(
                                'transportes/crear'.'/'.$id,
                                $this->oTransportes->schema,
                                $datos,
                                "Planta",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oTransportes->schema_add,
                                TRUE);
            if($this->form_validation->run()){
                $datos = elements($this->oTransportes->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['tra_estatus'] = 0;
                else
                    $datos['tra_estatus'] = 1;
                $this->oTransportes->save($datos);
                $this->template['formulario'] = $this->_getForm(
                                'transportes/crear'.'/'.$id,
                                $this->oTransportes->schema,
                                $datos,
                                "Planta",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oTransportes->schema_add,
                                TRUE);
                $config['upload_path'] = './assets/upload/pedidos/img/transportes';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '1000';
                $config['max_width']  = '1024';
                $config['max_height']  = '768';
        
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->do_upload('tra_imagen');
                $this->template['error_imagen'] = $this->upload->display_errors();
                $datos['tra_imagen'] = 'pedidos/img/transportes/'.$this->upload->data()['file_name'];
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
        $this->otranportes->delete_t($id);
        $this->index();
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */