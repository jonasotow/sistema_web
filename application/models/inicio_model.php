<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Super Class
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Author Alfredo Garcia
 * @link http://localhost/sistema_web/censos.php/
 */
class Inicio_model extends CI_Model {

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct() {
        // llamma el Modelo constructor
        parent::__construct();
    }

    /**
     * Muestra la consulta de cuantas granjas existene en la tabla gran_granjas_mstr 
     * @return [type] [description]
     */
    function menu(){
	    if(method_exists($this,'_menu' . ucfirst($this->session->userdata('app'))))
	    	return $this->{'_menu' . ucfirst($this->session->userdata('app'))}();
    }


    function displaytipo(){
        $dbBase = $this->load->database('tesoreria',TRUE);        
        $this->db->select('*');
        $this->db->from('tc_tcambio_det');
        $this->db->join('tc_tcambio_mstr', 'tc_tcambio_det.tcd_insti_id = tc_tcambio_mstr.tc_insti_id');
        $this->db->where('tcd_fecha = CURDATE()');
        $consulta = $this->db->get();
        if($consulta->num_rows() > 0) return $consulta->result();
        else return false;
    }

    // Contador de datos en el flujo

    function contadorflujo(){
        $dbBase = $this->load->database('tesoreria',TRUE);        
      //  $consulta = $this->db->count_all('cued_cuentas_det');
      //  return $consulta;
        $this->db->select( 'COUNT(*) AS `contador`' );
        $this->db->where('cued_fecha = CURDATE();');
        $query = $this->db->get ('cued_cuentas_det' );
        return $query->row ()->contador;
    }
// Ceros *****
    function cuentasflujo(){
        $dbBase = $this->load->database('tesoreria',TRUE);        
        $this->db->select('cue_id');
        $this->db->where('cue_es_inversion', '0');
        $dat = $this->db->get('cue_cuentas_mstr');
        return $dat->result();
    } 
    function agregarsaldoencero($fecha,$data){
        $dbBase = $this->load->database('tesoreria',TRUE);        
        $this->db->insert('cued_cuentas_det',
             array(
                'cued_id' => $data['cued_id'],
                'cued_fecha' => $fecha,
                'cued_sald_ini' => 0,
                'cued_cheq_circ' => 0,
                'cued_cheques' => 0,
                'cued_pagos_lin' => 0,
                'cued_depos_fir' => 0,
                'cued_depos_24h' => 0,
                'cued_sald_fin' => 0                
                 ));
    }
    function agregarsaldoenceroinv($fecha,$datos){
        $dbBase = $this->load->database('tesoreria',TRUE);        
        $this->db->insert('cueinv_inversiones_det',
             array(
                'cueinv_id' => $datos['cued_id'],
                'cueinv_fecha' => $fecha,
                'cueinv_sald_ini' => $datos['cued_sald_fin'],
                'cueinv_sald_fin' => 0,
                'cueinv_tasa_bruta' => 0,
                'cueinv_tasa_neta' => 0,
                'cueinv_int_gene' => 0,
                'cueinv_dias' => 0,
                'cueinv_ocargos' => 0,
                'cueinv_ocargos' => 0,
                'cueinv_oabonos' => 0,
                'cueinv_descripcion' => 0,        
                 ));
    }

// Saldo anterior *****
    function flujoinvfecha(){
        $dbBase = $this->load->database('tesoreria',TRUE);        
        $this->db->select('*');
        $this->db->join('cued_cuentas_det', 'cued_id = cue_id');
        $this->db->where('cue_es_inversion', '1');
        $this->db->order_by('cued_fecha', 'desc');
        $this->db->limit(1);
        $dat = $this->db->get('cue_cuentas_mstr');
        return $dat->result();
    }
    function cuentasflujoinv($fech){
        $dbBase = $this->load->database('tesoreria',TRUE);        
        $this->db->select('*');
        $this->db->join('cued_cuentas_det', 'cued_id = cue_id');
        $this->db->where('cue_es_inversion', '1');
        $this->db->where('cued_fecha', $fech);
        $dat = $this->db->get('cue_cuentas_mstr');
        return $dat->result();
    }
    function agregarsaldoant($fecha,$datos){
        $dbBase = $this->load->database('tesoreria',TRUE);        
        $this->db->insert('cued_cuentas_det',
             array(
                'cued_id' => $datos['cued_id'],
                'cued_fecha' => $fecha,
                'cued_sald_ini' => $datos['cued_sald_fin'],
                'cued_cheq_circ' => 0,
                'cued_cheques' => 0,
                'cued_pagos_lin' => 0,
                'cued_depos_fir' => 0,
                'cued_depos_24h' => 0,
                'cued_sald_fin' => $datos['cued_sald_fin']               
                 ));
    }

    function submenu(){
        /*if(method_exists($this,'_menuSub' . ucfirst($this->session->userdata('app'))))
            return $this->{'_menuSub ' . ucfirst($this->session->userdata('app'))}();*/
            return $this->_menuSubFormulacion();
    }
    
