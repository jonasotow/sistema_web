<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preciosmercado_Fuentes extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'preciosmercado';
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('precios',TRUE);
        $this->load->model('preciosmercado/fuentes_model','oFuentes');
        $this->load->model('preciosmercado/region_fuente_model','oRel');  
        $this->template['titulo'] = 'Fuentes';
        $this->template['action'] = site_url('fuentes/crear');
        $this->param = array(
            'cabecera' => array("Id", "Clase" ,"Region",'Fuente'),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => true,
            'delete' => true,
            'url_campo' => 'idfuente'
        );
    }

    function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
    }
	
	public function index()
	{
        $campos = $this->oFuentes->find('result',array( 
                'fields' => array('fuente.idfuente', 'clase','region','fuente'),
                'join' => array(
                    'clause' => array(
                    'clase_x_region_fuente' => 'clase_x_region_fuente.idfuente = fuente.idfuente', 
                    'region' => 'region.idregion = clase_x_region_fuente.idregion', 
                    'tipo_x_clase' => 'tipo_x_clase.idclase = clase_x_region_fuente.idtipo_clase',
                    'clase' => 'clase.idclase = tipo_x_clase.idclase'),
                    'type' => 'INNER'
                    ),
                'conditions' => array('fuente_status' => 1, 'clase_status' => 1),
                'order' => array( 'clase.clase' => 'ASC' , 'region.region' => 'ASC')));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('fuentes/crear', $this->param, 'fuentes/delete');
        $this->template['action'] = site_url('fuentes/crear');
        $this->_run('tabla_ver'); 		
	}

    public function crear() {
        try{
            $this->oFuentes->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('idtipo_clase','Clase','trim|required');
            $datos = '';
            if(is_numeric($id))
                $datos = $this->oFuentes->find('list',array('conditions' => array( 'idfuente' => $id )));
                $datos2 = $this->oRel->find('list',array('conditions' => array( 'idfuente' => $id )));
                if($datos){
                    $datos = $this->array_push_assoc($datos,'idtipo_clase',$datos2['idtipo_clase']);
                    $datos = $this->array_push_assoc($datos,'idregion',$datos2['idregion']);
                }

                $this->template['formulario'] = $this->_getForm(
                    'fuentes/crear'.'/'.$id,
                    $this->oFuentes->schema,
                    $datos,
                    "Datos Fuentes",
                    'form-inline',
                    'form-inline',
                    FALSE,
                    $this->oFuentes->schema_up
                );

            if($this->form_validation->run()){
                $datos = elements($this->oFuentes->schema(),$this->input->post(NULL, TRUE));
                $reldatos = elements($this->oRel->schema(),$this->input->post(NULL, TRUE));

                if($this->input->post('Eliminar',TRUE) != NULL)
                    $datos['fuente_status'] = 0;
                else
                    $datos['fuente_status'] = 1;

                $id = $this->oFuentes->save($datos);
                $reldatos['idfuente'] = $id;
                    
                $this->oRel->save($reldatos);
                    
                    $this->template['formulario'] = $this->_getForm(
                    'fuentes/crear'.'/'.$id,
                    $this->oFuentes->schema,
                    $datos,
                    "Datos Fuentes",
                    'form-inline',
                    'form-inline',
                    FALSE,
                    $this->oFuentes->schema_up,
                    TRUE);

                    $this->template['formulario'] = $this->_getForm(
                    'fuentes/crear'.'/'.$id,
                    $this->oFuentes->schema,
                    $this->oFuentes->find('list',array('conditions' => array( 'idfuente' => $id ))),
                    "Datos Fuentes",
                    'form-inline',
                    'form-inline',
                    FALSE,
                    $this->oFuentes->schema_up
                );
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
        $this->oFuentes->delete_t($id);
        $this->index();
    }
	
}