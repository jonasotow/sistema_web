
<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Videos extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $this->template['module'] = 'videos';
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $this->_run('videos');
    }

}
/* End of file usuarios_usuarios.php */
/* Location: ./application/controllers/usuarios/usuarios_usuarios.php */