  <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Formulacion_ganaderia extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'formulacion';
        $this->template['module'] = 'local';
        $this->load->library('html2pdf');
        $dbBase = $this->load->database('formulacion',TRUE);
        $this->load->model('formulacion/ganaderia_model','oGanaderia');
        $this->load->model('formulacion/ganaderia_lechero_model','oGanaderiaLechero');
        $this->load->model('formulacion/modelo_generico_model','oGenerico');
        $this->load->library('session');
        $this->template['contador'] = $this->oGenerico->obtener_solicitudes_pendientes('Solicitud_lechero')+$this->oGenerico->obtener_solicitudes_pendientes('Solicitud_engorda');
        $this->param = array(
            'cabecera' => array("Id","No. #","Solicitante","Fecha","Tipo Cliente","Status","Formato","Observaciones","Solicitud","Eliminar"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-file-pdf-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idSolicitud_Engorda'
        );
        $this->param2 = array(
            'cabecera' => array("Id","No. #","Solicitante","Fecha","Tipo Cliente","Status","Observaciones","Solicitud","Eliminar"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-file-pdf-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idSolicitud_Lechero'
        );
    }
	
	public function index(){
        $this->template['titulo'] = 'Formulacion - Engorda';
        $campos = $this->oGanaderia->find('result',array( 
                'fields' => array('Solicitud_engorda.idSolicitud_Engorda','idSolicitud_Engorda as ID','Solicitud_engorda.Solicitante',"DATE_FORMAT(Solicitud_engorda.Fecha,'%d/%m/%Y - %h:%i:%s')",'Solicitud_engorda.Tipo_Cliente','Status_solicitud.Status',"Status_solicitud.Formato","Status_solicitud.Comentario"),
                'join' => array(
                    'clause' => array(
                        'Status_solicitud' => 'Status_solicitud.Status = Solicitud_engorda.StatusSolicitud and Status_solicitud.idSolicitud = Solicitud_engorda.idSolicitud_Engorda AND Status_solicitud.Formato = Solicitud_engorda.Formato'
                    ),
                    'type' => 'INNER'
                ),
                'conditions' => array('Solicitud_engorda.Status' => 1),
                'conditions' => array('Solicitud_engorda.idUsuario' => $this->session->userdata('logged_user')->usu_id),
                'order' => array( 'Solicitud_engorda.Fecha' => 'ASC' ))); 
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('ganaderia/obtener_pdf_engorda', $this->param, 'ganaderia/delete_engorda');
        //$this->template['action'] = site_url('ganaderia/crear'); 
        $this->_run('tabla_ver');	
	}

  public function index_lechero(){
        $this->template['titulo'] = 'Formulacion - Lechero';
        $campos = $this->oGanaderiaLechero->find('result',array( 
                'fields' => array('Solicitud_lechero.idSolicitud_Lechero','Solicitud_lechero.idSolicitud_Lechero as ID','Solicitud_lechero.idSolicitud_Lechero as ID','Solicitud_lechero.Solicitante',"DATE_FORMAT(Solicitud_lechero.Fecha,'%d/%m/%Y - %h:%i:%s')",'Solicitud_lechero.Tipo_Cliente','Status_solicitud.Status',"Status_solicitud.Comentario"),
                'join' => array(
                    'clause' => array(
                        'Status_solicitud' => 'Status_solicitud.Status = Solicitud_lechero.StatusSolicitud and Status_solicitud.idSolicitud = Solicitud_lechero.idSolicitud_Lechero AND Status_solicitud.Formato = Solicitud_lechero.Formato'
                    ),
                    'type' => 'INNER'
                ),
                'conditions' => array('Solicitud_lechero.Status' => 1),
                'conditions' => array('Solicitud_lechero.idUsuario' => $this->session->userdata('logged_user')->usu_id),
                'order' => array( 'Solicitud_lechero.Fecha' => 'DESC' ))); 
        $this->param2 = array_merge($this->param2, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('ganaderia/obtener_pdf_lechero', $this->param2, 'ganaderia/delete_lechero');
        //$this->template['action'] = site_url('ganaderia/crear'); 
        $this->_run('tabla_ver'); 
  }

    public function crear() {
        try{
        $this->template['titulo'] = 'SOLICITUD GANADERIA';
        $this->oGanaderia->prepararForm();
        $id = $this->uri->segment(3);
        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        $datos = '';
        //$idproducto = $this->oGanaderia->GET('Producto','*');
        $idingrediente = $this->oGanaderia->GET('Ingrediente','*',"Clasificacion not in('FORRAJES')");
        $idforraje = $this->oGanaderia->GET('Ingrediente','*','Clasificacion = "FORRAJES"');
        //$idfases = $this->oGanaderia->GET('fase','*');
        $fases = "<option value='0'>Seleccione una Fase</option>";
        /* foreach($idfases as $rows){
            $fases .= "<option value=".$rows->idFase.">".$rows->Fase."</option>";
        } */
        $producto = "<option value='0'>Selecciona un Micro</option>";
        /* foreach($idproducto as $rows){
            $producto .= "<option value=".$rows->idProducto.">".$rows->Producto."</option>";
        } */
        $ingrediente = "<option value='0'>Seleccione un Ingrediente</option>";
        foreach($idingrediente as $rows){
            $ingrediente .= "<option value=".$rows->idIngrediente.">".$rows->Ingrediente."</option>";
        }
        $especificacion = "<option value='0'>Seleccione una Especificacion</option>";
        $forraje = "<option value='0'>Seleccione un Forraje</option>";
        foreach($idforraje as $rows){
            $forraje .= "<option value=".$rows->idIngrediente.">".$rows->Ingrediente."</option>";
        }
        $this->template['idProducto'] = $producto;
        $this->template['idIngrediente'] = $ingrediente;
        $this->template['idEspecificacion'] = $especificacion;
        $this->template['idFase'] = $fases;
        $this->template['idForraje'] = $forraje;
        json_encode($producto);
        json_encode($ingrediente);
        json_encode($especificacion);
        json_encode($fases);
        json_encode($forraje);
        if(is_numeric($id))
            $this->template['action'] = site_url('ganaderia/crear');
            $datos = $this->oGanaderia->find('list',array('conditions' => array( 'idSolicitud_Engorda' => $id )));
            $this->template['formulario'] = $this->_getForm(
                            'ganaderia/crear'.'/'.$id,
                            $this->oGanaderia->schema,
                            $datos,
                            "solicitud",
                            'form-inline',
                            'form-inline',
                            FALSE,
                            $this->oGanaderia->schema_up,
                            TRUE);

            $datos = $this->input->post(NULL, TRUE);
            if($datos){
              if($datos['Formato'] != "2"){

                  $directorio = "./assets/upload/formulacion/analisis/";
                  $archivo = $directorio.basename($_FILES[$_POS]["Name"]);
                  $Tipo = pathinfo($archivo,PATHINFO_EXTENSION);

                  $id = $this->oGanaderia->GuardarSolicitudEngorda($datos);
                  /* ENVIO DE PDF */
                  $contenido = $this->oGanaderia->get('Solicitud_engorda','*',"idsolicitud_Engorda = ".$id);
                  $detalle_contenido = $this->oGanaderia->detalle_solicitud_engorda($id);

                  foreach($contenido as $row){
                     $this->template['formato'] = $row->Formato;
                     $this->template['idsolicitud'] = $row->idSolicitud_Engorda;
                     $this->template['fecha'] = $row->Fecha;
                     $this->template['solicitante'] = $row->Solicitante;
                     $this->template['tipo_cliente'] = $row->Tipo_Cliente;
                     $this->template['nombre_cliente'] = $row->Nombre_Cliente;
                     $this->template['telefono'] = $row->Telefono;
                     $this->template['cabezas'] = $row->NoCabezas;
                     $this->template['implante'] = $row->Implante;
                     $this->template['desparasitante'] = $row->Desparasitante;
                     $this->template['vacuna'] = $row->Vacuna;
                     $this->template['tipo_ganado'] = $this->oGanaderia->get('Tipo_ganado','TipoGanado',"idTipo_Ganado =".$row->idTipo_Ganado);
                     $this->template['tipo_mezclado'] = $this->oGanaderia->get('Tipo_mezclado','TipoMezclado',"idTipo_Mezclado =".$row->idTipo_Mezclado);
                     $this->template['produccion'] = $row->Produccion;
                     $this->template['secas'] = $row->Secas;
                     $this->template['reemplazos'] = $row->Reemplazos;
                     $this->template['grasa'] = $row->PorcentajeGrasa;
                     $this->template['prodleche'] = $row->ProduccionLeche;
                     $this->template['alimentacion'] = $row->Alimentacion;
                     $this->template['comentarios'] = $row->Comentario;
                     $ingredientes = $this->oGanaderia->detalle_solicitud_gnral($id,$row->Formato);
                     //Datos Envio Correo
                     $correo = $row->Correo;
                     $Solicitante = $row->Solicitante;
                  }

                    $this->template['detalle_solicitud'] = $detalle_contenido;
                    $this->template['ingredientes'] = $ingredientes;

                    $html = $this->load->view('formulacion/local/pdf', $this->template);
                    $this->html2pdf->folder('./assets/upload/formulacion/solicitudes/');
                    $this->html2pdf->filename("formulacion_ganaderia_".$id.".pdf");
                    $this->html2pdf->paper('A4', 'portrait');
                    $this->html2pdf->html($this->load->view('formulacion/local/pdf', $html, TRUE));
                  
                  /* ENVIO DE PDF */
                  if($path = $this->html2pdf->create('save')) {
                    //PDF was successfully saved or downloaded
                    //$ruta = base_url()."assets/img/pedidos_firma.jpg";
                    /* $this->email->from('web@vimifos.com','Vimifos');

                    $sol_correos = $this->session->userdata('logged_user')->usu_email.",".$correo.",mberumen@vimifos.com";
                    $list_correos = "dvilla@vimifos.com,".$sol_correos;
                    $this->email->to($list_correos); */
              
                    $this->email->subject('::VIMIFOS::Formulacion');
                    $message = "<fieldset>
                    <fieldset>
                      <legend>
                        <strong>Estimado Cliente {$Solicitante}</strong>
                      </legend>
                      <p> 
                        '' Se Recibio solicitud de formulaci&oacute;n, con exito. Favor de revisar el status de su solicitud adjunta y corroborar que se encuentre correcta. Una vez actualizada el status a Revision esta no podra ser eliminada.'' 
                      </p> 
                    </fieldset>";
                    $this->email->message($message);
                    $this->email->attach($path);
                    /* $this->email->send(); */
                  }
                  redirect(base_url()."index.php/ganaderia");
              } else {
                  $id = $this->oGanaderia->GuardarSolicitudLechero($datos);

                  /* ENVIO DE PDF */
                  $contenido = $this->oGanaderia->get('Solicitud_lechero','*',"idsolicitud_Lechero = ".$id);
                  foreach($contenido as $row){
                     $this->template['formato'] = $row->Formato;
                     $this->template['idsolicitud'] = $row->idSolicitud_Lechero;
                     $this->template['fecha'] = $row->Fecha;
                     $this->template['solicitante'] = $row->Solicitante;
                     $this->template['tipo_cliente'] = $row->Tipo_Cliente;
                     $this->template['nombre_cliente'] = $row->Nombre_Cliente;
                     $this->template['telefono'] = $row->Telefono;
                     $this->template['cabezas'] = $row->NoCabezas;
                     $this->template['alimentacion'] = $row->Alimentacion;
                     $this->template['produccion'] = $row->Produccion;
                     $this->template['secas'] = $row->Secas;
                     $this->template['reemplazos'] = $row->Reemplazos;
                     $this->template['produccionleche'] = $row->ProduccionLeche;
                     $this->template['porcentajegrasa'] = $row->PorcentajeGrasa;
                     $this->template['comentarios'] = $row->Comentario;
                     $this->template['idProducto'] = $row->idProducto;
                     $this->template['vacas'] = $row->Vacas;
                     $this->template['precioproducto'] = $row->PrecioProducto;
                     $this->template['ReemplazosMicro'] = $row->ReemplazosMicro;
                     $ingredientes = $this->oGanaderia->detalle_solicitud_gnral($id,$row->Formato);
                     //Datos Envio Correo
                     $correo = $row->Correo;
                     $Solicitante = $row->Solicitante;
                  }

                    $this->template['ingredientes'] = $ingredientes;

                    $html = $this->load->view('formulacion/local/pdfl', $this->template);
                    $this->html2pdf->folder('./assets/upload/formulacion/solicitudes/');
                    $this->html2pdf->filename("formulacion_lechero_".$id.".pdf");
                    $this->html2pdf->paper('A4', 'portrait');
                    $this->html2pdf->html($this->load->view('formulacion/local/pdfl', $html, TRUE));
                  
                  /* ENVIO DE PDF */
                  if($path = $this->html2pdf->create('save')) {
                    //PDF was successfully saved or downloaded
                    //$ruta = base_url()."assets/img/pedidos_firma.jpg";
                    /* $this->email->from('web@vimifos.com','Vimifos');

                    $sol_correos = $this->session->userdata('logged_user')->usu_email.",".$correo.",mberumen@vimifos.com";
                    $list_correos = "dvilla@vimifos.com,".$sol_correos;
                    $this->email->to($list_correos); */
              
                    $this->email->subject('::VIMIFOS::Formulacion');
                    $message = "
                    <fieldset>
                      <legend>
                        <strong>Estimado Cliente {$Solicitante}</strong>
                      </legend>
                      <p> 
                        '' Se Recibio solicitud de formulaci&oacute;n, con exito. Favor de revisar el status de su solicitud adjunta y corroborar que se encuentre correcta. Una vez actualizada el status a Revision esta no podra ser eliminada.'' 
                      </p> 
                    </fieldset>";
                    $this->email->message($message);
                    $this->email->attach($path);
                    /* $this->email->send(); */
                  }
                  redirect(base_url()."index.php/ganaderia/index_lechero");
              }
          }

        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }  
        
        if($this->input->post('eliminar',TRUE) != NULL)
            $this->index();
        else
            $this->_run('crud');
        }

        public function llenar_producto(){
            $options = "";
            if($this->input->post('idFase')){
              $producto = $this->oGanaderia->buscar_producto($this->input->post('idFase'));
              foreach($producto as $row){
              ?>
                <option value=<?php echo $row->idProducto; ?>><?php echo $row->Producto; ?></option>
              <?php
              }
            }
        }

        public function llenar_especificacion(){
            $options = "";
            if($this->input->post('idIngrediente')){
              $especificacion = $this->oGanaderia->get("Especificacion","idEspecificacion,Especificacion","idIngrediente =".$this->input->post('idIngrediente'));
              foreach($especificacion as $row){
              ?>
                <option value=<?php echo $row->Especificacion; ?>><?php echo $row->Especificacion; ?></option>
              <?php
              }
            }
        }

        public function llenar_tipo_ganado(){
            $options = "";
            $Formato = $this->input->post('Formato');
            if($Formato){
              $tipo_ganado = $this->oGanaderia->get("Tipo_ganado","*","idEtapa =".$Formato);
              foreach($tipo_ganado as $row){
              ?>
                <option value=<?php echo $row->idTipo_Ganado; ?>><?php echo $row->TipoGanado; ?></option>
              <?php
              }
            }
        }

        public function llenar_fase(){
            $options = "";
            $Formato = $this->input->post('Formato');
            if($Formato){
              /* if($this->input->post('Formato') == "OVINO"){ */
                $fase = $this->oGanaderia->get("Detalle_etapa","*","idEtapa =".$Formato);
              /* } else if($this->input->post('Formato') == "FINALIZACION"){
                $fase = $this->oGanaderia->get("detalle_etapa","*","idEtapa = 1");
               } */
              ?>
                <option value='0'>Seleccione una Fase</option>
              <?php
              foreach($fase as $row){
              ?>
                <option value=<?php echo $row->idDetalle_Etapa; ?>><?php echo $row->Descripcion; ?></option>
              <?php
              }
            }
        }

        public function obtener_pdf_lechero(){
            $id = $this->uri->segment(3);
            $contenido = $this->oGanaderia->get('Solicitud_lechero','*',"idsolicitud_Lechero = ".$id);
                  foreach($contenido as $row){
                     $this->template['formato'] = $row->Formato;
                     $this->template['idsolicitud'] = $row->idSolicitud_Lechero;
                     $this->template['fecha'] = $row->Fecha;
                     $this->template['solicitante'] = $row->Solicitante;
                     $this->template['tipo_cliente'] = $row->Tipo_Cliente;
                     $this->template['nombre_cliente'] = $row->Nombre_Cliente;
                     $this->template['telefono'] = $row->Telefono;
                     $this->template['cabezas'] = $row->NoCabezas;
                     $this->template['alimentacion'] = $row->Alimentacion;
                     $this->template['produccion'] = $row->Produccion;
                     $this->template['secas'] = $row->Secas;
                     $this->template['reemplazos'] = $row->Reemplazos;
                     $this->template['produccionleche'] = $row->ProduccionLeche;
                     $this->template['porcentajegrasa'] = $row->PorcentajeGrasa;
                     $this->template['comentarios'] = $row->Comentario;
                     $this->template['Producto'] = $this->oGanaderia->get('Producto','*',"idProducto = ".$row->idProducto);
                     $this->template['vacas'] = $row->Vacas;
                     $this->template['precioproducto'] = $row->PrecioProducto;
                     $this->template['ReemplazosMicro'] = $row->ReemplazosMicro;
                     $ingredientes = $this->oGanaderia->detalle_solicitud_gnral($id,$row->Formato);
                  }
                  $this->template['ingredientes'] = $ingredientes;

                    $html = $this->load->view('formulacion/local/pdfl', $this->template);
                    $this->html2pdf->folder('./assets/upload/formulacion/solicitudes/');
                    $this->html2pdf->filename("formulacion_lechero_".$id.".pdf");
                    $this->html2pdf->paper('A4', 'portrait');
                    $this->html2pdf->html($this->load->view('formulacion/local/pdfl', $html, TRUE));
                    $this->html2pdf->create('save');
                    redirect(base_url()."assets/upload/formulacion/solicitudes/formulacion_lechero_".$id.".pdf");
        }

        public function obtener_pdf_engorda(){

            $id = $this->uri->segment(3);
            $contenido = $this->oGanaderia->get('Solicitud_engorda','*',"idsolicitud_Engorda = ".$id);
            $detalle_contenido = $this->oGanaderia->detalle_solicitud_engorda($id);

            foreach($contenido as $row){
               $this->template['formato'] = $row->Formato;
               $this->template['idsolicitud'] = $row->idSolicitud_Engorda;
               $this->template['fecha'] = $row->Fecha;
               $this->template['solicitante'] = $row->Solicitante;
               $this->template['tipo_cliente'] = $row->Tipo_Cliente;
               $this->template['nombre_cliente'] = $row->Nombre_Cliente;
               $this->template['telefono'] = $row->Telefono;
               $this->template['cabezas'] = $row->NoCabezas;
               $this->template['implante'] = $row->Implante;
               $this->template['desparasitante'] = $row->Desparasitante;
               $this->template['vacuna'] = $row->Vacuna;
               $this->template['tipo_ganado'] = $this->oGanaderia->get('Tipo_ganado','TipoGanado',"idTipo_Ganado =".$row->idTipo_Ganado);
               $this->template['tipo_mezclado'] = $this->oGanaderia->get('Tipo_mezclado','TipoMezclado',"idTipo_Mezclado =".$row->idTipo_Mezclado);
               $this->template['produccion'] = $row->Produccion;
               $this->template['secas'] = $row->Secas;
               $this->template['reemplazos'] = $row->Reemplazos;
               $this->template['grasa'] = $row->PorcentajeGrasa;
               $this->template['prodleche'] = $row->ProduccionLeche;
               $this->template['alimentacion'] = $row->Alimentacion;
               $this->template['comentarios'] = $row->Comentario;
              $ingredientes = $this->oGanaderia->detalle_solicitud_gnral($id,$row->Formato);
            }

            $this->template['detalle_solicitud'] = $detalle_contenido;
            $this->template['ingredientes'] = $ingredientes;

              $html = $this->load->view('formulacion/local/pdf', $this->template);

              //Set folder to save PDF to
              $this->html2pdf->folder('./assets/upload/formulacion/solicitudes/');

              //Set the filename to save/download as
              $this->html2pdf->filename("formulacion_ganaderia_".$id.".pdf");

              //Set the paper defaults
              $this->html2pdf->paper('A4', 'portrait');
              
              //Load html view
              $this->html2pdf->html($this->load->view('formulacion/local/pdf', $html, TRUE));
              $this->html2pdf->create('save');
              redirect(base_url()."assets/upload/formulacion/solicitudes/formulacion_ganaderia_".$id.".pdf");


          }

        function analisis(){
          $id = $this->uri->segment(3);
          $analisis = $this->oGanaderia->get("Solicitud_engorda","*","idsolicitud_Engorda =".$id);
          foreach($analisis as $row){
            header("Content-type: {$row->Tipo_Analisis}");
            /* header('Content-Disposition: attachment; <span id="IL_AD12" class="IL_AD">filename</span>="'.$row->Nombre_Analisis.'"'); */
            print $row->Archivo_Analisis;
          }
        } 


        function delete_engorda() {
            $id = $this->uri->segment(3);
            $solicitud = $this->oGanaderia->get("Solicitud_engorda","*","idsolicitud_Engorda =".$id);
            foreach($solicitud as $row){
              if($row->StatusSolicitud == "RECIBIDA"){
                $this->oGanaderia->delete_t($id);
                $this->index();
              } else{
                $this->template['errores'] = "<br><div class='panel-body' style='color:red;' align='center'><b>**NO SE PUEDE ELIMINAR SOLICITUD #".$row->idSolicitud_Engorda." CON STATUS ".$row->StatusSolicitud.".**</b></div>";
                $this->index(); 
              }
            }
            
        }

        function delete_lechero() {
            $id = $this->uri->segment(3);
            $solicitud = $this->oGanaderia->get("Solicitud_lechero","*","idsolicitud_Lechero =".$id);
            foreach($solicitud as $row){
              if($row->StatusSolicitud == "RECIBIDA"){
                $this->oGanaderia->delete_l($id);
                $this->index();
              } else{
                $this->template['errores'] = "<br><div class='panel-body' style='color:red;' align='center'><b>**NO SE PUEDE ELIMINAR SOLICITUD #".$row->idSolicitud_Lechero." CON STATUS ".$row->StatusSolicitud.".**</b></div>";
                $this->index_lechero(); 
              }
            }
            
        }
    }