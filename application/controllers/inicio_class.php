<?php if (!defined('BASEPATH')) die('No direct script access allowed');

/**
 * Inicio_class
 *
 * @package Inicio
 * @subpackage None
 * @category Controller
 * @author Alfredo Garcia
 */
class Inicio_class extends MY_Controller {
		
	/**
	 * [__construct description]
	 */
	function __construct(){
		parent::__construct();
		$this->template['module'] = '';
	}

	/**
	 * index
	 * @return [type] [description]
	 */
	public function index(){
		// Si no esta logueado lo redirigmos al formulario de login.
		if(!@$this->user) redirect ('inicio_class/login');

		$dbLogin = $this->load->database('login', TRUE);
		$this->session->set_userdata('app',substr(uri_string(),0,strrpos(uri_string(),"/")));
		if(method_exists($this,'cargar_' . $this->session->userdata('app')))
    		$this->{'cargar_' . $this->session->userdata('app')}();
		$this->_run('home');
	}

	public function login() {

  	$data = array();

  	// Añadimos las reglas necesarias.
  	$this->form_validation->set_rules('username', 'Username', 'required');
  	$this->form_validation->set_rules('password', 'Password', 'required');

  	// Generamos el mensaje de error personalizado para la accion 'required'
  	$this->form_validation->set_message('required', 'El campo %s es requerido.');

  		// Si no esta vacio $_REQUEST
  		if(!empty($_REQUEST)) {
  			// Si las reglas se entramos a la condicion.
  		//	if ($this->form_validation->run() == TRUE) {
  						
  				// Obtenemos la informacion del usuario desde el modelo users.
  				$logged_user = $this->users->get($_REQUEST['username'], $_REQUEST['password']);

  				// Si existe el usuario creamos la sesion y redirigimos al index.
  				if($logged_user) {
  					$this->session->set_userdata('logged_user', $logged_user);
  					$this->session->set_userdata('username',$this->input->post('username',TRUE));
  					$this->session->set_userdata('password',$this->input->post('password',TRUE));
         				redirect(site_url('tesoreria/home'));
  				} else {
  					// De lo contrario se activa el error_login.
  					$data['error_login'] = TRUE;
  				}
  		//	}
  		}
  	$this->load->view('login', $data);
	}

	public function logout() {
		$this->session->sess_destroy();
	  //	redirect('inicio_class/index');
		redirect('http://vimifos.com/');
	}

    public function cargar_pedidos(){
    	$this->template['sub_menu'] = $this->inicio_model->menu();
    	$this->load->model('pedidos/modelo_generico_model');
		  $clave_cliente = $this->inicio_model->clave_cliente($this->session->userdata('logged_user')->usu_id);
        if (!empty($clave_cliente)) {
        	$this->template['clave_cliente'] = '('.$clave_cliente->usu_usuario.') '.
                          								   $clave_cliente->usu_nombre.' '.
                          								   $clave_cliente->usu_apellido_paterno.' '.
                          								   $clave_cliente->usu_apellido_materno;
        }
    }
}/* End Class Inicio_class */