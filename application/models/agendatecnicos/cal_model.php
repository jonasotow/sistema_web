<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  contacto_model Class
 *
 *  @category:  Modelo
 *  @author:    José Manzo
 */
class Cal_Model extends My_Model {
    public $table_name;

    function __construct($db = null) {
        parent::__construct($db);
        $this->load->model('agendatecnicos/caldet_model','oCalDet',FALSE,'agenda');
        $this->table_name = 'cal_mstr';
    }
    
    function addItem($oObj){
	    date_default_timezone_set('UTC');
	    foreach($oObj as $dato){	    	

		    $cal = array(
						'cal_agendaId' => 0,
						'cal_what' => $dato->what,
						'cal_startDate' => $dato->startDate,
						'cal_endDate' => $dato->endDate,
						'cal_allDay' => $dato->allDay,
						'cal_backgroundColor' => $dato->backgroundColor,
						'cal_foregroundColor' => $dato->foregroundColor
					);

		    /* Que fecha final no sea menor a la fecha inicial */
		    if ((($dato->endDate) < ($dato->startDate)) || $dato->startDate === $dato->endDate) {
		   		return 0;
		    }


		    /* Que no se empalmen eventos */
		    $cal_id_tec = $dato->data->tec_id_usuario;
		    $cal_fch_ini = $dato->startDate;
		    $cal_fch_fin = $dato->endDate;

		    $pasa = $this->validaFechas($cal_id_tec,$cal_fch_ini,$cal_fch_fin); 

		    if(! $pasa ) 
   				return 0;

		    /* **************** */
		    
			$this->save($cal);
			if($this->insert_id != 0){
				foreach($dato->data as $key => $value){
					$cald = array(
						'idcal_mstr' =>$this->insert_id,
						'cald_key' => $key,
						'cald_value' => $value
					);
					$this->oCalDet->save($cald);
				}
			}
	    }
		return $this->insert_id;
    }
    
    function delItem($id){
	    $this->delete(array('idcal_mstr' => $id));
	    $this->oCalDet->delete(array('idcal_mstr' => $id));
    }
    
    function viewItem($id){
	     $condition = array();
	    if($id != 0)
	    	$events = $this->dbUse->query("SELECT "
											. "Uno.idcal_mstr, "
											. "Uno.cal_agendaId, "
											. "Uno.cal_what, "
											. "Uno.cal_startDate, "
											. "Uno.cal_endDate, "
											. "Uno.cal_allDay, "
											. "Uno.cal_backgroundColor, "
											. "Uno.cal_foregroundColor, "
											. "cald_det.cald_key, "
											. "cald_det.cald_value "
										. "FROM ( "
											. "SELECT "
												. "cal_mstr.idcal_mstr, "
												. "cal_agendaId, "
												. "cal_what, "
												. "cal_startDate, "
												. "cal_endDate, "
												. "cal_allDay, "
												. "cal_backgroundColor, "
												. "cal_foregroundColor, "
												. "cald_key, "
												. "cald_value "
											. "FROM (`cal_mstr`) "
											. "INNER JOIN `cald_det` ON `cald_det`.`idcal_mstr` = `cal_mstr`.`idcal_mstr` "
											. "WHERE `cald_key` =  'tec_id_usuario' "
											. "AND `cald_value` =  '".$id."' )  AS Uno "
										. "INNER JOIN cald_det ON Uno.idcal_mstr = cald_det.idcal_mstr;");
    	else
		    $events = $this->oCal->find('result',array(
		    	'join' => array(
							'clause' => array('cald_det' => 'cald_det.idcal_mstr = cal_mstr.idcal_mstr' ),
							'type' => 'INNER')
				));
	    $events = $events->result_array();
	    $list = array();
	    $det = array();
	    foreach($events as $event){
		    $det[] = array(
	    		'idcal_mstr' => $event['idcal_mstr'],
	    		'cald_key' => $event['cald_key'],
	    		'cald_value' => $event['cald_value']
	    	);
		    array_pop($event);
	    	array_pop($event);
	    	array_pop($event);
	    	if(count($list) == 0)
	    		$list[] = $event;
	    	else if(!$this->_encontrar($list,$event))
	    		$list[] = $event;
    	}
    	$events = $list;
  	    $list = array();
  	    foreach($events as $event){
 	 	    $keys = array();
 	 	    foreach($det as $data){
 	 	    	if($event['idcal_mstr'] === $data['idcal_mstr'])
 	 	    		$keys[$data['cald_key']] = $data['cald_value'];
  	    	}
  	    	if(is_array($keys))
  	    		$keys['id'] = $event['idcal_mstr'];
  	    	$event['Data'] = $keys;
  	    	$list[] = $event;
  	    }
	    echo json_encode($list);
    }

