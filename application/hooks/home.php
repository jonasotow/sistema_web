<?php

if (!defined( 'BASEPATH')) exit('No direct script access allowed'); 
class Home
{
    private $ci;
    public function __construct()
    {
        $this->ci =& get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
        !$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
    }    
 
    public function check_login(){
	    if($this->ci->uri->segment(2) == 'login' && $this->ci->session->userdata('logged_user') == true)
            redirect(site_url('aplicaciones/home'));
        else if($this->ci->session->userdata('logged_user') == false && $this->ci->uri->segment(2) != 'login')
        	redirect(base_url('inicio_class/login'));
    }
    
    public function validar(){
	   	if($this->ci->uri->segment(2) !== 'aplicaciones' && $this->ci->session->userdata('logged_user') == true){
		 	//validamos que el usuario tenga permiso sino redireccionamos a home
		 	if($this->ci->uri->segment(1) == 'censos'){
			 	redirect(site_url('aplicaciones/home'));
		 	}
	    }
    }
}
/*
/end hooks/home.php
*/