    function _menuCensos(){
	    $dbCensos = $this->load->database('censos', TRUE);
	    $query = $this->db->get('form_formularios_mstr');  
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function _menuAplicaciones(){
        $dbCensos = $this->load->database('usuarios', TRUE);
        $this->db->select('*');
        $this->db->from('apl_aplicaciones_mstr as apl');
        $this->db->join('usuapl_usuarios_aplicaciones_det as usuapl','apl.apl_id = usuapl.usuapl_aplicacion_id','INNER');
        $this->db->join('usu_usuarios_mstr as usu','usuapl.usuapl_usuario_id = usu.usu_id','INNER');
        $this->db->where('usu.usu_id', $this->session->userdata('logged_user')->usu_id);
        $this->db->where('apl.apl_estatus', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) 
            return $query->result();
        else 
            return false;
    }

    function _menuPedidos(){
        return $this->_permisosMenu();
    }

    function _menuUsuarios(){
        return $this->_permisosMenu();
    }

    function _menuFletes(){
        return $this->_permisosMenu();
    }

    function _menuFormulacion(){
        return $this->_permisosMenu();
    }

    function _menuSubFormulacion(){
        return $this->_permisosSubMenu();
    }

    function _menuEstadoscta(){
        return $this->_permisosMenu();
    }

    function _menuHojastecnicas(){
        return $this->_permisosMenu();
    }
/*
    function _menuBioeconomico(){
        return $this->_permisosMenu();
    }
*/
/*    
    function _menuVideos(){
        return $this->_permisosMenu();
    }
*/
    function _menuPrenomina(){
        return $this->_permisosMenu();
    }

     function _menuTesoreria(){
        return $this->_permisosMenu();
    }

    function _permisosMenu() {
        $dbCensos = $this->load->database('usuarios', TRUE);
        $this->db->select('usu_usuario,apl_nombre,rol_nombre,rec_controlador,rec_accion,rec_posicion,rec_etiqueta,rec_img');
        $this->db->from('usu_usuarios_mstr');
        $this->db->join('usuapl_usuarios_aplicaciones_det', 'usu_id = usuapl_usuario_id', 'INNER');
        $this->db->join('apl_aplicaciones_mstr', 'apl_id = usuapl_aplicacion_id', 'INNER');
        $this->db->join('rol_roles_mstr', 'rol_id = usuapl_rol_id', 'INNER');
        $this->db->join('rolrec_roles_recursos_det', 'rol_id = rolrec_rol_id', 'INNER');
        $this->db->join('rec_recursos_mstr', 'rolrec_recurso_id = rec_id', 'INNER');
        $this->db->where('usu_id', $this->session->userdata('logged_user')->usu_id);
        $this->db->where('apl_inicio', $this->session->userdata('app'));
        $this->db->order_by('rec_posicion', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) 
            return $query->result();
        else 
            return false;
    }

    function _permisosSubMenu() {
        $id = $this->uri->segment(1);
        $dbCensos = $this->load->database('usuarios', TRUE);
        $this->db->select('subrec_controlador,subrec_accion,subrec_img,subrec_etiqueta');
        $this->db->from('usu_usuarios_mstr');
        $this->db->join('usuapl_usuarios_aplicaciones_det', 'usu_id = usuapl_usuario_id', 'INNER');
        $this->db->join('apl_aplicaciones_mstr', 'apl_id = usuapl_aplicacion_id', 'INNER');
        $this->db->join('rol_roles_mstr', 'rol_id = usuapl_rol_id', 'INNER');
        $this->db->join('rolrec_roles_recursos_det', 'rol_id = rolrec_rol_id', 'INNER');
        $this->db->join('rec_recursos_mstr', 'rolrec_recurso_id = rec_id', 'INNER');
        $this->db->join('subrec_subrecursos_det','subrec_recurso_id = rec_id','INNER');
        $this->db->where('usu_id', $this->session->userdata('logged_user')->usu_id);
        $this->db->where('apl_inicio', $this->session->userdata('app'));
        $this->db->where('rec_controlador', $id);
        $this->db->order_by('subrec_posicion', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) 
            return $query->result();
        else 
            return false;
    }

    public function clave_cliente($id_usuario) {
        $this->db->select('usu_usuario, usuasi_id_asignado, usu_nombre, usu_apellido_paterno, usu_apellido_materno');
        $this->db->from('usu_usuarios_mstr');
        $this->db->join('usuasi_usuarios_asignados_det','usu_id = usuasi_id_asignado','INNER');
        $this->db->where('usuasi_id_usuario', $id_usuario);
        $this->db->where('usu_estatus', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) 
            return $query->row();
        else 
            return false;
    }
}


        
/* End of file granjas_model.php */
/* Location: ./application/censos/models/granjas_model.php */