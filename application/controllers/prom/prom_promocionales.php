<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * prom_prom.php
 *
 * @package None
 * @subpackage None
 * @category Controller
 * @author Daniel Villa
 */


class Prom_Promocionales extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('estadoscta/estados_model','oEstados');
    }

    public function index()
	{
		$this->cliente = $this->oEstados->cliente($this->session->userdata('logged_user')->usu_id);
		$idcliente = $this->cliente->usu_usuario;
		$correo = $this->cliente->usu_email;
		header("Location: http://panel.vimifos.net/redirect_prom.php?idcliente=$idcliente&correo=$correo");
	}

}