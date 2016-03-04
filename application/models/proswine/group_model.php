<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 * Super Class
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Author Alfredo Garcia
 * @link http://localhost/sistema_web/censos.php/
 */
class Group_Model extends My_Model {
    public $table_name;
    public $schema;
    public $categorias;
    public $series;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
        $this->load->model($this->aplicacion.'/montas_model','oLactancia');
        $this->table_name = 'group_mstr';
        $this->schema_add = array(
        	'Borrar' => array(
				'tipo' => 'reset',
				'label' => 'Borrar',
				'class' => 'btn btn-primary',
				'id' => 'borrar'
			),
			'Guardar' => array(
				'tipo' => 'submit',
				'label' => 'Guardar',
				'class' => 'btn btn-primary',
				'id' => 'guardar'
			)
        );
        $this->schema_up = array(
        	'Borrar' => array(
				'tipo' => 'reset',
				'label' => 'Borrar',
				'class' => 'btn btn-primary',
				'id' => 'borrar'
			),
			'Guardar' => array(
				'tipo' => 'submit',
				'label' => 'Guardar',
				'class' => 'btn btn-primary',
				'id' => 'guardar'
			),
			'Eliminar' => array(
				'tipo' => 'submit',
				'label' => 'Eliminar',
				'class' => 'btn btn-primary',
				'id' => 'eliminar'
			)
        );
         $this->schema = array(
         	'Datos' => array(
         		'class' => 'ejemplo',
         		'id' => 'formulario',
	        	'idgroup_mstr' => array(
	        		'name' => 'Id',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => TRUE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	),
	        	'group_id' => array(
	        		'name' => 'Grupo',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	),
	        	'group_id_granja' => array(
	        		'name' => 'Granja',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'dropdown'
	        	),
	        	'group_year' => array(
	        		'name' => 'Periodo',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => TRUE,
					'type' => 'number'
	        	),
	        	'group_qty' => array(
	        		'name' => 'Inv',
	        		'tipo' => 'int',
	        		'lenght' => 25,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	),
	        	'group_status' => array(
	        		'name' => 'Estatus',
	        		'tipo' => 'boolean',
	        		'lenght' => 1,
	        		'null' => FALSE,
	        		'primary' => FALSE,
	        		'update' => FALSE,
					'type' => 'hidden'
	        	)
	        )
        );
    }
    
    function prepararForm(){
		$forms = array();
	    $formularios = $this->get_value('granjas_mstr',array('idgranjas_mstr', 'granjas_desc'),array('granjas_status' => 1));
	    $forms[''] = 'Seleccione una Granja';
		foreach($formularios as $formulario){
			$forms[$formulario->idgranjas_mstr] = $formulario->granjas_desc;
		}
		$this->schema['Datos']['group_id_granja']['data'] = $forms;
    }
    
    function get_value($table,$fields,$where = null) {
        $this->db->select($fields);
        if($where != null)
        	$this->db->where($where);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function abrir_periodo_montas($idgranja, $year){
	    $campos = $this->array_schema();
	    for( $i=1;$i <= 52; $i++ ){
		    $campos['group_id'] = $i;
		    $campos['group_year'] = $year;
		    $campos['group_qty'] = 0;
		    $campos['group_status'] = 1;
		    $campos['group_id_granja'] = $idgranja;
		    try{
		    	$this->save($campos);
	    	}catch(Exception $e){}
	    }
    }
    
    function buscar_id($idgranja,$week,$year){
	    $datos = $this->find('first', array('conditions' => array('group_id_granja' => $idgranja, 'group_year' => $year, 'group_id' => $week)));
	    return $datos->idgroup_mstr;
    }
    
    function buscarTabla($id,$site,$tipo,$html){
	    $datos = $this->find('array', 
        	array('fields' => array('idgroupd_det','group_id', 'group_year', 'group_qty', 'groupd_week', 'groupd_qty', 'groupd_cmmt'),
        		'conditions' => array('group_status' => 1, 'idgranjas_mstr' => $id, 'groupd_site' => $site, 'groupd_type' => $tipo),
        		'join' => array(
					'clause' => array('groupd_det' => 'group_mstr.idgroup_mstr = groupd_det.groupd_id_group', 'granjas_mstr' => 'group_id_granja = idgranjas_mstr'),
					'type' => 'INNER'
				)
        	));
        $lista = array();
        $cabecera = array();
        $grupos = array();
        $anterior = null;
        $i = 0;
        if(!empty($datos)){
	        foreach($datos as $dato){
		        if($anterior == null){
		        	$anterior = $dato->group_id;
		        	$lista[$dato->group_id]['inv'] = array('inv' => $dato->group_qty);
	        	}
		        if($anterior != $dato->group_id){
			        $anterior = $dato->group_id;
			        $lista[$dato->group_id]['inv'] = array('inv' => $dato->group_qty);
		        }
		        $lista[$dato->group_id][$dato->groupd_week] = array("semana" => $dato->groupd_week,"cantidad" => $dato->groupd_qty, "id" => $dato->idgroupd_det, 'cmmt' => $dato->groupd_cmmt);
		        $cabecera[$i] = $dato->groupd_week;
		        $grupos[$i] = $dato->group_id;
		        $i++;
	        }
	         $this->table->set_template(array('table_open' => "<table class='table table-striped table-hover table-condensed' id='".$html."'>"));
	        $cabecera = array_unique($cabecera);
	        sort($cabecera);
	        $this->categorias = str_replace('"',"",json_encode($cabecera));
	        $grupos = array_unique($grupos);
	        sort($grupos);
	        $this->table->set_heading(explode(",", 'Id,Gpo,Inv,'.implode($cabecera,",")));
	        $series = array();
	                
	        for($i = 0; $i < count($grupos); $i++){
		        $row = array();
		        $serie = array();
		        for($j = 0; $j <= count($cabecera) + 2; $j++){
			        if($j == 1 || $j == 0)
			        	$row[$j] = $grupos[$i];
			        else if($j == 2)
			        	$row[$j] = $lista[$grupos[$i]]['inv']['inv'];
			        else if(array_key_exists($cabecera[$j-3],$lista[$grupos[$i]])){
				        $row[$j] = array('data' => $lista[$grupos[$i]][$cabecera[$j-3]]['cantidad'], 'data-cmmt' => $lista[$grupos[$i]][$cabecera[$j-3]]['cmmt'], 'id' => $lista[$grupos[$i]][$cabecera[$j-3]]['id']);
				        $serie[$j] = $lista[$grupos[$i]][$cabecera[$j-3]]['cantidad'];
			        }
		        }
		     	$series[$i] = array("name" => $grupos[$i], "data" => explode(",", implode(",", $serie)));
		        $this->table->add_row($row);
	        }
	        $this->series = str_replace('"',"",json_encode($series));
	        return $this->table->generate();
        }
        return '<div class="alert alert-info" role="alert">No hay datos disponibles</div>';
    }
    
    function tablaMontas($id,$site,$year){
	    $tabla_montas = "<table class='table table-striped table-hover table-condensed'>".
	    	"<thead>".
	    		"<tr>".
	    			"<th>id<th>".
	    			"<th rowspan=2>Grupo</th>".
	    			"<th colspan=2>Fechas</th>".
	    			"<th rowspan=2>No. de Montas</th>".
	    			"<th colspan=16>Semanas</th>".
	    			"<th rowspan=2>Partos</th>".
	    			"<th rowspan=2>% Fert</th>".
	    			"<th colspan=2>Fechas Partos</th>".
	    			"<th rowspan=2>Semana Parto</th>".
	    			"<th colspan=5>Lactancia</th>".
	    		"</tr>".
	    		"<tr>".
	    			"<th>id<th>".
	    			"<th>Del</th>".
	    			"<th>Al</th>".
	    			"<th>1</th>".
	    			"<th>2</th>".
	    			"<th>3</th>".
	    			"<th>4</th>".
	    			"<th>5</th>".
	    			"<th>6</th>".
	    			"<th>7</th>".
	    			"<th>8</th>".
	    			"<th>9</th>".
	    			"<th>10</th>".
	    			"<th>11</th>".
	    			"<th>12</th>".
	    			"<th>13</th>".
	    			"<th>14</th>".
	    			"<th>15</th>".
	    			"<th>16</th>".
	    			"<th>Del</th>".
	    			"<th>Al</th>".
	    			"<th>1</th>".
	    			"<th>2</th>".
	    			"<th>3</th>".
	    			"<th>4</th>".
	    			"<th>5</th>".
	    		"</tr>".
	    	"</thead>".
	    	"<tbody>";
	    $montas = $this->find('array', 
        	array('fields' => array('idgroupd_det','group_id', 'group_year', 'group_qty', 'groupd_week', 'groupd_qty', 'groupd_cmmt'),
        		'conditions' => array('group_status' => 1, 'idgranjas_mstr' => $id, 'groupd_site' => $site, 'groupd_type' => 1, 'group_year' => $year),
        		'join' => array(
					'clause' => array('groupd_det' => 'group_mstr.idgroup_mstr = groupd_det.groupd_id_group', 'granjas_mstr' => 'group_id_granja = idgranjas_mstr'),
					'type' => 'INNER'
				)
        	));
        $lactancia = $this->find('array', 
        	array('fields' => array('idgroupd_det','group_id', 'group_year', 'group_qty', 'groupd_week', 'groupd_qty', 'groupd_cmmt'),
        		'conditions' => array('group_status' => 1, 'idgranjas_mstr' => $id, 'groupd_site' => $site, 'groupd_type' => 2, 'group_year' => $year),
        		'join' => array(
					'clause' => array('groupd_det' => 'group_mstr.idgroup_mstr = groupd_det.groupd_id_group', 'granjas_mstr' => 'group_id_granja = idgranjas_mstr'),
					'type' => 'INNER'
				)
        	));
        $partos = $this->oLactancia->find('array',array( 
					'fields' => array('idmontas_mstr','group_id','montas_partos_ini','montas_partos_fin','montas_partos','(montas_partos / group_qty) * 100 as porcentaje','montas_semana'),
					'conditions' => array('group_id_granja' => $id, 'group_year' => $year),
					'join' => array(
						'clause' => array('group_mstr' => 'group_mstr.idgroup_mstr = montas_mstr.montas_id_group'),
						'type' => 'INNER'
					)
					));
        $lista = array();
        $lista_lactancia = array();
        $lista_partos = array();
        $grupos = array();
        $anterior = null;
        $i = 0;
        if(!empty($montas)){
	        foreach($montas as $dato){
		        if($anterior == null){
		        	$anterior = $dato->group_id;
		        	$lista[$dato->group_id]['inv'] = array('inv' => $dato->group_qty);
	        	}
		        if($anterior != $dato->group_id){
			        $anterior = $dato->group_id;
			        $lista[$dato->group_id]['inv'] = array('inv' => $dato->group_qty);
		        }
		        $lista[$dato->group_id][$dato->groupd_week] = $dato->groupd_qty;
		        $grupos[$i] = $dato->group_id;
		        $i++;
	        }
	        $grupos = array_unique($grupos);
	        sort($grupos);
	        
	        foreach($lactancia as $dato){
		        $lista_lactancia[$dato->group_id][$dato->groupd_week] = $dato->groupd_qty;
	        }
	        
	        foreach($partos as $dato){
		        $lista_partos[$dato->group_id][0] = $dato->montas_partos;
		        $lista_partos[$dato->group_id][1] = $dato->porcentaje."%";
		        $lista_partos[$dato->group_id][2] = $dato->montas_partos_ini;
		        $lista_partos[$dato->group_id][3] = $dato->montas_partos_fin;		        
		        $lista_partos[$dato->group_id][4] = $dato->montas_semana;
	        }
	        
	        //echo "<pre>"; echo print_r($lista_partos); echo "</pre>";
	                
	        for($i = 0; $i < count($grupos); $i++){
		        $tabla_montas .= "<tr>";
		        $row = array();
		        for($j = 0; $j <= 29 + 2; $j++){
			        if($j == 2 || $j == 0)
			        	$row[$j] = $grupos[$i];
			        else if($j == 1)
			        	$row[$j] = '';	
			        else if ($j == 5)
			        	$row[$j] = $lista[$grupos[$i]]['inv']['inv'];
			        else if ($j == 3 || $j == 4){
			        	$year = $year;
						$week = $grupos[$i];
						# obtenemos el timestamp del primer dia del año
						$timestamp=mktime(0, 0, 0, 1, 1, $year);						
						# sumamos el timestamp de la suma de las semanas actuales
						$timestamp+=$week*7*24*60*60;						
						# restamos la posición inicial del primer dia del año
						$ultimoDia=$timestamp-date("w", mktime(0, 0, 0, 1, 1, $year))*24*60*60;						
						# le restamos los dias que hay hasta llegar al lunes
						$primerDia=$ultimoDia-86400*(date('N',$ultimoDia)-1);
						if($lista[$grupos[$i]]['inv']['inv'] == 0)
							$row[$j] = '';
						else
							$row[$j] = $j == 4 ? date("Y-m-d",$primerDia) : date("Y-m-d",$ultimoDia);
			        }
 			        else if($j <= 21)
 				        $row[$j] = $lista[$grupos[$i]][$j - 5];
 				    else if($j > 21 && $j <= 26){
 				    	if(array_key_exists($grupos[$i],$lista_partos))
 				    		$row[$j] = $lista_partos[$grupos[$i]][$j - 22];
 				    	else
 				    		$row[$j] = '';
				    }
 				    else if($j > 26){
 				    	if(array_key_exists($grupos[$i],$lista_lactancia))
 				    		if(array_key_exists(($j - 26),$lista_lactancia[$grupos[$i]]))
				    			$row[$j] = $lista_lactancia[$grupos[$i]][$j - 26];
				    	else
 				    		$row[$j] = '';
				    } 				    
		        }
		        for($x = 0; $x < count($row); $x++){
			        $tabla_montas .= "<td>".$row[$x]."</td>";
	        	}
		        //echo "<pre>"; echo print_r($row); echo "</pre>";
		        $tabla_montas .= "</tr>";
	        }
	       	return $tabla_montas;
        }
        return '<div class="alert alert-info" role="alert">No hay datos disponibles</div>';
    }
    
    function graficaFertilidad($granja,$periodo){
	    $datos = $this->oLactancia->find('array',array( 
					'fields' => array('idmontas_mstr','group_id','montas_partos_ini','montas_partos_fin','montas_partos','(montas_partos / group_qty) * 100 as porcentaje','montas_semana'),
					'conditions' => array('group_id_granja' => $granja, 'group_year' => $periodo),
					'join' => array(
						'clause' => array('group_mstr' => 'group_mstr.idgroup_mstr = montas_mstr.montas_id_group'),
						'type' => 'INNER'
				)
		));
	    $lista = array();
        $cabecera = array();
        $grupos = array();
        $anterior = null;
        $i = 0;
        if(!empty($datos)){
	       foreach($datos as $dato){
		        $lista[$dato->group_id][0] = $dato->montas_partos;
		        $lista[$dato->group_id][1] = $dato->porcentaje;
		        $lista[$dato->group_id][2] = $dato->montas_partos_ini;
		        $lista[$dato->group_id][3] = $dato->montas_partos_fin;		        
		        $lista[$dato->group_id][4] = $dato->montas_semana;
		        $cabecera[$i] = $dato->montas_semana;
		        $grupos[$i] = $dato->group_id;
		        $i++;		        
	        }
	        $cabecera = array_unique($cabecera);
	        sort($cabecera);
	        $this->categorias = str_replace('"',"",json_encode($cabecera));
	        $grupos = array_unique($grupos);
	        sort($grupos);
	        $series = array();
	        for($i = 0; $i < count($grupos); $i++){
		        $series[$i] = $lista[$grupos[$i]][1];		     	
	        }
	        $series = array("name" => "'Fertilidad'", "data" => explode(",", implode(",", $series)));
	        $this->series = "[".str_replace('"',"",json_encode($series))."]";
	        return;
        }
        return '<div class="alert alert-info" role="alert">No hay datos disponibles</div>';
    }
    
    function graficoInventario($granja,$periodo){
	    $datos = $this->find('array', 
        	array('fields' => array('idgroupd_det','group_id', 'group_year', 'group_qty', 'groupd_week', 'groupd_qty', 'groupd_cmmt'),
        		'conditions' => array('group_status' => 1, 'idgranjas_mstr' => $granja, 'groupd_site' => 1, 'groupd_type' => 1, 'group_year' => $periodo),
        		'join' => array(
					'clause' => array('groupd_det' => 'group_mstr.idgroup_mstr = groupd_det.groupd_id_group', 'granjas_mstr' => 'group_id_granja = idgranjas_mstr'),
					'type' => 'INNER'
				)
        	));
	    $lista = array();
        $grupos = array();
        $i = 0;
        if(!empty($datos)){
	       foreach($datos as $dato){
		        $lista[$dato->group_id][$dato->groupd_week] = $dato->groupd_qty;
		        $grupos[$i] = $dato->group_id;
		        $i++;
	        }
	        $grupos = array_unique($grupos);
	        sort($grupos);
	        $this->categorias = str_replace('"',"",json_encode($grupos));
	        $series = array();
	        for($j = 1; $j <= count($grupos); $j++){
		        $inv = 0;
		        $sem = $j;
		        for($x = 0; $x < count($grupos); $x++)
		        {
			        if($sem == 1){
			        	$inv += $lista[$grupos[$x]][$sem];
			        	break;
		        	}
		        	if($sem < 17)
			        	$inv += $lista[$grupos[$x]][$sem];
			        $sem--;
		        }
		        $series[$grupos[$j-1]] = $inv;
	        }
	        $series = array("name" => "'Inventario'", "data" => explode(",", implode(",", $series)));
			$this->series = "[".str_replace('"',"",json_encode($series))."]";
	        return;
        }
        return '<div class="alert alert-info" role="alert">No hay datos disponibles</div>';
    }
    
    function graficoPerdidas($granja,$periodo){
	    $datos = $this->find('array', 
        	array('fields' => array('idgroupd_det','group_id', 'group_year', 'group_qty', 'groupd_week', 'groupd_qty', 'groupd_cmmt'),
        		'conditions' => array('group_status' => 1, 'idgranjas_mstr' => $granja, 'groupd_site' => 1, 'groupd_type' => 1, 'group_year' => $periodo),
        		'join' => array(
					'clause' => array('groupd_det' => 'group_mstr.idgroup_mstr = groupd_det.groupd_id_group', 'granjas_mstr' => 'group_id_granja = idgranjas_mstr'),
					'type' => 'INNER'
				)
        	));
	    $lista = array();
        $grupos = array();
        $cabecera = array();
        $anterior = null;
        $i = 0;
        if(!empty($datos)){
	        foreach($datos as $dato){
		        if($anterior == null){
		        	$anterior = $dato->group_id;
		        	$lista[$dato->group_id][0] = $dato->group_qty;
	        	}
		        if($anterior != $dato->group_id){
			        $anterior = $dato->group_id;
			        $lista[$dato->group_id][0] = $dato->group_qty;
		        }
		        $lista[$dato->group_id][$dato->groupd_week] = $dato->groupd_qty;
		        $grupos[$i] = $dato->group_id;
		        $i++;
	        }
	        $cabecera = array_unique($cabecera);
	        sort($cabecera);
	        $grupos = array_unique($grupos);
	        sort($grupos);
	        $this->categorias = str_replace('"',"",json_encode($cabecera));
	        $series = array();
		    $inv_anterior = 0;
	        for($x = 0; $x <= 16; $x++){
		        $inv = 0;
		        for($j = 0; $j < count($grupos); $j++)
		        {
			        $inv += $lista[$grupos[$j]][$x];
			    }
			    $inv_anterior = $inv_anterior <= 0 ? $inv : $inv_anterior;
			    $temp = $inv - $inv_anterior;
		        $series[$x] = $inv == 0 ? 0 : abs(($temp / $inv_anterior) * 100);
		        $inv_anterior = $inv;
	        }
	        $series = array("name" => "'% Perdida'", "data" => explode(",", implode(",", $series)));
			$this->series = "[".str_replace('"',"",json_encode($series))."]";
	        return;
        }
        return '<div class="alert alert-info" role="alert">No hay datos disponibles</div>';
    }
}

/* End of file granjas_model.php */
/* Location: ./application/censos/models/granjas_model.php */