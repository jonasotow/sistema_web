<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Fletes_Cotizaciones extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'fletes';
        $this->template['module'] = 'local';
        $this->load->library('html2pdf');
        $this->load->library('pagination');
        $dbBase = $this->load->database('fletes',TRUE);
        $this->load->model('fletes/cotizaciones_model','oCotizacion');
        $this->template['titulo'] = 'Solicitudes Realizadas';
        $this->param = array(
            'cabecera' => array("Id","#","Nombre Solicitante","División","Origen","Fecha"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-file-pdf-o fa-lg",
            'url_campo' => 'idsolicitud'
        );
    }
	
	public function index(){
                // Paginacion
        $config['base_url'] = site_url('cotizaciones/index');
        $config['total_rows'] = count($this->oCotizacion->filas());
        $config['per_page'] = 10;
        $config['num_links'] = 20; 
        $config['first_link'] = 'Primera';
        $config['last_link'] = 'Última';
        $config["uri_segment"] = 3;
        $config['next_link'] = '>>';
        $config['prev_link'] = '<<';
        $this->pagination->initialize($config); 

           $campos = $this->oCotizacion->find('result',array( 
                'fields' => array('idsolicitud','idsolicitud as num','nombre_solicitante','division','origenes.descripcion','fecha'),
                'join' => array(
                    'clause' => array(
                        'origenes' => 'origenes.idorigen = solicitudes.origen'
                    ),
                    'type' => 'INNER'
                ),
                'order' => array('fecha' => 'DESC'),
                'limit' => array( 10, $this->uri->segment(3) )
            ));

        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('cotizaciones/obtener_pdf', $this->param);
        $this->template['pagination'] = $this->pagination->create_links();
        $this->_run('tabla_ver');		
	}

    public function obtener_pdf(){

            $id = $this->uri->segment(3);
            $contenido = $this->oCotizacion->generar_pdf($id);

            foreach($contenido as $row){
               $this->template['idsolicitud'] = $row->idsolicitud;
               $this->template['fecha'] = $row->fecha;
               $this->template['nombre_solicitante'] = $row->nombre_solicitante;
               $this->template['division'] = $row->division;
               $this->template['nombre_cliente'] = $row->nombre_cliente;
               $this->template['nombre_contacto_1'] = $row->nombre_contacto_1;
               $this->template['telefono_1'] = $row->telefono_1;
               $this->template['celular_1'] = $row->celular_1;
               $this->template['nombre_contacto_2'] = $row->nombre_contacto_2;
               $this->template['telefono_2'] = $row->telefono_2;
               $this->template['celular_2'] = $row->celular_2;
               $this->template['embalaje'] = $row->embalaje;
               $this->template['direccion_1'] = $row->direccion;
               $this->template['ciudad'] = $this->oCotizacion->ciudad($row->idciudad);
               $this->template['estado'] = $this->oCotizacion->estado($row->idestado);
               $this->template['cp_1'] = $row->cp;
               $this->template['referencia_1'] = $row->referencias;
               $this->template['fumigacion'] = ($row->fumigacion) ? "Si" : "No";
               $this->template['obs_fumigacion'] = $row->obs_fumigacion;
               $this->template['lavado'] = ($row->lavado) ? "Si" : "No";
               $this->template['obs_lavado'] = $row->obs_lavado;
               $this->template['requisitos'] = $row->requerimientos;
               $this->template['detalle'] = $this->oCotizacion->detalle($row->idsolicitud);
            }

              $html = $this->load->view('fletes/local/pdf', $this->template);

              //Set folder to save PDF to
              $this->html2pdf->folder('./assets/upload/fletes/solicitudes/');

              //Set the filename to save/download as
              $this->html2pdf->filename("cotizacion_".$id.".pdf");

              //Set the paper defaults
              $this->html2pdf->paper('A4', 'portrait');
              
              //Load html view
              $this->html2pdf->html($this->load->view('fletes/local/pdf', $html, TRUE));
                      
              $this->html2pdf->create('save');
              redirect(base_url()."assets/upload/fletes/solicitudes/cotizacion_".$id.".pdf");
          }

    }