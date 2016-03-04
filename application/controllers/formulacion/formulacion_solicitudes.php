    <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Formulacion_solicitudes extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'formulacion';
        $this->template['module'] = 'local';
        $this->template['back'] = 'solicitudes';
        $this->load->library('html2pdf');
        $dbBase = $this->load->database('formulacion',TRUE);
        $this->load->model('formulacion/solicitudes_model','oSolicitudes');
        $this->load->model('formulacion/solicitudes_lechero_model','oSolicitudesL');
        $this->load->model('formulacion/status_model','oStatus');
        $this->load->model('formulacion/modelo_generico_model','oGenerico');
        $this->template['contador'] = $this->oGenerico->obtener_solicitudes_pendientes('Solicitud_lechero')+$this->oGenerico->obtener_solicitudes_pendientes('Solicitud_engorda');
        $this->load->library('session');
        //$this->template['action'] = site_url('ganaderia/crear');
        $this->param = array(
            'cabecera' => array("Id", "No. #","Solicitante","Fecha y Hora","Tipo Cliente","Comentario","Status","Analisis","Solicitud"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-file-archive-o fa-lg",
            'delete' => "fa fa-file-pdf-o fa-lg",
            'url_campo' => 'idSolicitud_Engorda'
        );
        $this->param2 = array(
            'cabecera' => array("Id", "No. #", "Solicitante","Fecha y Hora","Tipo Cliente","Formato","Comentario","Status","Analisis","Solicitud"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-file-archive-o fa-lg",
            'delete' => "fa fa-file-pdf-o fa-lg",
            'url_campo' => 'idSolicitud_Lechero'
        );
    }
	
	public function index()
	{
        $this->template['titulo'] = 'Solicitudes pendientes engorda';
        $campos = $this->oSolicitudes->find('result',array( 
                'fields' => array('idSolicitud_Engorda','idSolicitud_Engorda as ID','Solicitante',"DATE_FORMAT(Fecha,'%d/%m/%Y - %h:%i:%s')",'Tipo_Cliente','Formato','Comentario','StatusSolicitud'),
                'conditions' => array('status' => 1),
                'order' => array( 'idSolicitud_Engorda' => 'ASC' ))); 
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('ganaderia/analisis', $this->param, 'ganaderia/obtener_pdf_engorda');
        $this->template['action'] = site_url('solicitudes/crear_engorda');       
        $this->_run('tabla_ver');	
	}

    public function index_lechero()
    {
        $this->template['titulo'] = 'Solicitudes pendientes lechero';
        $campos = $this->oSolicitudesL->find('result',array( 
                'fields' => array('idSolicitud_Lechero','idSolicitud_Lechero as ID','Solicitante',"DATE_FORMAT(Fecha,'%d/%m/%Y - %h:%i:%s')",'Tipo_Cliente','Comentario','StatusSolicitud'),
                'conditions' => array('status' => 1),
                'order' => array( 'idSolicitud_Lechero' => 'ASC' ))); 
        $this->param2 = array_merge($this->param2, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('solicitudes/crear_lechero', $this->param2, 'ganaderia/obtener_pdf_lechero');
        $this->template['action'] = site_url('solicitudes/crear_lechero');
        $this->_run('tabla_ver');   
    }

    public function crear_engorda() {
        try{
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $datos = '';
        $datos = $this->oStatus->find('list',array('conditions' => array( 'idSolicitud' => $id /* , 'Formato' => 'ENGORDA' */)));
        $this->template['formulario'] = $this->_getForm(
                            'solicitudes/crear_engorda'.'/'.$id,
                            $this->oSolicitudes->schema,
                            $datos,
                            "solicitud",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oSolicitudes->schema_up,
                            TRUE);

        $datos = $this->input->post(NULL, TRUE);
        if($datos){
          $this->oStatus->cambio_status($datos);

            /* $this->email->from('web@vimifos.com','Vimifos'); */
            $correo_solicitud = $this->oSolicitudes->get('Solicitud_engorda','Correo','idSolicitud_Engorda ='.$datos['idSolicitud']);
            foreach($correo_solicitud as $rowc){
                $correo_alterno = $rowc->Correo;
                $Solicitante = $rowc->Solicitante;
            }
            /* $sol_correos = $this->session->userdata('logged_user')->usu_email.",".$correo_alterno;
            $list_correos = "mberumen@vimifos.com,".$sol_correos;
            $this->email->to($list_correos); */
            $idsolicitud = $datos['idSolicitud'];
            $status = $datos['Status'];
            $comentario = $datos['Comentario'];
            $formato = $datos['Formato'];
            $this->email->subject('::VIMIFOS::Formulacion');
            $message = "<fieldset>
                <legend>
                <strong>Estimado Cliente {$Solicitante}</strong>
                </legend>
                <p> 
                '' Se modificado el estatus de su solicitud de {$formato} con folio #{$idsolicitud} al estatus {$status}, se han anexado los siguientes comentarios: {$comentario}.'' 
                </p> 
                </fieldset> ";
                $this->email->message($message);
                //$this->email->attach($path);
                $this->email->send();

          $this->template['formulario'] = $this->_getForm(
                              'solicitudes/crear_engorda'.'/'.$id,
                              $this->oSolicitudes->schema,
                              $datos,
                              "solicitud",
                              'form-inline',
                              'form-inline',
                              FALSE,
                              $this->oSolicitudes->schema_up,
                              TRUE);
          }

        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        } 

        if($this->input->post('eliminar',TRUE) != NULL)
            $this->index();
        else
            $this->_run('crudn');
        }

        public function crear_lechero() {
        try{
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $datos = '';
        $datos = $this->oStatus->find('list',array('conditions' => array( 'idSolicitud' => $id , 'Formato' => 'LECHERO')));
        $this->template['formulario'] = $this->_getForm(
                            'solicitudes/crear_lechero'.'/'.$id,
                            $this->oSolicitudes->schema,
                            $datos,
                            "solicitud",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oSolicitudes->schema_up,
                            TRUE);

        $datos = $this->input->post(NULL, TRUE);
        if($datos){
          $this->oStatus->cambio_status($datos);

            $this->email->from('web@vimifos.com','Vimifos');
            $correo_solicitud = $this->oSolicitudes->get('Solicitud_lechero','Correo','idSolicitud_Lechero ='.$datos['idSolicitud']);
            foreach($correo_solicitud as $rowc){
                $correo_alterno = $rowc->Correo;
                $Solicitante = $rowc->Solicitante;
            }
            //CORREO ELECTRONICO AL USUARIO DE LA CUENTA
            $sol_correos = $this->session->userdata('logged_user')->usu_email.",".$correo_alterno;
            $list_correos = "mberumen@vimifos.com,".$sol_correos;
            $this->email->to($list_correos);
            $idsolicitud = $datos['idSolicitud'];
            $status = $datos['Status'];
            $comentario = $datos['Comentario'];
            $formato = $datos['Formato'];
            $this->email->subject('::VIMIFOS::Formulacion');
            $message = "<fieldset>
                <legend>
                <strong>Estimado Cliente {$Solicitante}</strong>
                </legend>
                <p> 
                '' Se modificado el estatus de su solicitud de {$formato} con folio# {$idsolicitud} al estatus {$status}, se han anexado los siguientes comentarios: {$comentario}.'' 
                </p> 
                </fieldset> ";
                $this->email->message($message);
                //$this->email->attach($path);
                $this->email->send();

          $this->template['formulario'] = $this->_getForm(
                              'solicitudes/crear_lechero'.'/'.$id,
                              $this->oSolicitudes->schema,
                              $datos,
                              "solicitud",
                              'form-inline',
                              'form-inline',
                              FALSE,
                              $this->oSolicitudes->schema_up,
                              TRUE);
          }

        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }  
        
        if($this->input->post('eliminar',TRUE) != NULL)
            $this->index();
        else
            $this->_run('crudn');
        }

        /*function delete() {
            $id = $this->uri->segment(3);
            $this->oGanaderia->delete_t($id);
            $this->index();
        } */
    }