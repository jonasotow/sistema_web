<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Fletes_Oridest extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'fletes';
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('fletes',TRUE);
        $this->load->model('fletes/oridest_model','oOridest');
        $this->load->model('fletes/ciudad_model','oCiudad');
        $this->template['titulo'] = 'Trayectos';
        $this->template['action'] = site_url('oridest/crear');
        $this->param = array(
            'cabecera' => array("Id", "Descripcion","Proveedor","Unidad","km's","Costo Viaje"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-pencil-square-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idtrayecto'
        );
    }
	
	public function index()
	{
    $campos = $this->oOridest->find('result',array(
                'fields' => array('trayecto.idtrayecto','trayecto.descripcion as desc_tray','proveedor.descripcion as prov','unidad.descripcion as desc_unid','trayecto.kms',"CONCAT('$',' ',FORMAT(trayecto.costokm,2))"),
                'join' => array(
                    'clause' => array(
                        'unidad' => 'trayecto.idunidad = unidad.idunidad',
                        'proveedor' => 'trayecto.idproveedor = proveedor.idproveedor'
                    ),
                    'type' => 'INNER'
                ),
                'conditions' => array('trayecto.status' => 1),
                'order' => array( 'trayecto.idtrayecto' => 'ASC' )));

        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('oridest/crear', $this->param, 'oridest/delete');
        $this->template['action'] = site_url('oridest/crear');
        $this->_run('tabla_ver');		
	}

    public function llenar_select(){
        $options = "";
        if($this->input->post('idestado'))
            $idestado = $this->input->post('idestado');
        else
            $idestado = $this->input->post('idestado2');
        $ciudades = $this->oOridest->ciudad($idestado);
        foreach($ciudades as $fila){
            ?>
            <option value="<?php echo $fila->idciudad; ?>"><?php echo $fila->descripcion; ?></option>
            <?php
        }
    }

    public function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
    }
    
    public function crear() {
        try{
        $this->oOridest->prepararForm();
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $this->form_validation->set_rules('descripcion','<span style="color: #FF0000;">"DESCRIPCION"</span>','trim|required');
        $this->form_validation->set_rules('kms','<span style="color: #FF0000;">"LA DISTANCIA EN KM"</span>','trim|required');
        $this->form_validation->set_rules('costokm','<span style="color: #FF0000;">"COSTO POR KG"</span>','trim|required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('oridest/crear');
            $datos = $this->oOridest->find('list',array('conditions' => array( 'idtrayecto' => $id )));
            if($datos){
                $ciudadorigen = $datos["idciudadorigen"];
                $idestado = $this->oCiudad->get('ciudad','idestado',"idciudad = $ciudadorigen");
                //$datos = $this->array_push_assoc($datos,'idestado',$idestado);
                $this->oOridest->prepararForm2();
            }

            $this->template['formulario'] = $this->_getForm(
                            'oridest/crear'.'/'.$id,
                            $this->oOridest->schema,
                            $datos,
                            "Datos Trayectos",
                            'form-inline',      //clase
                            'form-inline',      //id
                            FALSE,
                            $this->oOridest->schema_up,
                            TRUE);

            if($this->form_validation->run()){
                $datos = elements($this->oOridest->schema(),$this->input->post(NULL, TRUE));

                $datos['status'] = 1;
            
                $this->oOridest->save($datos);

                $this->template['formulario'] = $this->_getForm(
                                'oridest/crear'.'/'.$id,
                                $this->oOridest->schema,
                                $datos,
                                "Datos Trayectos",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oOridest->schema_up,
                                FALSE);
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
            $this->oOridest->delete_t($id);
            $this->index();
        }
    }