    function viewReporte($id,$fecha_inicio,$fecha_final){
	     $condition = array();

	     if($fecha_inicio == ""){
	     	$fecha_inicio = date('d/m/Y', PHP_INT_MAX + 1); // minimum valid date			
	     }

	     if($fecha_final == ""){
	     	$fecha_final = date('d/m/Y', PHP_INT_MAX); // maximum valid date
	     }

	    if($id != 0){
	    	$events = $this->dbUse->query("SELECT "
											. "Uno.idcal_mstr, "
											. "Uno.cal_agendaId, "
											. "Uno.cal_what, "
											. "Uno.cal_startDate, "
											. "Uno.cal_endDate, "
											. "Uno.cal_allDay, "
											. "Uno.cal_backgroundColor, "
											. "Uno.cal_foregroundColor, "
											. "cald_det.cald_key, "
											. "cald_det.cald_value "
										. "FROM ( "
											. "SELECT "
												. "cal_mstr.idcal_mstr, "
												. "cal_agendaId, "
												. "cal_what, "
												. "cal_startDate, "
												. "cal_endDate, "
												. "cal_allDay, "
												. "cal_backgroundColor, "
												. "cal_foregroundColor, "
												. "cald_key, "
												. "cald_value "
											. "FROM (`cal_mstr`) "
											. "INNER JOIN `cald_det` ON `cald_det`.`idcal_mstr` = `cal_mstr`.`idcal_mstr` "
											. "WHERE `cald_key` =  'tec_id_usuario' "
											. "AND `cal_startDate` >= '".$fecha_inicio."' "
											. "AND `cal_startDate` <=  '".$fecha_final."' "
											. "AND `cald_value` =  '".$id."' )  AS Uno "
										. "INNER JOIN cald_det ON Uno.idcal_mstr = cald_det.idcal_mstr;");
    	}else{
		    $events = $this->oCal->find('result',array(
		    	'join' => array(
							'clause' => array('cald_det' => 'cald_det.idcal_mstr = cal_mstr.idcal_mstr'),
							'type' => 'INNER')
				));
		}

	    $events = $events->result_array();
	    $list = array();
	    $det = array();
	    foreach($events as $event){
		    $det[] = array(
	    		'idcal_mstr' => $event['idcal_mstr'],
	    		'cald_key' => $event['cald_key'],
	    		'cald_value' => $event['cald_value']
	    	);
		    array_pop($event);
	    	array_pop($event);
	    	array_pop($event);
	    	if(count($list) == 0)
	    		$list[] = $event;
	    	else if(!$this->_encontrar($list,$event))
	    		$list[] = $event;
    	}
    	$events = $list;
  	    $list = array();
  	    foreach($events as $event){
 	 	    $keys = array();
 	 	    foreach($det as $data){
 	 	    	if($event['idcal_mstr'] === $data['idcal_mstr'])
 	 	    		$keys[$data['cald_key']] = $data['cald_value'];
  	    	}
  	    	if(is_array($keys))
  	    		$keys['id'] = $event['idcal_mstr'];
  	    	$event['Data'] = $keys;
  	    	$list[] = $event;
  	    }
	    return $list;
    }

    private function _encontrar($aInicio,$aBuscar){
	    foreach($aInicio as $inicio){
		    if($inicio === $aBuscar)
		    	return true;
	    }
	    return false;
    }

     function validaFechas($id_tec,$fch_ini,$fch_fin){
    	/* ********************************************* */

		    /* Valida que no se empalmen eventos */		    
		    $fch_inicial = date("Y-m-d H:i:s", strtotime($fch_ini));
		    $fch_final = date("Y-m-d H:i:s", strtotime($fch_fin));

		    /*if (!($fch_inicial < $fila->cal_startDate and $fch_final <= $fila->cal_startDate)
					or  !($fch_inicial >= $fila->cal_endDate and $fecha_final > $fch_inicial)
					or  !($fch_inicial < $fch_final)){
						return false;
					}
*/

			$this->dbUse->select('*');
			$this->dbUse->from('cal_mstr');
			$this->dbUse->join('cald_det','cald_det.idcal_mstr = cal_mstr.idcal_mstr');
			$this->dbUse->where('cald_key', 'tec_id_usuario');
			$this->dbUse->where('cald_value', $id_tec);

			$consulta = $this->dbUse->get();

			if ($consulta->num_rows() > 0){	
				foreach ($consulta->result() as $fila)
				{
					/*print_r($fila->cal_startDate."    ".$fila->cal_endDate);
					print_r("    ");
					print_r($fch_inicial."    ".$fch_final); */

					if (!(($fch_inicial < $fila->cal_startDate and $fch_final <= $fila->cal_startDate)
					or  ($fch_inicial >= $fila->cal_endDate and $fch_final > $fch_inicial))){
						return false;
						break;
					}
				}
			}

			return true;
			/* ********************************** */

    }

}

/* End of file campos_model.php */
/* Location: ./application/censos/models/campos_model.php */