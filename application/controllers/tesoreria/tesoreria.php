<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Tesoreria extends MY_Controller {

    function __construct() {
        parent::__construct();
        $dbBase = $this->load->database('tesoreria',TRUE);
        $this->load->model('tesoreria/tipocambio_model');
        $this->load->helper('form');
        $this->template['module'] = 'tesoreria';
    }

    public function index() {

        $this->_run('tesoreria/home');

    }

}
/* End of file Tesoreria.php */
/* Location: ./application/controllers/tesoreria/Tesoreria.php */