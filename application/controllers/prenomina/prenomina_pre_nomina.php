<?php if (!defined('BASEPATH')) die('No direct script access allowed');
/**
 * Prenomina_pre_nomina
 *
 * @package Prenomina
 * @author Alfredo García
 **/
class Prenomina_pre_nomina extends MY_Controller {

  var $param;
    /**
     * [__construct description]
     */
  function __construct() {
    parent::__construct();
    $this->load->model('prenomina/Semanas_model','oSemanas',FALSE,'prenomina');
    $this->load->model('prenomina/Prenomina_model','oPrenomina',FALSE,'prenomina');
    $this->load->model('prenomina/Turnos_model','oTurnos',FALSE,'prenomina');
    $this->load->model('prenomina/Tipos_model','oTipos',FALSE,'prenomina');
    $this->load->model('prenomina/Motivos_te_model','oMotivosTE',FALSE,'prenomina');
    $this->load->model('prenomina/modelo_generico_model',FALSE,'prenomina');
    $this->template['module'] = 'prenomina';
  }

  /**
   * [index description]
   * @return [type] [description]
   */
  public function index() {
    $this->template['nav'] = anchor(site_url("aplicaciones/home"), " " , "class='fa fa-arrow-left'");
    $this->template['nav'].= anchor(site_url("pre_nomina/crear/"), " " , "class='fa fa-plus-square'");

    $plantilla = array ( "table_open"  => "<table class='table table-striped table-hover table-condensed'>" );
    $this->table->set_template($plantilla);
    $consulta_tabla = $this->oSemanas->tablaSemanas();
    foreach($consulta_tabla as $key => $value) {
        $a_crear = anchor(site_url("pre_nomina/capturaHoras/" . $value->sem_id), " " , "class='fa fa-list-alt'");
        $a_edit = anchor(site_url("pre_nomina/crear/" . $value->sem_id), " " , "class='fa fa-pencil-square-o'");
        $a_delete = anchor(site_url("pre_nomina/delete/" . $value->sem_id), " " , "class='fa fa-trash-o' ");
        $estatus = "<i class='fa fa-circle-o'></i> ";
        $this->table->add_row($value->sem_id,$value->sem_ano_semana,$value->sem_dep_id,$estatus,$a_crear,$a_edit,$a_delete);
    }
    $this->table->set_heading(array('ID','Año/Semana', 'Ubicacion', 'estatus', '', '', ''));
    $this->template['table'] = $this->table->generate();
    $this->_run('tabla_ver');
  }

   public function crear() {
    $id = $this->uri->segment(3);
    $this->form_validation->set_rules('descripcion','Descripcion','required');
    $datos = '';
    $datos = $this->oSemanas->find('list',array('conditions' => array( 'sem_id' => $id )));
    $this->template['formulario'] = $this->_getForm(
												                            'prenomina/crear'.'/'.$id,
												                            $this->oSemanas->schema,
												                            $datos,
												                            "Semanas",
												                            'form-inline',
												                            'form-inline',
												                            FALSE,
												                            $this->oSemanas->schema_add);
    if($this->form_validation->run()){
        $datos = elements($this->oSemanas->schema(),$this->input->post(NULL, TRUE));
        $this->template['formulario'] = $this->_getForm(
														                            'prenomina/crear'.'/'.$id,
														                            $this->oSemanas->schema,
														                            $datos,
														                            "Hojas Tecnicas",
														                            'form-inline',
														                            'form-inline',
														                            FALSE,
														                            $this->oSemanas->schema_add);
        $this->oSemanas->save($datos);
    }
    $this->_run('crud');
  }

