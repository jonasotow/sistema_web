<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  contactos Class
 *
 *  @category:  Controlador
 *  @author:    José Manzo
 */
class Agendatecnicos_Calendario extends MY_Controller {

    var $param;

    function __construct() {
        parent::__construct();
        $this->load->model('agendatecnicos/cal_model','oCal',FALSE,'agenda');
		$this->load->model('agendatecnicos/caldet_model','oCalDet',FALSE,'agenda');
		$this->load->model('agendatecnicos/tecnicos_model','oTec',FALSE,'agenda'); 
		$this->load->model('censos/granjas_model','oGranja',FALSE);
        $this->template['module'] = 'calendario';
    }

    /**
     * Muestra lista de contactos
     * 
     * @access public
     */
    public function index() {
	 /* $tecnicos = $this->oTec->find('result',array(
                    'fields' => array('tec_id','tec_nombre','tec_apellidos','tec_color'),'conditions' => array('tec_estatus' => 1)))->result_array();  */
        
        $usuario = $this->session->userdata('logged_user')->usu_id;
        $this->template['id_usuario'] = $usuario;

        $this->db->select('usu_id,usu_nombre,usu_apellido_paterno,usutip_id_usuario,usutip_id_asignado,usutip_id_tipo,tec_id_usuario,tec_color');
        $this->db->from('usuarios.usu_usuarios_mstr as usu');
        $this->db->join('usuarios.usutip_usuarios_tipos_det as usudet','usudet.usutip_id_usuario = usu.usu_id', 'INNER');   
        $this->db->join('agenda_tecnicos.tec_tecnicos_mstr as agetec','agetec.tec_id_usuario = usudet.usutip_id_usuario', 'INNER');  
        $this->db->where('usudet.usutip_id_asignado', $usuario); 
        //$this->db->or_where('usu.usu_id', $usuario);
        $this->db->where('usudet.usutip_id_tipo', 2);
        $this->db->where('usu.usu_estatus', 1);

        $tecnicos = $this->db->get()->result_array();

	    $cal_select = "<select id='cal_tecnicos' class='selectpicker' style='width:80%; margin:0px auto 10px; padding: .4em;'>";
	   // $cal_select .= "<option value='".$usuario."' data-color=''>Mi Calendario</option>";
        $select = "<select id='tecnicos' class='selectpicker' style='margin-bottom:12px; width:95%; padding: .4em;'>";    
       // $cal_select .= "<option value='0' selected> Todos </option>";      
	    foreach($tecnicos as $tecnico){
            if($tecnico['usu_id'] === $usuario){
                $cal_select .= "<option value='".$tecnico['usu_id']."' data-color='".$tecnico['tec_color']."' selected>".$tecnico['usu_nombre']." ".$tecnico['usu_apellido_paterno']."</option>";    
            }else{
                $cal_select .= "<option value='".$tecnico['usu_id']."' data-color='".$tecnico['tec_color']."'>".$tecnico['usu_nombre']." ".$tecnico['usu_apellido_paterno']."</option>";
            }
		    $select .= "<option value='".$tecnico['usu_id']."' data-color='".$tecnico['tec_color']."'>".$tecnico['usu_nombre']." ".$tecnico['usu_apellido_paterno']."</option>";
		    
	    }
	    $cal_select .= "</select>";
	    $select .= "</select>";
	    $this->template['tecnicos'] = $select;
	    $this->template['cal_tecnicos'] = $cal_select;
	    $dbCensos = $this->load->database('censos', TRUE);
	    $granjas =  $this->oGranja->find('result',array('fields' => array('gran_id_granja','gran_nombre'),'conditions' => array('gran_estatus' => 1)))->result_array();
	    $select_gran = "<select id='granjas' class='selectpicker' style='margin-bottom:12px; width:95%; padding: .4em;'>";
	    foreach($granjas as $granja){
		    $select_gran .= "<option value='".$granja['gran_id_granja']."' >".$granja['gran_nombre']."</option>";
	    }
	    $select_gran .= "</select>";
	    $this->template['granjas'] = $select_gran;
	    $this->_run('calendar');
    }
    
    public function addEvent(){
    	echo $this->oCal->addItem(json_decode($this->input->post('datos',TRUE)));  
    }
    
    public function viewEvent(){
	   echo $this->oCal->viewItem($this->input->post('id',TRUE));
    }
    
    public function delEvent(){
	    $this->oCal->delItem($this->input->post('id',TRUE));
    }
}

/* End of file contactos.php */
/* Location: ./application/censos/controllers/contactos.php */
    