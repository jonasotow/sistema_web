<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * fletes_carga.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Fletes_Carga extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'fletes';
        $this->load->library('csvreader');
        $this->load->library('html2pdf');
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('fletes',TRUE);
        $this->load->model('fletes/carga_model','oCarga');
        $this->template['titulo'] = "Carga de tarifario ";
        $this->r_alta = 0;
        $this->r_modificacion = 0;
        $this->r_error = 0;
    }

    public function index() {
        try{
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $this->form_validation->set_rules('tarifario','<span style="color: #FF0000;">"SELECCIONA UN ARCHIVO"</span>','trim|required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('carga/leer_csv');
            $this->template['formulario'] = $this->_getForm(
                            'carga/leer_csv'.'/'.$id,
                            $this->oCarga->schema,
                            $datos,
                            "Archivo Tarifario",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oCarga->schema_up,
                            TRUE);

        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }  
        
        $this->_run('crud');
    }

    public function leer_csv(){
        try{

            $filePath = $_FILES['tarifario']['tmp_name'];
            $datacsv = $this->csvreader->parse_file($filePath);
            foreach ($datacsv as $row){
                if(count($row) == 9){
                    $accion[] = $this->oCarga->cargar_csv(
                        $descripcion[] = $row['descripcion'],
                        $idorigen[] = $row['idorigen'],
                        $estado[] = $row['estado'],
                        $ciudad[] = $row['ciudad'],
                        $kms[] = $row['km'],
                        $costo[] = $row['costo'],
                        $unidad[] = $row['unidad'],
                        $proveedor[]  = $row['idproveedor'],
                        $status[] = $row['status']
                    );
                }
            }
            
            for($i = 0; $i <= count($accion); $i++){
                if(@$accion[$i] == "AGREGADO"){
                    $this->r_alta = $this->r_alta + 1;
                } else if(@$accion[$i] == "MODIFICADO"){
                    $this->r_modificacion = $this->r_modificacion + 1;
                } else if(@$accion[$i] == "ERROR"){
                    $this->r_error = $this->r_error + 1;
                }
            }

            $this->template['descripcion'] = $descripcion;
            $this->template['estado'] = $estado;
            $this->template['ciudad'] = $ciudad;
            $this->template['kms'] = $kms;
            $this->template['costo'] = $costo;
            $this->template['unidad'] = $unidad;
            $this->template['proveedor'] = $proveedor;
            $this->template['status'] = $status;
            $this->template['accion'] = $accion;
            $this->template['r_alta'] = $this->r_alta;
            $this->template['r_modificacion'] = $this->r_modificacion;
            $this->template['r_error'] = $this->r_error;
            $this->template['datacsv'] = $datacsv;
            $this->_run('preview');

        }catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }
    }

    public function  descargar_tarifario(){

        $this->template['contenido'] = $this->oCarga->Contenido();
        $this->template['unidades'] = $this->oCarga->get('unidad','*',NULL,NULL);
        $html = $this->load->view('fletes/local/tarifario', $this->template);

            $this->name_pdf = "T".date("YmdHis").".pdf";
            //Set folder to save PDF to
            $this->html2pdf->folder('./assets/upload/fletes/tarifario/');

            //Set the filename to save/download as
            $this->html2pdf->filename($this->name_pdf);

            //Set the paper defaults
            $this->html2pdf->paper('A4', 'landscape');

            //Load html view
            $this->html2pdf->html($this->load->view('fletes/local/tarifario',$html, true));
                    
            $this->html2pdf->create('save');
            redirect(base_url()."assets/upload/fletes/tarifario/".$this->name_pdf);
    }
}