  public function capturaHoras() {
    $id = $this->uri->segment(3);
    // consultas
    $consulta_tabla = $this->oPrenomina->tablaPrenominaEmpleados();
    $consulta_turnos = $this->oTurnos->turnosDiarios();
    $consulta_tipos  = $this->oTipos->tiposCausas();
    $consulta_causas  = $this->oMotivosTE->motivosTiempoExtra();
    // consultas --termina-- 
    
    // obtiene el arreglo para el select de turnos
    $array_turnos = array ();
    foreach ($consulta_turnos as $key => $valor_turnos){
      $array_turnos = $array_turnos + array($valor_turnos->tur_id => $valor_turnos->tur_clave_turno);
    }

    // obtiene el arreglo para el select de tipos
    $array_tipos = array ();
    foreach ($consulta_tipos as $key => $valor_tipos){
      $array_tipos = $array_tipos + array($valor_tipos->tip_id => $valor_tipos->tip_inicial);
    }
    // obtiene el arreglo para el select de causas
    $array_causas = array ();
    foreach ($consulta_causas as $key => $valor_causas){
      $array_causas = $array_causas + array($valor_causas->mte_id => $valor_causas->mte_descripcion);
    }

    $atributos = array('class' => 'form', 'id' => 'formulario_prenomina');
    $this->template['table'] = form_open('pre_nomina/insertPrenominaEmpleado', $atributos);
    $this->template['table'] .= form_label('# Semana : ', 'pre_semana_ano');
    $this->template['table'] .= form_input('pre_semana_ano', date('W'));
    
    $plantilla = array("table_open" => "<table class='table table-striped table-hover table-condensed'>" );
    $this->table->set_template($plantilla);
    $this->table->set_heading(array('ID','#', 'Nombre', 'T/l', 'l', 'E/l', 'T/M', 'M', 'E/M', 'T/X', 'X', 'E/X', 'T/J', 'J', 'E/J', 'T/V', 'V', 'E/V', 'T/S', 'S', 'E/S', 'T/D', 'D', 'E/D', 'Dobles', 'Triples', 'Causa','Motivo Causa', 'Observaciones'));
    
    foreach($consulta_tabla as $key => $value_prenomina) {
      $emp_id                 = form_hidden('pre_emp_id'.$value_prenomina->emp_id, $value_prenomina->emp_id);
      $tur_lunes              = form_dropdown('pre_tur_lunes'.$value_prenomina->emp_id, $array_turnos);
      $tur_martes             = form_dropdown('pre_tur_martes'.$value_prenomina->emp_id, $array_turnos);
      $tur_miercoles          = form_dropdown('pre_tur_miercoles'.$value_prenomina->emp_id, $array_turnos);
      $tur_jueves             = form_dropdown('pre_tur_jueves'.$value_prenomina->emp_id, $array_turnos);
      $tur_viernes            = form_dropdown('pre_tur_viernes'.$value_prenomina->emp_id, $array_turnos);
      $tur_sabado             = form_dropdown('pre_tur_sabado'.$value_prenomina->emp_id, $array_turnos);
      $tur_domingo            = form_dropdown('pre_tur_domingo'.$value_prenomina->emp_id, $array_turnos);
      $horas_extras_lunes     = form_input(array('name'=>'pre_horas_extras_lunes'.$value_prenomina->emp_id,'id'=>'pre_horas_extras_lunes'.$value_prenomina->emp_id,'type'=>'number','min'=>'0','max'=>'10'));
      $horas_extras_martes    = form_input(array('name'=>'pre_horas_extras_martes'.$value_prenomina->emp_id,'id'=>'pre_horas_extras_martes'.$value_prenomina->emp_id,'type'=>'number','min'=>'0','max'=>'10'));
      $horas_extras_miercoles = form_input(array('name'=>'pre_horas_extras_miercoles'.$value_prenomina->emp_id,'id'=>'pre_horas_extras_miercoles'.$value_prenomina->emp_id,'type'=>'number','min'=>'0','max'=>'10'));
      $horas_extras_jueves    = form_input(array('name'=>'pre_horas_extras_jueves'.$value_prenomina->emp_id,'id'=>'pre_horas_extras_jueves'.$value_prenomina->emp_id,'type'=>'number','min'=>'0','max'=>'10'));
      $horas_extras_viernes   = form_input(array('name'=>'pre_horas_extras_viernes'.$value_prenomina->emp_id,'id'=>'pre_horas_extras_viernes'.$value_prenomina->emp_id,'type'=>'number','min'=>'0','max'=>'10'));
      $horas_extras_sabado    = form_input(array('name'=>'pre_horas_extras_sabado'.$value_prenomina->emp_id,'id'=>'pre_horas_extras_sabado'.$value_prenomina->emp_id,'type'=>'number','min'=>'0','max'=>'10'));
      $horas_extras_domingo   = form_input(array('name'=>'pre_horas_extras_domingo'.$value_prenomina->emp_id,'id'=>'pre_horas_extras_domingo'.$value_prenomina->emp_id,'type'=>'number','min'=>'0','max'=>'10'));
      $tip_lunes              = form_dropdown('pre_tip_lunes'.$value_prenomina->emp_id, $array_tipos);
      $tip_martes             = form_dropdown('pre_tip_martes'.$value_prenomina->emp_id, $array_tipos);
      $tip_miercoles          = form_dropdown('pre_tip_miercoles'.$value_prenomina->emp_id, $array_tipos);
      $tip_jueves             = form_dropdown('pre_tip_jueves'.$value_prenomina->emp_id, $array_tipos);
      $tip_viernes            = form_dropdown('pre_tip_viernes'.$value_prenomina->emp_id, $array_tipos);
      $tip_sabado             = form_dropdown('pre_tip_sabado'.$value_prenomina->emp_id, $array_tipos);
      $tip_domingo            = form_dropdown('pre_tip_domingo'.$value_prenomina->emp_id, $array_tipos);
      $horas_extras_dobles    = form_input(array('name'=>'pre_horas_extras_dobles'.$value_prenomina->emp_id,'id'=>'pre_horas_extras_dobles'.$value_prenomina->emp_id,'type'=>'number'));
      $horas_extras_triples   = form_input(array('name'=>'pre_horas_extras_triples'.$value_prenomina->emp_id,'id'=>'pre_horas_extras_triples'.$value_prenomina->emp_id,'type'=>'number'));
      $mte_causas             = form_dropdown('pre_mte_causas'.$value_prenomina->emp_id, $array_causas);
      $motivo_causa           = form_input(array('name'=>'pre_motivo_causa'.$value_prenomina->emp_id,'id'=>'pre_motivo_causa'.$value_prenomina->emp_id,'type'=>'text'));
      $observaciones          = form_input(array('name'=>'pre_observaciones'.$value_prenomina->emp_id,'id'=>'pre_observaciones'.$value_prenomina->emp_id,'type'=>'text'));     
      
      $this->table->add_row($emp_id,$value_prenomina->emp_numero,$value_prenomina->emp_nombre.' '.$value_prenomina->emp_apellido_paterno.' '.$value_prenomina->emp_apellido_materno,
	                          $tur_lunes,$tip_lunes,$horas_extras_lunes,
	                          $tur_martes,$tip_martes,$horas_extras_martes,
	                          $tur_miercoles,$tip_miercoles,$horas_extras_miercoles,
	                          $tur_jueves,$tip_jueves,$horas_extras_jueves,
	                          $tur_viernes,$tip_viernes,$horas_extras_viernes,
	                          $tur_sabado,$tip_sabado,$horas_extras_sabado,
	                          $tur_domingo,$tip_domingo,$horas_extras_domingo,
	                          $horas_extras_dobles,$horas_extras_triples,
	                          $mte_causas,$motivo_causa,$observaciones); 
    }
    $this->template['table'] .= $this->table->generate();
    $attr_button = array('class' => '', 'id' => 'btn_guardar', 'name' => 'btn_guardar');
    $this->template['table'] .= form_submit($attr_button, 'Guardar');
    $this->_run('prenomina');  
  }

