<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro_Compras_Model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "registros_compras";
    }
}