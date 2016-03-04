<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * estadoscta_estados.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */


class Estadoscta_Comprobantesco extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('estadoscta/comprabantesco_model','oComprobantes');
        $this->load->library('pagination');
        $this->load->library('zip');
        $this->cliente = $this->oComprobantes->cliente($this->session->userdata('logged_user')->usu_id);
        $this->rows = $this->oComprobantes->Encabezado($this->cliente->usu_usuario);
        $this->template['module'] = 'estadoscta';
        $this->template['titulo'] = 'Comprobantes Fiscales Comercializadora Vimifos';
        $this->template['usuario'] = $this->cliente->usu_nombre;
        $this->template['url'] = site_url('comprobantesco/index');
        $this->rfc = $this->oComprobantes->obtenerrfc($this->cliente->usu_usuario);
    }
    
    public function index()
    {
        $facturas = "";
        $rows_facturas = "";

        if($this->input->post('folio', TRUE))
            $param = $this->input->post('folio', TRUE);
        else
            $param = $this->uri->segment(4);

        $config['base_url'] = site_url('comprobantesco/index');
        $config['first_url'] = site_url('comprobantesco/index/0/'.$this->uri->segment(4));
        //$config['total_rows'] = $this->oComprobantes->filas($this->rfc->cliente_rfc,$param);

        if($param)
            $config['suffix'] = '/'.$param;

        $config['per_page'] = 10;
        $config['num_links'] = 20; 
        $config['first_link'] = 'Primera';
        $config['last_link'] = 'Última';
        //$this->pagination->initialize($config); 

         if($this->uri->segment(4))
            $param = $this->uri->segment(4);

        if(substr($this->cliente->usu_usuario,0,1) == "G"){
            $rfc_concat = "";
            foreach($this->rfc as $rows){
                $rfc_concat .= "'".$rows->cliente_rfc."',";
            }
            $rfc_concat = substr($rfc_concat, 0, -1);
            $config['total_rows'] = $this->oComprobantes->filasG($rfc_concat,$param);
            $rows_facturas = $this->oComprobantes->ContenidoG($config['per_page'],$this->uri->segment(3),$rfc_concat,$param);
            $this->pagination->initialize($config); 
            if($rows_facturas){
                foreach($rows_facturas as $row) { 
                    $facturas .= "<tr>
                        <td>#</td><td>".$row->serie."</td>
                        <td>".$row->folio."</td>
                        <td>".$row->fecha."</td>
                        <td>$".number_format($row->subTotal,2)."</td>
                        <td>$".number_format($row->total,2)."</td>
                        <td><a href='".site_url('comprobantesco/generar_pdfG/')."/".$row->id_Comprobante."' target='_blank' class='fa fa-file-pdf-o fa-lg'>&nbsp;</a></td>
                        <td><a href='".site_url('comprobantesco/generar_zipG/')."/".$row->id_Comprobante."' target='_blank' class='fa fa-file-archive-o fa-lg'>&nbsp;</a></td>
                        </tr>";
                }
            }else{
                $facturas = "<tr><td>#</td><td align='center' colspan='7'>No se encontraron registros</td></tr>";
            }
        }else{
            $config['total_rows'] = $this->oComprobantes->filas($this->rfc->cliente_rfc,$param);
            $rows_facturas = $this->oComprobantes->Contenido($config['per_page'],$this->uri->segment(3),$this->rfc->cliente_rfc,$param);
            $this->pagination->initialize($config);
            if($rows_facturas){
                foreach($rows_facturas as $row) { 
                    $facturas .= "<tr>
                        <td>#</td><td>".$row->serie."</td>
                        <td>".$row->folio."</td>
                        <td>".$row->fecha."</td>
                        <td>$".number_format($row->subTotal,2)."</td>
                        <td>$".number_format($row->total,2)."</td>
                        <td><a href='".site_url('comprobantesco/generar_pdf/')."/".$row->id_Comprobante."' target='_blank' class='fa fa-file-pdf-o fa-lg'>&nbsp;</a></td>
                        <td><a href='".site_url('comprobantesco/generar_zip/')."/".$row->id_Comprobante."' target='_blank' class='fa fa-file-archive-o fa-lg'>&nbsp;</a></td>
                        </tr>";
                }
            }else{
                $facturas = "<tr><td>#</td><td align='center' colspan='7'>No se encontraron registros</td></tr>";
            }
        }

        $this->template['contenido'] = $facturas;
        $this->template['pag'] = $this->pagination->create_links();
        $this->_run('comprobantes_vimifos');
    }    

    public function generar_pdf($idcomprobante){
        ini_set("mssql.textlimit" , "2147483647");
        ini_set("mssql.textsize" , "2147483647");

        $factura_fld = $this->oComprobantes->facturas_antiguas($this->rfc->cliente_rfc,$idcomprobante);
        $factura_db = $this->oComprobantes->facturas_nuevas($this->rfc->cliente_rfc,$idcomprobante);

        if($factura_fld)
            $row = $factura_fld;
        else
            $row = $factura_db;

        $pdf="";
        $ceros="";
        if($row->folio <= 9)
            $ceros="00000000000";
        if($row->folio > 9)
            $ceros="0000000000";
        if($row->folio >= 100)
            $ceros="000000000";
        if($row->folio >= 1000)
            $ceros="00000000";
        if($row->folio >= 10000)
            $ceros="0000000";
        $pdf.=$row->estatus."EFE060511IA7-".$row->serie.$ceros.$row->folio;
        $pdf=trim($pdf);

        if($factura_fld){
            if(file_exists("/home/parametrosCFDI/EFE060511IA7/".$pdf.".pdf")){
                $rutav = "/home/parametrosCFDI/EFE060511IA7/".$pdf.".pdf";
                $nom_pdf = $pdf;
            }else{
                $rutav = "/home/comerpdf/".$pdf.".pdf";
                $nom_pdf = $pdf;
            }

            header("Content-type: application/pdf");
            header("Content-Disposition: attachment; filename=".$nom_pdf.".pdf");
            readfile($rutav);

        }else if($factura_db){
            $nombre_pdf = $row->estatus."EFE060511IA7-bd-".$row->serie.$row->folio;
            $fact = $this->oComprobantes->factura_pdfxml($idcomprobante);
            header("Content-type: application/pdf");
            header("Content-Disposition: attachment; filename=".$nombre_pdf.".pdf");
            echo $fact->pdf;
        }
    }

        public function generar_pdfG($idcomprobante){
        ini_set("mssql.textlimit" , "2147483647");
        ini_set("mssql.textsize" , "2147483647");

        $rfc_concat = "";
        foreach($this->rfc as $rows){
            $rfc_concat .= "'".$rows->cliente_rfc."',";
        }
        $rfc_concat = substr($rfc_concat, 0, -1);
        $factura_fld = $this->oComprobantes->facturas_antiguasG($rfc_concat,$idcomprobante);
        $factura_db = $this->oComprobantes->facturas_nuevasG($rfc_concat,$idcomprobante);  

        if($factura_fld)
            $row = $factura_fld;
        else
            $row = $factura_db;

        $pdf="";
        $ceros="";
        if($row->folio <= 9)
            $ceros="00000000000";
        if($row->folio > 9)
            $ceros="0000000000";
        if($row->folio >= 100)
            $ceros="000000000";
        if($row->folio >= 1000)
            $ceros="00000000";
        if($row->folio >= 10000)
            $ceros="0000000";
        $pdf.=$row->estatus."EFE060511IA7-".$row->serie.$ceros.$row->folio;
        $pdf=trim($pdf);

        if($factura_fld){
            if(file_exists("/home/parametrosCFDI/EFE060511IA7/".$pdf.".pdf")){
                $rutav = "/home/parametrosCFDI/EFE060511IA7/".$pdf.".pdf";
                $nom_pdf = $pdf;
            }else{
                $rutav = "/home/comerpdf/".$pdf.".pdf";
                $nom_pdf = $pdf;
            }

            header("Content-type: application/pdf");
            header("Content-Disposition: attachment; filename=".$nom_pdf.".pdf");
            readfile($rutav);

        }else if($factura_db){
            $nombre_pdf = $row->estatus."EFE060511IA7-bd-".$row->serie.$row->folio;
            $fact = $this->oComprobantes->factura_pdfxml($idcomprobante);
            header("Content-type: application/pdf");
            header("Content-Disposition: attachment; filename=".$nombre_pdf.".pdf");
            echo $fact->pdf;
        }
    }

    public function generar_zip($idcomprobante){
        ini_set("mssql.textlimit" , "2147483647");
        ini_set("mssql.textsize" , "2147483647");

        $factura_fld = $this->oComprobantes->facturas_antiguas($this->rfc->cliente_rfc,$idcomprobante);
        $factura_db = $this->oComprobantes->facturas_nuevas($this->rfc->cliente_rfc,$idcomprobante);

        if($factura_fld)
            $row = $factura_fld;
        else
            $row = $factura_db;

        $pdf="";
        $ceros="";
        if($row->folio <= 9)
            $ceros="00000000000";
        if($row->folio > 9)
            $ceros="0000000000";
        if($row->folio >= 100)
            $ceros="000000000";
        if($row->folio >= 1000)
            $ceros="00000000";
        if($row->folio >= 10000)
            $ceros="0000000";
        $pdf.=$row->estatus."EFE060511IA7-".$row->serie.$ceros.$row->folio;
        $pdf=trim($pdf);            
                                
        if($factura_fld){

            if(file_exists("/home/parametrosCFDI/EFE060511IA7/".$pdf.".pdf")){
                $rutaPDF = "/home/parametrosCFDI/EFE060511IA7/";
                $rutaXML = "/home/xmlTmpCFDI/EFE060511IA7/";
                $nom_pdf = $pdf;
            }else{
                $rutaPDF = "/home/comerpdf/";
                $rutaXML = "/home/comerxml/";
                $nom_pdf = $pdf;
            }
            $this->zip->read_file($rutaPDF.$nom_pdf.".pdf");
            $this->zip->read_file($rutaXML.$nom_pdf.".xml"); 
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=".$nom_pdf.".zip");
            echo $this->zip->get_zip();

        }else if($factura_db){
            $nombre_pdf = $row->estatus."EFE060511IA7-bd-".$row->serie.$row->folio;
            $fact = $this->oComprobantes->factura_pdfxml($idcomprobante);
            $data = array(
                $nombre_pdf.".pdf" => $fact->pdf,
                $nombre_pdf.".xml" => $fact->xxml
            );
            $this->zip->add_data($data);
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=".$nombre_pdf.".zip");
            echo $this->zip->get_zip();
        }
    }

    public function generar_zipG($idcomprobante){
        ini_set("mssql.textlimit" , "2147483647");
        ini_set("mssql.textsize" , "2147483647");

        $rfc_concat = "";
        foreach($this->rfc as $rows){
            $rfc_concat .= "'".$rows->cliente_rfc."',";
        }
        $rfc_concat = substr($rfc_concat, 0, -1);
        $factura_fld = $this->oComprobantes->facturas_antiguasG($rfc_concat,$idcomprobante);
        $factura_db = $this->oComprobantes->facturas_nuevasG($rfc_concat,$idcomprobante);  

        if($factura_fld)
            $row = $factura_fld;
        else
            $row = $factura_db;

        $pdf="";
        $ceros="";
        if($row->folio <= 9)
            $ceros="00000000000";
        if($row->folio > 9)
            $ceros="0000000000";
        if($row->folio >= 100)
            $ceros="000000000";
        if($row->folio >= 1000)
            $ceros="00000000";
        if($row->folio >= 10000)
            $ceros="0000000";
        $pdf.=$row->estatus."EFE060511IA7-".$row->serie.$ceros.$row->folio;
        $pdf=trim($pdf);            
                                
        if($factura_fld){

            if(file_exists("/home/parametrosCFDI/EFE060511IA7/".$pdf.".pdf")){
                $rutaPDF = "/home/parametrosCFDI/EFE060511IA7/";
                $rutaXML = "/home/xmlTmpCFDI/EFE060511IA7/";
                $nom_pdf = $pdf;
            }else{
                $rutaPDF = "/home/comerpdf/";
                $rutaXML = "/home/comerxml/";
                $nom_pdf = $pdf;
            }
            $this->zip->read_file($rutaPDF.$nom_pdf.".pdf");
            $this->zip->read_file($rutaXML.$nom_pdf.".xml"); 
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=".$nom_pdf.".zip");
            echo $this->zip->get_zip();

        }else if($factura_db){
            $nombre_pdf = $row->estatus."EFE060511IA7-bd-".$row->serie.$row->folio;
            $fact = $this->oComprobantes->factura_pdfxml($idcomprobante);
            $data = array(
                $nombre_pdf.".pdf" => $fact->pdf,
                $nombre_pdf.".xml" => $fact->xxml
            );
            $this->zip->add_data($data);
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=".$nombre_pdf.".zip");
            echo $this->zip->get_zip();
        }
    }
}