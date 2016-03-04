<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Pedidos_productos_detalles extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('pedidos', TRUE);
        $this->load->model('pedidos/productos_detalles_model', 'oProductos_detalles');
    //    $this->load->model('pedidos/modelo_generico_model');
        $this->template['module'] = 'pedidos';
        $this->template['titulo'] = 'productos detalles';
        $this->param = array(
            'cabecera' => array("Id","Clave", "Nombre", "Imagen", "Descripcion", "Especie", "Minima"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'profie_id_fields'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $campos = $this->oProductos_detalles->find('result', array('fields' => array('profie_id_fields','profie_id_producto','profie_nombre','profie_formato','profie_posibles','profie_obligatorio','profie_estatus'),'conditions' => array('profie_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('productos_detalles/crear', $this->param, 'productos_detalles/delete');
        $this->template['agregar'] = anchor(site_url('productos_detalles/crear'),' ',array('class' => "glyphicon glyphicon-plus-sign", 'title' => "Nuevo Formulario"));
        $this->template['action'] = site_url('productos_detalles/crear');
        $this->_run('tabla_ver');
    }
    
     public function crear() {
        try{
    //    $this->oProductos_detalles->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
            $this->form_validation->set_rules('profie_id_producto','Id Producto','trim|required');
            $this->form_validation->set_rules('profie_nombre','Producto Detalle Nombre','trim|required');
            $datos = '';
            if(is_numeric($id))
                $datos = $this->oProductos_detalles->find('list',array('conditions' => array( 'profie_id_producto' => $id )));
            $this->template['formulario'] = $this->_getForm(
                        'productos_detalles/crear'.'/'.$id,
                        $this->oProductos_detalles->schema,
                        $datos,
                        "Datos Productos Detalles",
                        'form-inline',
                        'form-inline',
                        FALSE,
                        $this->oProductos_detalles->schema_add);
            if($this->form_validation->run()){
                $datos = elements($this->oProductos_detalles->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['profie_estatus'] = 0;
                else
                    $datos['profie_estatus'] = 1;
                $this->oProductos_detalles->save($datos);
                $this->template['formulario'] = $this->_getForm(
                        'productos_detalles/crear'.'/'.$id,
                        $this->oProductos_detalles->schema,
                        $datos,
                        "Datos Productos Detalles",
                        'form-inline',
                        'form-inline',
                        FALSE,
                        $this->oProductos_detalles->schema_add);
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