  public function insertPrenominaEmpleado(){
    for ($i=2; $i < 5; $i++) { 
      $data_prenomina_empleado = array(
        'pre_semana_ano'             => date('Y').'|'.$this->input->post('pre_semana_ano'),
        'pre_emp_id'                 => $this->input->post('pre_emp_id'.$i),
        'pre_tur_lunes'              => $this->input->post('pre_tur_lunes'.$i),
        'pre_tur_martes'             => $this->input->post('pre_tur_martes'.$i),
        'pre_tur_miercoles'          => $this->input->post('pre_tur_miercoles'.$i),
        'pre_tur_jueves'             => $this->input->post('pre_tur_jueves'.$i),
        'pre_tur_viernes'            => $this->input->post('pre_tur_viernes'.$i),
        'pre_tur_sabado'             => $this->input->post('pre_tur_sabado'.$i),
        'pre_tur_domingo'            => $this->input->post('pre_tur_domingo'.$i),
        'pre_horas_extras_lunes'     => $this->input->post('pre_horas_extras_lunes'.$i),
        'pre_horas_extras_martes'    => $this->input->post('pre_horas_extras_martes'.$i),
        'pre_horas_extras_miercoles' => $this->input->post('pre_horas_extras_miercoles'.$i),
        'pre_horas_extras_jueves'    => $this->input->post('pre_horas_extras_jueves'.$i),
        'pre_horas_extras_viernes'   => $this->input->post('pre_horas_extras_viernes'.$i),
        'pre_horas_extras_sabado'    => $this->input->post('pre_horas_extras_sabado'.$i),
        'pre_horas_extras_domingo'   => $this->input->post('pre_horas_extras_domingo'.$i),
        'pre_tip_lunes'              => $this->input->post('pre_tip_lunes'.$i),
        'pre_tip_martes'             => $this->input->post('pre_tip_martes'.$i),
        'pre_tip_miercoles'          => $this->input->post('pre_tip_miercoles'.$i),
        'pre_tip_jueves'             => $this->input->post('pre_tip_jueves'.$i),
        'pre_tip_viernes'            => $this->input->post('pre_tip_viernes'.$i),
        'pre_tip_sabado'             => $this->input->post('pre_tip_sabado'.$i),
        'pre_tip_domingo'            => $this->input->post('pre_tip_domingo'.$i),
        'pre_horas_extras_dobles'    => $this->input->post('pre_horas_extras_dobles'.$i),
        'pre_horas_extras_triples'   => $this->input->post('pre_horas_extras_triples'.$i),
        'pre_mte_causas'             => $this->input->post('pre_mte_causas'.$i),
        'pre_motivo_causa'           => $this->input->post('pre_motivo_causa'.$i),
        'pre_observaciones'          => $this->input->post('pre_observaciones'.$i)
      );
      $this->oPrenomina->insert_datos_empleado($data_prenomina_empleado);
    }
    $this->_run('tabla_ver');
  }
  /**
   * Elimina las semanas registradas
   * @return Nada, te manda a la vista de inicio
   */
  function delete() {
    $id = $this->uri->segment(3);
    $this->oPrenomina->delete_t($id);
    $this->index();
  }
}// END class Prenomina_pre_nomina