<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Tesoreria_reportes extends MY_Controller {

    function __construct(){
        parent::__construct();
        $dbBase = $this->load->database('tesoreria',TRUE);
        $this->load->model('tesoreria/reporte_model');
        $this->load->helper('form');
        $this->template['module'] = 'tesoreria';
    }

    function index(){
        $this->template['title'] = 'reportes';
        $this->template['title2'] = 'notificaciones';
        $this->template['fecha'] = date('Y-m-d');    
        $this->_run('reportes/home');
    }

    function reportecta(){

        $this->load->library('pdf');
        $pdfrepor = $this->reporte_model->reportcta();
        $title = 'Reporte de movimientos de hoy';
        $fMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $fDias = array( 'Domingo', 'Lunes', 'Martes','Miercoles', 'Jueves', 'Viernes', 'Sabado');
        $fhoy = $fDias[date('w')].", ".date('d')." de ".$fMeses[date('m')-1]." de ".date('Y');
        $fhoycorto = date("Y/m/d");
     
        // Fechas
        $fechadia = "Fecha de impresión: ".$fhoycorto;

        $this->pdf = new pdf();
        $this->pdf->AddPage('P');
        $this->pdf->AliasNbPages();
        $this->pdf->SetTitle("Reporte de Cuentas- SIT");
        $this->pdf->SetLeftMargin(20);
        $this->pdf->SetRightMargin(20);
        $this->pdf->SetFillColor(200,200,200);
     
        $this->pdf->SetFont('Arial','B', 8);
        $this->pdf->Cell(10,7,'#','TBL',0,'C','1');
        $this->pdf->Cell(40,7,'NOMBRE DE UNIDAD','TB',0,'L','1');
        $this->pdf->Cell(40,7,'DIVISA','TB',0,'L','1');
        $this->pdf->Cell(40,7,'CUENTA','TBR',0,'L','1');
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial', '', 6);
        foreach ($pdfrepor as $pdfrepor) {

            $cta = $pdfrepor->cue_nombre.' '.$pdfrepor->cue_numero;

          $this->pdf->Cell(10,5,$pdfrepor->cue_id,'BL',0,'C',0);
          $this->pdf->Cell(40,5,$pdfrepor->une_nombre,'B',0,'L',0);
          $this->pdf->Cell(40,5,$pdfrepor->cue_divisa,'B',0,'L',0);
          $this->pdf->Cell(40,5,$cta,'BR',0,'L',0);
          $this->pdf->Ln(5);
        }

        $nombredelarchivo = 'reportedecta-'.$fhoycorto.'.pdf';

        ob_end_clean();
        $this->pdf->Output($nombredelarchivo, 'I');
  
    }

    function reportecd_f(){
        $data = array(
                'fecha'=> $this->input->post('fecha')
        );
        $fecha = $data['fecha'];

        $this->load->library('pdf');
        $pdfrepor = $this->reporte_model->reportecd_f($fecha);
        $title = 'Reporte de movimientos de hoy';
        $fMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $fDias = array( 'Domingo', 'Lunes', 'Martes','Miercoles', 'Jueves', 'Viernes', 'Sabado');
        $fhoy = $fDias[date('w')].", ".date('d')." de ".$fMeses[date('m')-1]." de ".date('Y');
        $fhoycorto = date("Y/m/d");
     
        // Fechas
        $fechareport = "Fecha de reporte: ".$fecha;
        $fechadia = "Fecha de impresión: ".$fhoycorto;

        $this->pdf = new pdf();
        $this->pdf->AddPage('L');
        $this->pdf->AliasNbPages();
        $this->pdf->SetTitle("Reporte de Compra de Divisas - SIT");
        $this->pdf->SetLeftMargin(20);
        $this->pdf->SetRightMargin(20);
        $this->pdf->SetFillColor(200,200,200);
     
        $this->pdf->SetFont('Arial','B', 9);
        $this->pdf->SetY(20);
        $this->pdf->Cell(240,10,$fechareport,0,0,'R');
        $this->pdf->Ln(5);

        $this->pdf->Ln(10);
        $this->pdf->SetFont('Arial','B', 8);
        $this->pdf->Cell(40,7,'UNIDAD DE NEGOCIOS','TBL',0,'C','1');
        $this->pdf->Cell(65,7,'CUENTA ORIGEN','TB',0,'C','1');
        $this->pdf->Cell(65,7,'CUENTA DESTINO','TB',0,'C','1');
        $this->pdf->Cell(25,7,'MONTO','TB',0,'C','1');
        $this->pdf->Cell(15,7,'DIVISA','TB',0,'C','1');
        $this->pdf->Cell(25,7,'TIPO DE CAMBIO','TB',0,'C','1');
        $this->pdf->Cell(25,7,'OPERACIÓN','TB',0,'C','1');
        $this->pdf->Cell(25,7,'INSTITUCIÓN','TBR',0,'C','1');
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial', '', 6);
        foreach ($pdfrepor as $pdfrepor) {

            $corigen = $pdfrepor->T1C.' '.$pdfrepor->T2CD.' '.$pdfrepor->T1N.' '.$pdfrepor->B1N;
            $cdestino = $pdfrepor->T2C.' '.$pdfrepor->T1CD.' '.$pdfrepor->T2N.' '.$pdfrepor->B2N;

          $this->pdf->Cell(40,5,$pdfrepor->une_nombre,'BL',0,'C',0);
          $this->pdf->Cell(65,5,$corigen,'B',0,'C',0);
          $this->pdf->Cell(65,5,$cdestino,'B',0,'C',0);
          $this->pdf->Cell(25,5,'$'.number_format($pdfrepor->tra_monto,2, '.',','),'B',0,'C',0);
          $this->pdf->Cell(15,5,$pdfrepor->tra_divisa,'B',0,'C',0);
          $this->pdf->Cell(25,5,'$'.number_format($pdfrepor->tra_tc,2, '.',','),'B',0,'C',0);
          $this->pdf->Cell(25,5,$pdfrepor->tra_descripcion,'B',0,'C',0);
          $this->pdf->Cell(25,5,$pdfrepor->tra_responsable,'BR',0,'C',0);
          $this->pdf->Ln(5);
        }

        $nombredelarchivo = 'reportecompradivisas-'.$fhoycorto.'.pdf';

        ob_end_clean();
        $this->pdf->Output($nombredelarchivo, 'I');
  
    }

    function reportetrapasos_f(){
        $data = array(
                'fecha'=> $this->input->post('fecha')
        );
        $fecha = $data['fecha'];

        // Se carga la libreria fpdf
        $this->load->library('pdf');
        // Se obtienen los alumnos de la base de datos
        $pdfrepor = $this->reporte_model->reportetrapasos_f($fecha);

        $title = 'Reporte de movimientos de hoy';
        // Fechas meses y dias
        $fMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $fDias = array( 'Domingo', 'Lunes', 'Martes','Miercoles', 'Jueves', 'Viernes', 'Sabado');
        $fhoy = $fDias[date('w')].", ".date('d')." de ".$fMeses[date('m')-1]." de ".date('Y');
        $fhoycorto = date("Y/m/d");
        // Creacion del PDF
     
        // Fechas
        $fechareport = "Fecha de reporte: ".$fecha;
        $fechadia = "Fecha de impresión: ".$fhoycorto;
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new pdf();

        // Agregamos una página
        $this->pdf->AddPage('L');
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
     
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Reporte Movimientos Bancarios - SIT");
        $this->pdf->SetLeftMargin(20);
        $this->pdf->SetRightMargin(20);
        $this->pdf->SetFillColor(200,200,200);
     
        // Se define el formato de fuente: Arial, negritas, tamaño 9

        $this->pdf->SetFont('Arial','B', 9);
        $this->pdf->SetY(20);
        $this->pdf->Cell(0,10,$fechareport,0,0,'R');
        $this->pdf->Ln(5);

        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        $this->pdf->Ln(10);
        $this->pdf->SetFont('Arial','B', 8);
        $this->pdf->Cell(40,7,'UNIDAD DE NEGOCIOS','TBL',0,'C','1');
        $this->pdf->Cell(65,7,'CUENTA ORIGEN','TB',0,'C','1');
        $this->pdf->Cell(65,7,'CUENTA DESTINO','TB',0,'C','1');
        $this->pdf->Cell(15,7,'DIVISA','TB',0,'C','1');
        $this->pdf->Cell(25,7,'MONTO','TB',0,'C','1');
        $this->pdf->Cell(25,7,'MOVIMIENTO','TB',0,'C','1');
        $this->pdf->Cell(25,7,'OPERADO','TBR',0,'C','1');
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial', '', 6);
        foreach ($pdfrepor as $pdfrepor) {

            $corigen = $pdfrepor->T1C.' '.$pdfrepor->T2CD.' '.$pdfrepor->T1N.' '.$pdfrepor->B1N;
            $cdestino = $pdfrepor->T2C.' '.$pdfrepor->T1CD.' '.$pdfrepor->T2N.' '.$pdfrepor->B2N;

          // Se imprimen los datos de cada pdfrepor
          $this->pdf->Cell(40,5,$pdfrepor->une_nombre,'BL',0,'C',0);
          $this->pdf->Cell(65,5,$corigen,'B',0,'C',0);
          $this->pdf->Cell(65,5,$cdestino,'B',0,'C',0);
          $this->pdf->Cell(15,5,$pdfrepor->divisa,'B',0,'C',0);
          $this->pdf->Cell(25,5,'$'.number_format($pdfrepor->tra_monto,2, '.',','),'B',0,'C',0);
          $this->pdf->Cell(25,5,$pdfrepor->tra_descripcion,'B',0,'C',0);
          $this->pdf->Cell(25,5,$pdfrepor->tra_responsable,'BR',0,'C',0);
          //Se agrega un salto de linea
          $this->pdf->Ln(5);
        }
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $nombredelarchivo = 'reportedemovimientos-'.$fhoycorto.'.pdf';

        ob_end_clean();
        $this->pdf->Output($nombredelarchivo, 'I');
  
    }
   
    function saldosunes_f(){
        $data = array(
                'fecha'=> $this->input->post('fecha')
        );
        $fecha = $data['fecha'];
        // Se carga la libreria fpdf
        $this->load->library('pdf');
        // Se obtienen los alumnos de la base de datos
        $pdfrepor = $this->reporte_model->saldosunes_f($fecha);
        $title = 'Reporte de movimientos de hoy';
        $fhoycorto = date("Y/m/d");
        // Creacion del PDF
     
        // Fechas
        $fechareport = "Fecha de reporte: ".$fecha;
        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new pdf();

        // Agregamos una página
        $this->pdf->AddPage('L');
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
     
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Reporte de Saldos Bancarios - SIT");
        $this->pdf->SetLeftMargin(20);
        $this->pdf->SetRightMargin(20);
        $this->pdf->SetFillColor(200,200,200);
     
        // Se define el formato de fuente: Arial, negritas, tamaño 9

        $this->pdf->SetFont('Arial','B', 9);
        $this->pdf->SetY(20);
        $this->pdf->Cell(245,10,$fechareport,0,0,'R');
        $this->pdf->Ln(5);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
        foreach ($pdfrepor as $pdfrepor) {
            $nombreune = $pdfrepor->une_nombre.' '.$pdfrepor->cue_descripcion.' '.$pdfrepor->cue_divisa;
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial','B', 8);
        $this->pdf->Ln(5);

        $this->pdf->SetFont('Arial','B', 8);
        $this->pdf->SetX(70);
        $this->pdf->Cell(80,7,'CUENTA','TBL',0,'C','1');
        $this->pdf->Cell(40,7,'SALDO INICIAL','TB',0,'C','1');
        $this->pdf->Cell(40,7,'SALDO FINAL DEL DIA','TBR',0,'C','1');
        $this->pdf->Ln(7);

            $this->pdf->SetFont('Arial', '', 7);
            $this->pdf->SetX(70);
            $this->pdf->Cell(80,5,$nombreune,'BL',0,'C',0);
            $this->pdf->Cell(40,5,'$'.number_format($pdfrepor->cued_sald_ini,2, '.',','),'B',0,'C',0);
            $this->pdf->Cell(40,5,'$'.number_format($pdfrepor->cued_sald_fin,2, '.',','),'BR',0,'C',0);

            //Se agrega un salto de linea
        }
        
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $nombredelarchivo = 'reportedemovimientos-'.$fhoycorto.'.pdf';

        ob_end_clean();
        $this->pdf->Output($nombredelarchivo, 'I');        
    } 



    function notif_saldos(){
        $data = array(
                'usuario'=> $this->input->post('usuario')
        );
        $usuario = $data['usuario'];
        $this->template['usuario'] = $data['usuario'];
        $this->load->library('email');
        $this->email->from('web@vimifos.com', 'Notificaciones Vimifos - SIT');
        $this->email->to('jsoto@vimifos.com');
        $this->email->cc('jmquiroz@vimifos.com');
        $this->email->subject('Notificación de Captura de saldos de '.$usuario);
        $this->email->message($usuario.' a capturado el saldo inicial de sus cuentas.');
        $this->email->send();
        redirect(base_url('reportes/'));
    }





}