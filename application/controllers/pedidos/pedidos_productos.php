<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Pedidos_productos extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('pedidos', TRUE);
        $this->load->library('upload');
        $this->load->model('pedidos/productos_model', 'oProductos');
    //    $this->load->model('pedidos/modelo_generico_model');
        $this->template['module'] = 'pedidos';
        $this->template['titulo'] = 'productos';
        $this->param = array(
            'cabecera' => array("Id","Clave", "Nombre", "Imagen", "Descripcion", "Especie", "Minima"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'pro_id_producto'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oProductos->find('result', array('fields' => array('pro_id_producto','pro_clave','pro_marca','pro_imagen','pro_descripcion','pro_especie','pro_minima'),'conditions' => array('pro_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('productos/crear', $this->param, 'productos/delete');
        $this->template['agregar'] = anchor(site_url('productos/crear'),' ',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('productos/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
        //    $this->oProductos->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('pro_marca','Producto Nombre','trim|required');
            $this->form_validation->set_rules('pro_descripcion','Descripcion','trim|required');
            $datos = '';
            if(is_numeric($id))
                $datos = $this->oProductos->find('list',array('conditions' => array( 'pro_id_producto' => $id )));
            $this->template['formulario'] = $this->_getForm(
                    'productos/crear'.'/'.$id,
                    $this->oProductos->schema,
                    $datos,
                    "Datos Productos",
                    'form-inline',
                    'form-inline',
                    FALSE,
                    $this->oProductos->schema_add,
                    TRUE);
            if($this->form_validation->run()){
                $datos = elements($this->oProductos->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['pro_estatus'] = 0;
                else
                     $datos['pro_estatus'] = 1;
                $this->oProductos->save($datos);
                $this->template['formulario'] = $this->_getForm(
                        'productos/crear'.'/'.$id,
                        $this->oProductos->schema,
                        $datos,
                        "Datos Productos",
                        'form-inline',
                        'form-inline',
                        FALSE,
                        $this->oProductos->schema_add,
                        TRUE);
                $config['upload_path'] = './assets/upload/pedidos/img/productos';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '1000';
                $config['max_width']  = '1024';
                $config['max_height']  = '768';
        
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->do_upload('pro_imagen');
                $this->template['error_imagen'] = $this->upload->display_errors();
                $datos['pro_imagen'] = 'pedidos/img/productos/'.$this->upload->data()['file_name'];
                $this->oProductos->save($datos);     
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
        $this->oProductos->delete_t($id);
        $this->index();
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */