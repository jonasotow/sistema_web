<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * preciosmercado_tipo.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */

class Bioeconomico_Desarrollo extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->aplicacion = 'fletes';
        $this->template['module'] = 'bioeconomico';
        $dbBase = $this->load->database('bioeconomico',TRUE);
        $this->load->model('bioeconomico/bioeconomico_desarrollo_model','oBieconomicoDesarrollo');
        $this->load->model('bioeconomico/modelo_generico_model',FALSE,'bioeconomico');
        $this->template['titulo'] = 'DESARROLLO';
        $this->template['action'] = site_url('desarrollo/crear');
        $this->param = array(
            'cabecera' => array("Id","Nombre/Lugar","No. Lote", "Fecha Entrada","Fecha Salida","No. Cabezas","Modificar","Eliminar"),
            'open' => "<table class='table table-striped table-hover table-condensed'>",
            'edit' => "fa fa-pencil-square-o fa-lg",
            'delete' => "fa fa-times-circle fa-lg",
            'url_campo' => 'idLotes'
        );
    }
	
	public function index()
	{
         $this->template['aside'] = anchor(site_url('inicializacion'),"<i class='fa fa-info fa-fw fa-lg'></i><span class='aside-text'>VACA-CRÍA</span>","class='list-group-item'")
                                    .anchor(site_url('desarrollo'),"<i class='fa fa-info fa-fw fa-lg'></i><span class='aside-text'>DESARROLLO</span>","class='list-group-item active'")
                                    .anchor(site_url('inicializacion'),"<i class='fa fa-info fa-fw fa-lg'></i><span class='aside-text'>FINALIZACIÓN</span>","class='list-group-item'");

        $this->template['nav'] = anchor(site_url('desarrollo'), "<i class='fa fa-arrow-circle-left'></i><span class='nav-text'></span>", "class='navbar-brand'").
                                 anchor(site_url('desarrollo/crear'), "<i class='fa fa-plus-circle'></i><span class='nav-text'></span>", "class='navbar-brand'");
        $campos = $this->oBieconomicoDesarrollo->find('result',array( 
                'fields' => array('idLotes','nombre','nolote',"DATE_FORMAT(fechaentrada,'%d/%m/%Y')","DATE_FORMAT(fechasalida,'%d/%m/%Y')",'nocabezas'),
                'conditions' => array('status' => '1'),
                'conditions' => array('idUsuario' => $this->session->userdata('logged_user')->usu_id),
                'order' => array( 'idLotes' => 'ASC' )));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('desarrollo/crear', $this->param, 'desarrollo/delete');
        $this->template['action'] = site_url('desarrollo/crear');
        $this->_run('tabla_ver');		
	}

    public function crear() {
        try{
            $id = $this->uri->segment(3);
            $this->template['aside'] = anchor(site_url('inicializacion'),"<i class='fa fa-info fa-fw fa-lg'></i><span class='aside-text'>VACA-CRÍA</span>","class='list-group-item'")
                                    .anchor(site_url('desarrollo'),"<i class='fa fa-info fa-fw fa-lg'></i><span class='aside-text'>DESARROLLO</span>","class='list-group-item active'")
                                    .anchor(site_url('inicializacion'),"<i class='fa fa-info fa-fw fa-lg'></i><span class='aside-text'>FINALIZACIÓN</span>","class='list-group-item'");
            // construye el submenu
            $this->template['nav'] = anchor(site_url('desarrollo'), "<i class='fa fa-arrow-circle-left'></i><span class='nav-text'></span>", "class='navbar-brand'");
            // construye el submenu --termina--
        

        $this->template['new'] = !is_numeric($id) ? "Nuevo" : "Modificar";
        //$this->form_validation->set_rules('descripcion','<span style="color: #FF0000;">"DESCRIPCIÓN"</span>','trim|required');
        $datos = '';
        if(is_numeric($id))
            $this->template['action'] = site_url('desarrollo/crear');
            $datos = $this->oBieconomicoDesarrollo->find('list',array('conditions' => array( 'idLotes' => $id )));
            if($datos){
                $datos['fechaentrada'] = date("d/m/Y", strtotime($datos['fechaentrada']));
                $datos['fechasalida'] = date("d/m/Y", strtotime($datos['fechasalida']));
            }

            $this->template['formulario'] = $this->_getForm(
                'desarrollo/crear'.'/'.$id,
                $this->oBieconomicoDesarrollo->schema,
                $datos,
                "desarrollo",
                'form-inline',
                'form-inline',
                FALSE,
                $this->oBieconomicoDesarrollo->schema_up,
                TRUE
            );

            if($this->input->post(NULL, TRUE)){
                $this->template['nav'] = anchor(site_url('desarrollo'), "<i class='fa fa-arrow-circle-left'></i><span class='nav-text'></span>", "class='navbar-brand'")
                                    ."<div class='navbar-brand'><button class='btn btn-success btn-xs' onclick='crear_escenario_opciones()'><i class='fa fa-sliders'></i><span class='nav-text'>Crear Escenario</span></<button></div>"
                                    ."<div class='navbar-brand'><a href=".site_url('desarrollo/grafica/'.$id)." class='btn btn-danger btn-xs' role='button'><i class='fa fa-trash'></i><span class='nav-text'>Reestablecer Datos</span></a></div>";  
                $datos = elements($this->oBieconomicoDesarrollo->schema(),$this->input->post(NULL, TRUE));
                if(!$datos['idLotes']){
                   unset($datos['idLotes']); 
                }
                $datos['fechaentrada'] = date("Y-m-d", strtotime($datos['fechaentrada']));
                $dia = substr($datos['fechasalida'], 0, 2);
                $mes = substr($datos['fechasalida'], 3, 2);
                $ano = substr($datos['fechasalida'], -4);
                $datos['fechasalida'] = $ano."-".$mes."-".$dia;
                $datos['idUsuario'] = $this->session->userdata('logged_user')->usu_id;
                $datos['status'] = 1;
                $this->template['formulario'] = $this->_getForm(
                                'desarrollo/crear'.'/'.$id,
                                $this->oBieconomicoDesarrollo->schema,
                                $datos,
                                "desarrollo",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oBieconomicoDesarrollo->schema_up,
                                TRUE);

                $idLotes = $this->oBieconomicoDesarrollo->save($datos);
                $this->_insertMuertes($idLotes,$this->input->post(NULL, TRUE));
                $this->_insertSuplementos($idLotes,$this->input->post(NULL, TRUE));
                /* Despues de insertar nos vamos a la graficas */
                $lote = $this->oBieconomicoDesarrollo->get('des_lotes','*','idLotes ='.$idLotes);
                $muerte = $this->oBieconomicoDesarrollo->get("des_muertes","Fecha,Cantidad","idLotes =".$idLotes);
                $suplemento = $this->oBieconomicoDesarrollo->get('des_suplementos','*','idLotes ='.$idLotes);
                $this->template['lote'] = $lote;
                $this->template['muerte'] = $muerte;
                $this->template['suplemento'] = $suplemento;
                $this->_run('desarrollo');
                return TRUE; 

                
            } 

        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }  
        
        if($this->input->post('eliminar',TRUE) != NULL)
            $this->index();
        else
            $this->_run('crud');
        }

        Private function _insertMuertes($idLotes,$datos){
            $Fecha = $datos['FechaMuerte'];
            $Cantidad = $datos['NumeroMuerte'];
            for ($i=0; $i <= count($Fecha)-1; $i++) {
                $dia2 = substr($Fecha[$i], 0, 2);
                $mes2 = substr($Fecha[$i], 3, 2);
                $ano2 = substr($Fecha[$i], -4);
                $FechaM = $ano2."-".$mes2."-".$dia2;
                $datos_muertes = array(
                    'Cantidad'          => $Cantidad[$i],
                    'Fecha'          => $FechaM,
                    'idLotes'       => $idLotes
                );
                $this->oBieconomicoDesarrollo->guardarMuertes($datos_muertes);
            }    
        }

        Private function _insertSuplementos($idLotes,$datos){
            $Suplemento = $datos['Suplemento'];
            $Preciokg = $datos['PrecioKg'];
            $ConsumoKg = $datos['ConsumoKgCabDia'];
            $Nodias = $datos['Nodias'];
            for ($i=0; $i <= count($Suplemento)-1; $i++) {
                $datos_suplementos = array(
                    'Suplemento'    => $Suplemento[$i],
                    'PrecioKg'      => $Preciokg[$i],
                    'ConsumoKg'     => $ConsumoKg[$i],
                    'idLotes'       => $idLotes,
                    'NoDias'        => $Nodias[$i]
                );
                $this->oBieconomicoDesarrollo->guardarSuplementos($datos_suplementos);
            }    
        }

        Private function _construccionGraficas($datos_capturados){
            return print_r($datos_capturados);
        }  

        public function grafica(){
            $id = $this->uri->segment(3);
            // construye el menu
            $this->template['aside'] = anchor(site_url('inicializacion'),"<i class='fa fa-info fa-fw fa-lg'></i><span class='aside-text'>VACA-CRÍA</span>","class='list-group-item'")
                                    .anchor(site_url('desarrollo'),"<i class='fa fa-info fa-fw fa-lg'></i><span class='aside-text'>DESARROLLO</span>","class='list-group-item active'")
                                    .anchor(site_url('inicializacion'),"<i class='fa fa-info fa-fw fa-lg'></i><span class='aside-text'>FINALIZACIÓN</span>","class='list-group-item'");
            // construye el submenu
            $this->template['nav'] = anchor(site_url('desarrollo'), "<i class='fa fa-arrow-circle-left'></i><span class='nav-text'></span>", "class='navbar-brand'")
                                    ."<div class='navbar-brand'><button class='btn btn-success btn-xs' onclick='crear_escenario_opciones()'><i class='fa fa-sliders'></i><span class='nav-text'>Crear Escenario</span></<button></div>"
                                    ."<div class='navbar-brand'><a href=".site_url('desarrollo/grafica/'.$id)." class='btn btn-danger btn-xs' role='button'><i class='fa fa-trash'></i><span class='nav-text'>Reestablecer Datos</span></a></div>";            
            $lote = $this->oBieconomicoDesarrollo->get('des_lotes','*','idLotes ='.$id);
            $muerte = $this->oBieconomicoDesarrollo->get("des_muertes","Fecha,Cantidad","idLotes =".$id);
            $suplemento = $this->oBieconomicoDesarrollo->get('des_suplementos','*','idLotes ='.$id);
            $this->template['lote'] = $lote;
            $this->template['muerte'] = $muerte;
            $this->template['suplemento'] = $suplemento;
            $this->_run('desarrollo');
        }

        function delete() {
            $id = $this->uri->segment(3);
            $this->oBieconomicoDesarrollo->delete_t($id);
            $this->index();
        }
    }