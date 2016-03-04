<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preciosmercado_Regiones extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'preciosmercado';
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('precios',TRUE);
        $this->load->model('preciosmercado/regiones_model','oRegiones');
        $this->template['titulo'] = 'Regiones';
        $this->template['action'] = site_url('regiones/crear');
        $this->param = array(
            'cabecera' => array("Id",'Region'),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => true,
            'delete' => true,
            'url_campo' => 'idregion'
        );
    }
	
	public function index()
	{
        $campos = $this->oRegiones->find('result',array( 
                'fields' => array('region.idregion','region'),
                'conditions' => array('region.region_status' => '1'),
                'order' => array( 'region.idregion' => 'ASC')));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('regiones/crear', $this->param, 'regiones/delete');
        $this->template['action'] = site_url('regiones/crear');
        $this->_run('tabla_ver');   	
	}

    public function crear() {
        try{
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $this->form_validation->set_rules('region','Region','trim|required');
        $datos = '';
        if(is_numeric($id))
        $datos = $this->oRegiones->find('list',array('conditions' => array( 'idregion' => $id )));
        $this->template['formulario'] = $this->_getForm(
                        'regiones/crear'.'/'.$id,
                        $this->oRegiones->schema,
                        $datos,
                        "Datos Regiones",
                        'form-inline',
                        'form-inline',
                        FALSE,
                        $this->oRegiones->schema_up);

        if($this->form_validation->run()){
            $datos = elements($this->oRegiones->schema(),$this->input->post(NULL, TRUE));
            if($this->input->post('Eliminar',TRUE) != NULL)
                $datos['region_status'] = 0;
            else
                $datos['region_status'] = 1;

            $this->oRegiones->save($datos);

            $this->template['formulario'] = $this->_getForm(
                            'regiones/crear'.'/'.$id,
                            $this->oRegiones->schema,
                            $datos,
                            "Datos Regiones",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oRegiones->schema_up);
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
            $this->oRegiones->delete_t($id);
            $this->index();
        }
	
}