<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

class Proswine_Monitores extends MY_Controller {

    var $param;
    var $aplicacion;
    var $granja;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $this->aplicacion = 'proswine';
        $dbBase = $this->load->database('porcicultura',TRUE);
        $this->template['module'] = 'local';
        $this->param = array(
            'cabecera' => array("Id", "Cliente", "Gerente", "Direccion", "Telefono"),
            'open' => "<table class='table table-striped table-hover table-condensed'>"
        ); 
        $this->load->model($this->aplicacion.'/granjas_mon_model');
        $this->load->model($this->aplicacion.'/group_model','grupos');
        $this->load->model($this->aplicacion.'/group_detalle_model','detGrupo');
        $this->load->model($this->aplicacion.'/montas_model','oLactancia');
        $this->load->model($this->aplicacion.'/mov_model','oMov');
        $this->load->model($this->aplicacion.'/plan_med_model','oPlan');
        $this->load->model($this->aplicacion.'/curva_model', 'oCurva');
        $this->load->model($this->aplicacion.'/venta_model', 'oVenta');
        $this->load->model($this->aplicacion.'/entrada_salida_model', 'oEntradaSalida');
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
       	$tipo = $this->uri->segment(3);
	    $anio = $this->uri->segment(4);
	    $this->template['tabs'] = '<ul class="nav nav-pills nav-justified" role="tablist" id="menuTabs">'.
	    								'<li'.(((is_numeric($tipo)) OR $tipo == 'montas') ? ' class="active">' : '>').'<a href="#montas">Montas</a></li>'.
	    								'<li'.((!is_numeric($tipo) && is_string($tipo) && $tipo == 'pasar_lactancia') ? ' class="active">' : '>').'<a href="#pasar_lactancia">Mover a Lactancia</a></li>'.
	    								'<li'.((!is_numeric($tipo) && is_string($tipo) && $tipo == 'lactancia') ? ' class="active">' : '>').'<a href="#lactancia">Lactancia</a></li>'.
	    								'<li'.((!is_numeric($tipo) && is_string($tipo) && $tipo == 'engordas') ? ' class="active">' : '>').'<a href="#engordas">Engordas</a></li>'.
	    								'<li'.((!is_numeric($tipo) && is_string($tipo) && $tipo == 'curvas') ? ' class="active">' : '>').'<a href="#curvas">Curva de Crecimiento</a></li>'.
	    								'<li'.((!is_numeric($tipo) && is_string($tipo) && $tipo == 'ventas') ? ' class="active">' : '>').'<a href="#ventas">Ventas</a></li>'.
	    								'<li'.((!is_numeric($tipo) && is_string($tipo) && $tipo == 'entradas_salidas') ? ' class="active">' : '>').'<a href="#entradas_salidas">Inventarios</a></li>'.
	    						  '</ul><hr />';
	    if(!is_numeric($tipo) && is_string($tipo)){
		    $all = $this->input->post(NULL,TRUE);
		    /* Capturar solo inv inicial */
		    if(!isset($all['groupd_week']) && !in_array($tipo,array("pasar_lactancia","curvas","ventas","entradas_salidas"))){
			    $campos = $this->grupos->array_schema();
			    $campos['group_id'] = $all['groupd_id_group'];
 			    $campos['group_year'] = $this->uri->segment(5);
 			    $campos['group_qty'] = $all['groupd_inv'];
 			    $campos['group_status'] = 1;
 			    $campos['group_id_granja'] = $this->uri->segment(4);
 				$campos['idgroup_mstr'] = $this->grupos->buscar_id($this->uri->segment(4),$this->input->post('groupd_id_group',TRUE),$this->uri->segment(5));
 				try{
 					$this->grupos->save($campos);
 				}catch(Exception $e){}
		    }
		    else{
			    switch($tipo){
				    case "pasar_lactancia":
					    $datos = elements($this->oLactancia->schema(),$this->input->post(NULL, TRUE));
					    $datos['montas_id_group'] = $this->grupos->buscar_id($this->uri->segment(4),$this->input->post('montas_id_group',TRUE),$this->uri->segment(5));
					    $year = $this->uri->segment(5);
						$week = $datos['montas_semana'];						
						# obtenemos el timestamp del primer dia del año
						$timestamp=mktime(0, 0, 0, 1, 1, $year);						
						# sumamos el timestamp de la suma de las semanas actuales
						$timestamp+=$week*7*24*60*60;						
						# restamos la posición inicial del primer dia del año
						$ultimoDia=$timestamp-date("w", mktime(0, 0, 0, 1, 1, $year))*24*60*60;						
						# le restamos los dias que hay hasta llegar al lunes
						$primerDia=$ultimoDia-86400*(date('N',$ultimoDia)-1);						
						$datos['montas_partos_ini'] = date("Y-m-d",$primerDia);
						$datos['montas_partos_fin'] = date("Y-m-d",$ultimoDia);
						$datos['montas_fch_fin'] = date('Y-m-d', strtotime(str_replace('-', '/',$datos['montas_fch_fin'])));
 				    	try{
 							$this->oLactancia->save($datos);
 						}catch(Exception $e){}
					break;
					case "curvas":
						$datos = elements($this->oCurva->schema(),$this->input->post(NULL, TRUE));
						$datos['curva_id_group'] = $this->grupos->buscar_id($this->uri->segment(4),$this->input->post('curva_id_group',TRUE),$this->uri->segment(5));
						try{
							$this->oCurva->save($datos);
						}catch(Exception $e){}
					break;
					case "ventas":
						$datos = elements($this->oVenta->schema(),$this->input->post(NULL, TRUE));
						$datos['venta_group'] = $this->grupos->buscar_id($this->uri->segment(4),$this->input->post('venta_group',TRUE),$this->uri->segment(5));
						try{
							$this->oVenta->save($datos);
						}catch(Exception $e){}
					break;
					case "entradas_salidas":
						$datos = elements($this->oEntradaSalida->schema(),$this->input->post(NULL, TRUE));
						$datos['ent_sal_group'] = $this->grupos->buscar_id($this->uri->segment(4),$this->input->post('ent_sal_group',TRUE),$this->uri->segment(5));
						try{
							$this->oEntradaSalida->save($datos);
						}catch(Exception $e){}
					break;
					default:
						$datos = elements($this->detGrupo->schema(),$this->input->post(NULL, TRUE));
				    	$datos['groupd_type'] = $tipo == 'lactancia' ? 2 : 1;
						$datos['groupd_id_group'] = $this->grupos->buscar_id($this->uri->segment(4),$this->input->post('groupd_id_group',TRUE),$this->uri->segment(5));
						try{
							$this->detGrupo->save($datos);
						}catch(Exception $e){}
					break;
			    }
			}
			$tipo = $this->uri->segment(4);
			$anio = $this->uri->segment(5);
	    }
	    $this->template['titulo'] = $this->detGrupo->buscarTitulo($tipo);
	    $partos = array('cabecera' => array("Id", "Grupo", "Fecha Inicio", "Fecha Fin", "Partos", "% Partos", "Semana"), 'leyenda' => 'Partos', 'open' => '<table data-name="contactos" class="table">');
	    $campos_partos = $this->oLactancia->find('result',array( 
					'fields' => array('idmontas_mstr','group_id','montas_partos_ini','montas_partos_fin','montas_partos','(montas_partos / group_qty) * 100 as porcentaje','montas_semana'),
					'join' => array(
						'clause' => array('group_mstr' => 'group_mstr.idgroup_mstr = montas_mstr.montas_id_group'),
						'type' => 'INNER'
					),
					'conditions' => array('group_id_granja' => $tipo, 'group_year' => $anio),
					'order' => array( 'group_id' => 'ASC' )
					));
		$partos = array_merge($partos, array('datos' => $campos_partos));
   		$this->template['formulario_montas'] = '<div class="tab-pane'.(((is_numeric($this->uri->segment(3))) OR $this->uri->segment(3) == 'montas') ? ' active"' : '"').' id="montas" data-name="Montas" data-site="1">'.
   				$this->_getForm('monitores/index/montas'.'/'.$tipo.'/'.$anio,$this->detGrupo->schema,'','Agregar grupo de Montas','form-inline','form-inline',false,$this->detGrupo->schema_up).
   				"<br /><h4>Registros Monitores Montas</h4>".
   				$this->grupos->buscarTabla($tipo,1,1,'montas').
   				"</div>";
   		$this->template['formulario_lactancia'] = '<div class="tab-pane'.($this->uri->segment(3) == 'lactancia' ? ' active"' : '"').' id="lactancia" data-name="Lactancia" data-site="1">'.
   				$this->_getForm('monitores/index/lactancia'.'/'.$tipo.'/'.$anio,$this->detGrupo->schema,'','Agregar grupo de Lactancia','form-inline','form-inline',false,$this->detGrupo->schema_up).
   				"<br /><h4>Registros Monitores Lactancia</h4>".
   				$this->grupos->buscarTabla($tipo,1,2,'lactancia').
   				"</div>";
   		$this->template['formulario_engordas'] = '<div class="tab-pane'.($this->uri->segment(3) == 'engordas' ? ' active"' : '"').' id="engordas" data-name="Engordas" data-site="2">'.
   				$this->_getForm('monitores/index/engordas'.'/'.$tipo.'/'.$anio,$this->detGrupo->schema,'','Agregar grupo de Engordas','form-inline','form-inline',false,$this->detGrupo->schema_up).
   				"<br /><h4>Registros Monitores Engorda</h4>".
   				$this->grupos->buscarTabla($tipo,2,1,'engordas').
   				"</div>";
   		$this->template['formulario_pasar_lactancia'] = '<div class="tab-pane'.($this->uri->segment(3) == 'pasar_lactancia' ? ' active"' : '"').' id="pasar_lactancia" data-name="Mover a Lactancia" data-site="0">'.
   				$this->_getForm('monitores/index/pasar_lactancia'.'/'.$tipo.'/'.$anio,$this->oLactancia->schema,'','','form-inline','form-inline',false,$this->oLactancia->schema_up).
   				"<br /><h4>Registros Partos</h4>".
   				$this->generate_table('', $partos).
   				"</div>";
   		$this->template['formulario_curvas'] = '<div class="tab-pane'.($this->uri->segment(3) == 'curvas' ? ' active"' : '"').' id="curvas" data-name="Curva de Crecimiento" data-site="0">'.
   				$this->_getForm('monitores/index/curvas'.'/'.$tipo.'/'.$anio,$this->oCurva->schema,'','Agregar Curvas','form-inline','form-inline',false,$this->oCurva->schema_up).
   				"</div>";
   		$this->template['formulario_ventas'] = '<div class="tab-pane'.($this->uri->segment(3) == 'ventas' ? ' active"' : '"').' id="ventas" data-name="Curva de Crecimiento" data-site="0">'.
   				$this->_getForm('monitores/index/ventas'.'/'.$tipo.'/'.$anio,$this->oVenta->schema,'','Agregar grupo de Ventas','form-inline','form-inline',false,$this->oVenta->schema_up).
   				"</div>";
   		$this->template['formulario_inv'] = '<div class="tab-pane'.($this->uri->segment(3) == 'entradas_salidas' ? ' active"' : '"').' id="entradas_salidas" data-name="Entradas y Salidas (Inventarios)" data-site="0">'.
   				$this->_getForm('monitores/index/entradas_salidas'.'/'.$tipo.'/'.$anio,$this->oEntradaSalida->schema,'','Agregar grupo de Montas','form-inline','form-inline',false,$this->oEntradaSalida->schema_up).
   				"</div>";
		$this->_run('monitores');
    }
    
    public function plan_med() {
	    $tipo = $this->uri->segment(3);
	    $anio = $this->uri->segment(4);
	    if(!is_numeric($tipo) && $tipo == 'agregar'){
		    $datos = elements($this->oPlan->schema(),$this->input->post(NULL, TRUE));
		    $datos['pmed_group'] = $this->grupos->buscar_id($this->uri->segment(4),$this->input->post('pmed_group',TRUE),$this->uri->segment(5));
			try{
		    	$this->oPlan->save($datos);
	    	}catch(Exception $e){}
			$tipo = $this->uri->segment(4);
			$anio = $this->uri->segment(5);
	    }
	    $this->oPlan->prepararForm();
	    $this->template['titulo'] = $this->detGrupo->buscarTitulo($tipo);
   		$this->template['formulario'] = $this->_getForm('monitores/plan_med/agregar'.'/'.$tipo.'/'.$anio,$this->oPlan->schema,'','Agregar Plan','formcustom','formcustom',false,$this->oPlan->schema_up);
		$this->_run('crud');
    }
    
    public function buscarTipos(){
	    echo $this->oPlan->buscarTipos($this->input->post('id',TRUE));
    }
    
    public function tablas(){
 	    $id = $this->uri->segment(3);
 	    $this->template['tabs'] = '<ul class="nav nav-pills nav-justified" role="tablist" id="menuTabs">'.
	    								'<li class="active"><a href="#montas">Montas</a></li>'.
	    								'<li><a href="#engordas">Engordas</a></li>'.
	    								'<li><a href="#curvas">Curva de Crecimiento</a></li>'.
	    						  '</ul><hr />';
	    $this->template['titulo'] = $this->detGrupo->buscarTitulo($id);
 	    if(is_numeric($id)){
 		    $this->template['table'] = $this->grupos->tablaMontas($id,1,$this->uri->segment(4));
 	        $this->template['agregar'] = '';
 	        $this->template['action'] = '';
 	        $this->_run('tabla_montas');
         }
     }
     
    public function graficas(){
 	    $id = $this->uri->segment(3);
 	    $this->template['tabs'] = '<ul class="nav nav-pills nav-justified" role="tablist" id="menuTabs">'.
	    								'<li class="active"><a href="#por_fertilidad">% Fertilidad</a></li>'.
	    								'<li><a href="#inventario">Inventario Montas</a></li>'.
	    								'<li><a href="#perdida">Perdida Pre&ntilde;ez</a></li>'.
	    						  '</ul><hr />';
	    $this->template['titulo'] = $this->detGrupo->buscarTitulo($id);
	    $this->grupos->graficaFertilidad($id,$this->uri->segment(4));
	    $this->template['cat_fer'] = $this->grupos->categorias;
	    $this->template['ser_fer'] = $this->grupos->series;
	    $this->grupos->graficoInventario($id,$this->uri->segment(4));
	    $this->template['cat_inv'] = $this->grupos->categorias;
	    $this->template['ser_inv'] = $this->grupos->series;
	    $this->grupos->graficoPerdidas($id,$this->uri->segment(4));
	    $this->template['cat_per'] = $this->grupos->categorias;
	    $this->template['ser_per'] = $this->grupos->series;
 	    $this->_run('graficas');
     }
    
    public function periodos() {
	    $id = $this->uri->segment(3);
	    if(!is_numeric($id) && $id !== 'crear'){
		    $param = array(
	            'cabecera' => array("Id", "Cliente", "Descripcion", "Periodo"),
	            'open' => '<table class="table table-striped table-hover table-condensed">'
	        );
	        $campos = $this->grupos->find('result', 
        	array('fields' => array('idgranjas_mstr','granjas_desc','granjas_mfg_addr','group_year'),
        		'distinct' => true,
        		'conditions' => array('granjas_status' => 1, 'group_status' => 1),
        		'join' => array(
					'clause' => array('granjas_mstr' => 'granjas_mstr.idgranjas_mstr = group_mstr.group_id_granja'),
					'type' => 'INNER'
				)
        	));
		    $this->param = array_merge($param, array('datos' => $campos));
		    $this->param = array_merge($this->param, array('leyenda' => "Granjas"));
	        $this->template['table'] = $this->generate_table('', $this->param);
	        $this->template['table_action'] = $id !== 'tablas' ? $id == 'graficas' ? site_url('monitores/graficas')  : site_url('monitores/index') : site_url('monitores/tablas');
	        $this->template['action'] = site_url('monitores/periodos/crear');
	        $this->_run('seleccion');
	    }
	    if(!is_numeric($id) && $id == 'crear'){
		    $this->template['titulo'] = !is_numeric($id) ? "Periodo Nuevo" : "Modificar Periodo";	    
		   	$this->form_validation->set_rules('group_year','Periodo','trim|required');
		   	$datos = '';
		   	$this->grupos->prepararForm();
		   	$this->template['formulario'] = $this->_getForm('monitores/periodos'.'/'.$id,$this->grupos->schema,$datos,'Periodos',null,'form-inline',false,$this->grupos->schema_add);
			if($this->form_validation->run()){
				$datos = elements($this->grupos->schema(),$this->input->post(NULL, TRUE));
				$datos['group_status'] = 1;
				if($this->input->post('eliminar',TRUE) != NULL)
					$datos['group_status'] = 0;
				$this->grupos->abrir_periodo_montas($this->input->post('group_id_granja',TRUE),$this->input->post('group_year',TRUE));
			}
			if($this->input->post('eliminar',TRUE) != NULL)
				$this->periodos();
			else
				$this->_run('crud');
	    }
    }
    
    public function buscarInv(){
	    $semana = $this->input->post('semana',TRUE);
	    $granja = $this->input->post('granja',TRUE);
	    $year = $this->input->post('year',TRUE);
	    $id = $this->grupos->buscar_id($granja,$semana,$year);	    
	    $campos = $this->grupos->find('result',array('fields' => array('group_qty'),'conditions' => array('idgroup_mstr' => $id, 'group_status' => 1)));
	    $campos = $campos->row(0);
	    echo $campos->group_qty;
    }
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */