<?php if (!defined('BASEPATH')) {die('No direct script access allowed');
}

/**
 * Inicio_class
 *
 * @package None
 * @subpackage None
 * @category Controlador
 * @author Alfredo Garcia
 * @link http://localhost/sistema_web/censos.php/
 */
class Aplicaciones_aplicaciones extends MY_Controller {

	/**
	 * [__construct description]
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('aplicaciones/aplicaciones_model');
		$this->template['module'] = 'aplicaciones';
	}

	/**
	 * index
	 * @return [type] [description]
	 */
	public function index() {
		$dbLogin = $this->load->database('login', TRUE);
		$this->session->set_userdata('app', "aplicaciones/");
		$this->template['application'] = $this->aplicaciones_model->applications();
		redirect(base_url('tesoreria/home'));

	}
}
/* End of file inicio_class.php */
/* Location: ./application/censos/controllers/inicio_class.php */