<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_clases.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */


class Preciosmercado_Clases extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'preciosmercado';
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('precios',TRUE);
        $this->load->model('preciosmercado/clases_model','oClases');
        $this->load->model('preciosmercado/tipo_model','oTipo');
        $this->load->model('preciosmercado/tipo_clase_model','oRel');  
        $this->template['titulo'] = 'Clases';
        $this->template['action'] = site_url('clases/crear');
        $this->param = array(
            'cabecera' => array("Id", "Tipo",'Clase'),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => true,
            'delete' => true,
            'url_campo' => 'idclase'
        );
    }

     function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
    }
	
	public function index()
	{
        $campos = $this->oClases->find('result',array( 
                'fields' => array('clase.idclase','tipo','clase'),
                'join' => array(
                'clause' => array('tipo_x_clase' => 'tipo_x_clase.idclase = clase.idclase', 'tipo' => 'tipo.idtipo = tipo_x_clase.idtipo'),
                'type' => 'INNER'),
                'conditions' => array('tipo_status' => 1, 'clase_status' => 1),
                'order' => array( 'tipo.tipo' => 'ASC' , 'clase.clase' => 'ASC')));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('clases/crear', $this->param, 'clases/delete');
        $this->template['action'] = site_url('clases/crear');
        $this->_run('tabla_ver');  	
	}

    public function crear() {
        try{
        $this->oClases->prepararForm();
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $this->form_validation->set_rules('clase','Clase','trim|required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('clases/crear');
            $datos = $this->oClases->find('list',array('conditions' => array( 'idclase' => $id )));
            $datos2 = $this->oRel->find('list',array('conditions' => array( 'idclase' => $id )));
            if($datos){
                $datos = $this->array_push_assoc($datos,'idtipo',$datos2['idtipo']);
            }
            $this->template['formulario'] = $this->_getForm(
                            'clases/crear'.'/'.$id,
                            $this->oClases->schema,
                            $datos,
                            "Datos Clases",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oClases->schema_up,
                            TRUE);

        if($this->form_validation->run()){
            $datos = elements($this->oClases->schema(),$this->input->post(NULL, TRUE));
            $reldatos = elements($this->oRel->schema(),$this->input->post(NULL, TRUE));
            if($this->input->post('Eliminar',TRUE) != NULL)
                $datos['clase_status'] = 0;
            else
                $datos['clase_status'] = 1;

            $id = $this->oClases->save($datos);
            
            //Validar si es modificacion para no volver a insertar la relacion.
            $reldatos['idclase'] = $id;
            $this->oRel->save($reldatos);

            $this->template['formulario'] = $this->_getForm(
                            'clases/crear'.'/'.$id,
                            $this->oClases->schema,
                            $this->oClases->find('list',array('conditions' => array( 'idclase' => $id ))),
                            "Datos Clases",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oClases->schema_up,
                            TRUE);
            }
        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
    } 

    if($this->input->post('Eliminar',TRUE) != NULL)
        $this->index();
    else
        $this->_run('crud');
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->oClases->delete_t($id);
        $this->index();
    }
	
}