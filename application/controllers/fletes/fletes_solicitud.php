<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Fletes_Solicitud extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'fletes';
        $this->load->library('html2pdf');
        $this->template['module'] = 'local';
        $dbBase = $this->load->database('fletes',TRUE);
        $this->load->model('fletes/solicitud_model','oSolicitud');
        $this->load->model('fletes/unidad_model','oUnidad');
        $this->template['titulo'] = 'Solicitud de Cotizacion';
    }
	
	public function index(){
        $idunidad = $this->oSolicitud->list_generic('unidad');
        $idestado = $this->oSolicitud->list_generic('Estado');
        $idorigen = $this->oSolicitud->list_generic('origenes');
        $idrequerimiento = $this->oSolicitud->list_generic('requerimiento');

        $unidad = "<option value='0'>Seleccione una Unidad</option>";
        foreach($idunidad as $rows){
            $unidad .= "<option value=".$rows->idunidad.">".$rows->descripcion."</option>";
        }
        $this->template['idunidad'] = $unidad;
        $estado = "<option value='0'>Seleccione un Estado</option>";
        foreach($idestado as $rows){
            $estado .= "<option value=".$rows->idestado.">".$rows->descripcion."</option>";
        }
        $origen = "<option value='0'>Seleccione un Origen</option>";
        foreach($idorigen as $rows){
            $origen .= "<option value=".$rows->idorigen.">".$rows->descripcion."</option>";
        }
        $this->template['idunidad'] = $unidad;
        $this->template['idestado'] = $estado;
        $this->template['origen'] = $origen;
        $this->template['requerimiento'] = $idrequerimiento;
        $this->_run('fletes_solicitud');		
	}

    public function generar_pdf(){ 

            $contenido = $this->oSolicitud->guardar_cotizacion();

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
               $this->template['ciudad'] = $this->oSolicitud->ciudad($row->idciudad);
               $this->template['estado'] = $this->oSolicitud->estado($row->idestado);
               $this->template['cp_1'] = $row->cp;
               $this->template['referencia_1'] = $row->referencias;
               $this->template['fumigacion'] = ($row->fumigacion) ? "Si" : "No";
               $this->template['obs_fumigacion'] = $row->obs_fumigacion;
               $this->template['lavado'] = ($row->lavado) ? "Si" : "No";
               $this->template['obs_lavado'] = $row->obs_lavado;
               $this->template['requisitos'] = $row->requerimientos;
               $this->template['detalle'] = $this->oSolicitud->detalle($row->idsolicitud);
               $this->template['ruta'] = $this->oSolicitud->BuscarEnRuta($row->idsolicitud);
            }

            $html = $this->load->view('fletes/local/pdf', $this->template);
            
            //Set folder to save PDF to
            $this->html2pdf->folder('./assets/upload/fletes/solicitudes/');

            //Set the filename to save/download as
            $this->html2pdf->filename("cotizacion_".$this->template['idsolicitud'].".pdf");

            //Set the paper defaults
            $this->html2pdf->paper('A4', 'portrait');

            //Load html view
            $this->html2pdf->html($this->load->view('fletes/local/pdf',$html, true));
                    
            $this->html2pdf->create('save');
            redirect(base_url()."assets/upload/fletes/solicitudes/cotizacion_".$this->template['idsolicitud'].".pdf");
    }
}