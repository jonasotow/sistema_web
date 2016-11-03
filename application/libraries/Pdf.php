<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once(APPPATH.'third_party/fpdf.php');
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF {
        public function __construct() {
            parent::__construct();

        }
        public function Header(){
            $fhoycorto = date("Y/m/d");
            $fechadia = "Fecha de impresión: ".$fhoycorto;
            $this->SetLeftMargin(20);
            $this->SetRightMargin(20);
            $this->Image('assets/img/logo_vim.png',10,8,15);
            $this->SetFont('Arial','B',14);
            $this->Cell(30);
            $this->Cell(0,10,'VIMIFOS',0,0,'C');
            $this->Ln('5');
            $this->SetFont('Arial','B',10);
            $this->Cell(30);
            $this->Cell(0,10,'SISTEMA INTEGRAL DE TESORERIA',0,0,'C');
            $this->Ln(10);
            $this->SetFont('Arial','B', 9);
            $this->SetY(25);
            $this->Cell(0,10,$fechadia,0,0,'R');
            $this->Ln(15);
       }

       public function Footer(){
           $this->SetY(-15);
           $this->SetFont('Arial','I',8);
           $this->Cell(0,10,('Página(s) ').$this->PageNo().'/{nb}',0,0,'C');
           $this->Ln('5');
           $this->SetFont('Arial','',8);
           $this->Cell(30);
           $this->SetY(-10);
           $this->Cell(0,10,'SISTEMA INTEGRAL DE TESORERIA',0,0,'C');
           $this->Ln(20);
      }
    }
?>