<?php

if (!defined('BASEPATH')) {
    die('No direct script access allowed');
}

class Valores_model extends My_Model {
        public $table_name;
        public $schema;
        
    function __construct() {
        parent::__construct();
        $this->table_name = 'val_valores_det';
        $this->schema = '';
    }
}

/* End of file periodos_model.php */
/* Location: ./application/censos/models/periodos_model.php */