<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Bioeconomico_inicializacion extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $this->load->model('bioeconomico/bioeconomico_inicializacion_model','oBioeconomico',FALSE,'bioeconomico');
        $this->load->model('bioeconomico/insumos_model','oInsumos',FALSE,'bioeconomico');
        $this->load->model('bioeconomico/modelo_generico_model','gBioeconomico',FALSE,'bioeconomico');
        $this->template['module'] = 'bioeconomico';
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        // construye el menu
        $this->_showAside();
        //titulo
        $this->template['titulo'] = "VACA-CRÍA"; 
        // contruye el submenu
        $this->template['nav'] = anchor(site_url('inicializacion'), "<i class='fa fa-arrow-circle-left'></i><span class='nav-text'></span>", "class='navbar-brand'")
                                .anchor(site_url('inicializacion/crear'), "<i class='fa fa-plus-circle'></i><span class='nav-text'></span>", "class='navbar-brand'");
        // contruye la tabla
        $this->param = array(
            'cabecera' => array("Id", "Proyección", "# de vientres", "Peso vivo Promedio", "$ vientres", "% Destetes", "", ""),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => 'fa fa-pencil-square-o fa-lg',
            'delete' => 'fa fa-times fa-lg',
            'url_campo' => 'ini_id'
        );
        $campos = $this->oBioeconomico->find('result', array('fields' => array('ini_id','ini_nombre','ini_vie_numero_vientres','ini_vie_peso_vivo_promedio_kg','ini_vie_precio_vientre','ini_vie_porcentaje_destete'),'conditions' => array('ini_estatus' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('inicializacion/crear', $this->param, 'inicializacion/delete');
        // contruye la tabla --termina--
        $this->template['action'] = site_url('inicializacion/crear');
        //carga la vista
        $this->_run('tabla_ver');
    }

    public function crear() {
        // contruye el menu
        $this->_showAside();

        $this->template['titulo'] = "VACA-CRÍA";
        // construye el submenu
        $this->template['nav'] = anchor(site_url('inicializacion'), "<i class='fa fa-arrow-circle-left'></i><span class='nav-text'></span>", "class='navbar-brand'");
        // construye el submenu --termina--

        try{
        //    $this->oBioeconomico->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('ini_vie_numero_vientres','required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('inicializacion/crear');
            $datos = $this->oBioeconomico->find('list',array('conditions' => array( 'ini_id' => $id )));
            $this->template['formulario'] = $this->_getForm(
                                'inicializacion/crear'.'/'.$id,
                                $this->oBioeconomico->schema,
                                $datos,
                                "Inicializacion",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oBioeconomico->schema_up
                            );
            if($this->form_validation->run()){
                $datos = elements($this->oBioeconomico->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('Nuevo') != NULL)
                    $datos['ini_id'] = NULL;
                $datos['ini_usuario_id'] = 10;
                $datos['ini_estatus'] = 1;
                $this->template['formulario'] = $this->_getForm(
                                'inicializacion/crear'.'/'.$id,
                                $this->oBioeconomico->schema,
                                $datos,
                                "Inicializacion",
                                'form-inline',
                                'form-inline',
                                FALSE,
                                $this->oBioeconomico->schema_up 
                            );
                $id_inicializacion = $this->oBioeconomico->save($datos);
                $this->_insertInsumos($id_inicializacion);
                $this->_insertManoObra($id_inicializacion);
                $this->_insertDepreciacion($id_inicializacion);
                $this->template['datos_proyeccion'] = $this->oBioeconomico->getProyeccion($id_inicializacion);
                $this->_run('inicializacion_graficas');
                return TRUE;     
            }
        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }  
        $this->_run('crud');
    }

    public function findSupplies(){
        echo json_encode($this->oInsumos->findInsumos($this->input->post('ini_ins_id')));
    }

    Public function delete() {
        $id = $this->uri->segment(3);
        $this->oBioeconomico->delete_t($id);
        $this->index();
    }

    Private function _insertInsumos($id_inicializacion){
        for ($i_insumos=1; $i_insumos < 3; $i_insumos++) {
            $datos_insumos = array(
                'ins_ini_id'          => $id_inicializacion,
                'ins_nombre'          => $this->input->post('ins_nombre'.$i_insumos),
                'ins_precio_tonelada' => $this->input->post('ins_precio_tonelada'.$i_insumos),
                'ins_numero_dias'     => $this->input->post('ins_numero_dias'.$i_insumos),
                'ins_kg_vientre_dia'  => $this->input->post('ins_kg_vientre_dia'.$i_insumos), 
                'ins_calculo'   => $this->input->post('ins_calculo'.$i_insumos)
            );
            $this->oBioeconomico->saveInsumos($datos_insumos);
        }    
    }

    Private function _insertManoObra($id_inicializacion){
        for ($i_mano_obra=1; $i_mano_obra < 3; $i_mano_obra++) {
            $datos_mano_obra = array(
                'man_ini_id'             => $id_inicializacion,
                'man_nombre'             => $this->input->post('man_nombre'.$i_mano_obra),
                'man_precio_semana'      => $this->input->post('man_precio_semana'.$i_mano_obra),
                'man_numero'             => $this->input->post('man_numero'.$i_mano_obra),
                'man_numero_semanas_ano' => $this->input->post('man_numero_semanas_ano'.$i_mano_obra), 
                'man_total_hato'         => $this->input->post('man_total_hato'.$i_mano_obra),
                'man_total_vientre'      => $this->input->post('man_total_vientre'.$i_mano_obra)
            );
            $this->oBioeconomico->saveManoObra($datos_mano_obra);
        }
    }

    Private function _insertDepreciacion($id_inicializacion){
        for ($i_depreciacion=1; $i_depreciacion < 3; $i_depreciacion++) {
            $datos_depreciacion = array(
                'dep_ini_id'          => $id_inicializacion,
                'dep_nombre'          => $this->input->post('dep_nombre'.$i_depreciacion),
                'dep_precio_unitario' => $this->input->post('dep_precio_unitario'.$i_depreciacion),
                'dep_anos'            => $this->input->post('dep_anos'.$i_depreciacion),
                'dep_total_hato'      => $this->input->post('dep_total_hato'.$i_depreciacion), 
                'dep_total_vinentre'  => $this->input->post('dep_total_vinentre'.$i_depreciacion)
            );
            $this->oBioeconomico->saveDepreciacion($datos_depreciacion);
        }    
    }

    Private function _showAside(){
        /*
        <!--
            <aside class="list-group">
              <?php
                 if (is_array($sub_menu)) {
                  foreach ($sub_menu as $key => $value) {
                  ?>
                    <a class="list-group-item" href="<?=site_url($value->rec_controlador.'/'.$value->rec_accion);?>"><i class="fa <?=$value->rec_img?> fa-fw fa-lg"></i><span class="aside-text"><?=$value->rec_etiqueta?></span></a>
                  <?php 
                  }
                 }else{
                      echo "Solicitar permisos para utilizar el menu";
                 }
              ?>
            </aside>
            -->
         */
        // contruye el menu
        $this->template['aside'] = anchor(site_url('inicializacion'),"<img src='".base_url()."assets/img/bioeconomico/inicializacion_menu.png' alt='logo menu'><span class='aside-text'>VACA-CRÍA</span>","class='list-group-item active'")
                                    .anchor(site_url('desarrollo'),"<img src='".base_url()."assets/img/bioeconomico/desarrollo_menu.png' alt='logo menu'><span class='aside-text'>DESARROLLO</span>","class='list-group-item'")
                                    .anchor(site_url('inicializacion'),"<img src='".base_url()."assets/img/bioeconomico/finalizacion_menu.png' alt='logo menu'><span class='aside-text'>FINALIZACIÓN</span>","class='list-group-item'");

    }
}