<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * estadoscta_estados.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */


class Estadoscta_Estados extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $dbBase = $this->load->database('edocta',TRUE);
        $this->load->model('estadoscta/estados_model','oEstados');
        $this->load->library('pagination');
        $this->load->library('html2pdf');
        $this->cliente = $this->oEstados->cliente($this->session->userdata('logged_user')->usu_id);
        $this->rows = $this->oEstados->Encabezado($this->cliente->usu_usuario);
        $this->rows2 = $this->oEstados->TipoCambio();
        $this->template['module'] = 'estadoscta';
        $this->template['titulo'] = 'Estado de cuenta';
        $this->template['usu'] = $this->cliente->usu_usuario;
        $this->template['usuario'] = $this->cliente->usu_nombre;
        $this->template['saldoant'] = '$'.number_format($this->rows->saldoamovs,2);
        $this->template['pagos'] = '$'.number_format($this->rows->creditos,2);
        $this->template['compras'] = '$'.number_format($this->rows->nuevoscargos,2);
        $this->template['saldoact'] = '$'.number_format($this->rows->saldoactual,2);
        $this->template['facturasusd'] = $this->rows->facturasdlls;
        $this->template['saldousd'] = '$'.number_format($this->rows->saldodlls,2);
        $this->template['facturasmn'] = $this->rows->facturaspesos;
        $this->template['saldomn'] = '$'.number_format($this->rows->saldopesos,2);
        $this->template['fecha_corte'] = $this->rows->fechacorte;
        $this->template['parte1'] = $this->cliente->usu_usuario." - ".$this->cliente->usu_nombre." ".$this->cliente->usu_apellido_paterno." ".$this->cliente->usu_apellido_materno;
        $this->template['fecha'] = date("d/m/Y");
        $this->template['credito_autorizado'] = '$'.number_format($this->rows->montocredito,2);
        $this->template['dias_credito'] = $this->rows->diascredito;
        $this->template['tipo_cambio'] = $this->rows2->tipo_cambio;
        $this->template['domicilio'] = $this->rows->domicilio;
        $this->template['domicilio2'] = $this->rows->ciudad.", ".$this->rows->municipio.", ".$this->rows->pais.". C.P. ".$this->rows->cp;
        //print_r($this->rows2);
    }
	
	public function index()
	{
        $facturas_pesos = "";
        $facturas_usd = "";

        $data = array(
            'idCliente' => $this->cliente->usu_usuario,
            'Nombre' => $this->cliente->usu_nombre,
            'Fecha' => date('Y-m-d'),
            'Visita' => 1
        );
        $this->oEstados->visitas($data);

        //setcookie("cliente", $this->cliente->usu_usuario, time() + 3600, '/', 'http://www.panel.vimifos.net');

        $config['base_url'] = site_url('estados/index');
        $config['first_url'] = site_url('estados/index/0/'.$this->uri->segment(4));
        $config['suffix'] = $this->uri->segment(4) != '' ? '/'.$this->uri->segment(4) : '/0';
        $config['total_rows'] = ($this->oEstados->filas($this->cliente->usu_usuario,'MN') == 0 ? 1 : $this->oEstados->filas($this->cliente->usu_usuario,'MN'));
        $config['per_page'] = 5;
        $config['num_links'] = 20; 
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config);

        $rows_facturas_pesos = $this->oEstados->Contenido($config['per_page'],$this->uri->segment(3),$this->cliente->usu_usuario,'MN');
        
        if($rows_facturas_pesos){
            foreach($rows_facturas_pesos as $row) { 
                $facturas_pesos .= "<tr>
                                        <td>#</td><td>".date("d/m/Y", strtotime($row->emision))."</td>
                                        <td>".$row->factura."</td>
                                        <td>".date("d/m/Y", strtotime($row->vencimiento))."</td>
                                        <td>".$row->diasemitidos."</td>
                                        <td>$".number_format($row->saldo,2)."</td>
                                    </tr>";
            }
        }else{
            $facturas_pesos = "<tr><td>#</td><td align='center' colspan='7'>No se encontraron registros</td></tr>";
        }

        $this->template['contenido'] = $facturas_pesos;
        $this->template['pag_pesos'] = $this->pagination->create_links();

        $config2['prefix'] = $this->uri->segment(3) != '' ? "/".$this->uri->segment(3)."/" : '/0/';
        $config2['base_url'] = site_url('estados/index');
        $config2['first_url'] = $this->uri->segment(3) != '' ? site_url('estados/index/'.$this->uri->segment(3).'/0') : site_url('estados/index/0/0');
		$config2['suffix'] = '';
		$config2['total_rows'] = $this->oEstados->filas($this->cliente->usu_usuario,'USD');
        $config2['per_page'] = 5;
        $config2['num_links'] = 20; 
        $config2["uri_segment"] = 4;
        $config2['use_page_numbers'] = true;
        $this->pagination->initialize($config2);

        $pages = $this->uri->segment(4) == 0 ? 0 : $this->uri->segment(4) - 1;
        $rows_facturas_usd = $this->oEstados->Contenido($config['per_page'],$pages,$this->cliente->usu_usuario,'USD');

        if($rows_facturas_usd){
            foreach($rows_facturas_usd as $row) { 
                $facturas_usd .= "<tr>
                                        <td>#</td><td>".date("d/m/Y", strtotime($row->emision))."</td>
                                        <td>".$row->factura."</td>
                                        <td>".date("d/m/Y", strtotime($row->vencimiento))."</td>
                                        <td>".$row->diasemitidos."</td>
                                        <td>$".number_format($row->saldo,2)."</td>
                                    </tr>";
            }
        }else{
            $facturas_usd = "<tr><td>#</td><td align='center' colspan='7'>No se encontraron registros</td></tr>";
        }
        
        $this->template['contenido2'] = $facturas_usd;
        $this->template['pag_usd'] = $this->pagination->create_links();
        $this->_run('estados_general');
	}

    public function generar_excel(){
        $facturas_pesos = "";
        $facturas_usd = "";

        $rows_facturas_pesos = $this->oEstados->Contenido('100000',$this->uri->segment(3),$this->cliente->usu_usuario,'MN');
        $rows_facturas_usd = $this->oEstados->Contenido('100000',$this->uri->segment(2),$this->cliente->usu_usuario,'USD');

        if(count($rows_facturas_pesos) > 0){ 
            foreach($rows_facturas_pesos  as $row) { 
                $facturas_pesos .= "<tr>
                                        <td>".date("d/m/Y", strtotime($row->emision))."</td>
                                        <td>".$row->factura."</td>
                                        <td>".date("d/m/Y", strtotime($row->vencimiento))."</td>
                                        <td>".$row->diasemitidos."</td>
                                        <td>$".number_format($row->saldo,2)."</td>
                                    </tr>";
            }
        }

        if(count($rows_facturas_usd) > 0){ 
            foreach($rows_facturas_usd as $row) { 
                $facturas_usd .= "<tr>
                                        <td>".date("d/m/Y", strtotime($row->emision))."</td>
                                        <td>".$row->factura."</td>
                                        <td>".date("d/m/Y", strtotime($row->vencimiento))."</td>
                                        <td>".$row->diasemitidos."</td>
                                        <td>$".number_format($row->saldo,2)."</td>
                                    </tr>";
            }
        }
        $this->template['contenido'] = $facturas_pesos;
        $this->template['contenido2'] = $facturas_usd;
        $this->load->view('estadoscta/estadoscta/excel', $this->template);
    }

    public function generar_pdf(){

                  $facturas_pesos = "";
        $facturas_usd = "";

        $rows_facturas_pesos = $this->oEstados->Contenido('100000',$this->uri->segment(3),$this->cliente->usu_usuario,'MN');
        $rows_facturas_usd = $this->oEstados->Contenido('100000',$this->uri->segment(2),$this->cliente->usu_usuario,'USD');

        foreach($rows_facturas_pesos  as $row) { 
            $facturas_pesos .= "<tr>
                                    <td>".date("d/m/Y", strtotime($row->emision))."</td>
                                    <td>".$row->factura."</td>
                                    <td>".date("d/m/Y", strtotime($row->vencimiento))."</td>
                                    <td>".$row->diasemitidos."</td>
                                    <td>$".number_format($row->saldo,2)."</td>
                                </tr>";
        }

        foreach($rows_facturas_usd as $row) { 
            $facturas_usd .= "<tr>
                                    <td>".date("d/m/Y", strtotime($row->emision))."</td>
                                    <td>".$row->factura."</td>
                                    <td>".date("d/m/Y", strtotime($row->vencimiento))."</td>
                                    <td>".$row->diasemitidos."</td>
                                    <td>$".number_format($row->saldo,2)."</td>
                                </tr>";
        }

        $this->template['contenido'] = $facturas_pesos;
        $this->template['contenido2'] = $facturas_usd;
        $html = $this->load->view('estadoscta/estadoscta/pdf', $this->template);


            //Set folder to save PDF to
            $this->html2pdf->folder('./assets/upload/estadoscta/pdfs/');

            //Set the filename to save/download as
            $this->html2pdf->filename("estado_cuenta".$this->cliente->usu_usuario.".pdf");

            //Set the paper defaults
            $this->html2pdf->paper('A4', 'portrait');

            //Load html view
            $this->html2pdf->html($this->load->view('estadoscta/estadoscta/pdf',$html, true));
                    
            $this->html2pdf->create('save');
            redirect(base_url()."assets/upload/estadoscta/pdfs/estado_cuenta".$this->cliente->usu_usuario.".pdf");
    }
	
}