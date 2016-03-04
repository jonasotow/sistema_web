<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

/**
 *  contacto_model Class
 *
 *  @category:  Modelo
 *  @author:    José Manzo
 */
class Caldet_Model extends My_Model {
    public $table_name;

    function __construct($db = null) {
        parent::__construct($db);
        $this->table_name = 'cald_det';
    }
}

/* End of file campos_model.php */
/* Location: ./application/censos/models/campos_model.php */