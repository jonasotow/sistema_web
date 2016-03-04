<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Usuarios_aplicaciones_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Alfredo Garcia
 * @link http://localhost/sistema_web/usuarios.php/
 */
class Usuarios_aplicaciones_model extends My_Model {
    public $table_name;
    public $schema;
    public $schema_add;
    public $schema_up;

    /**
     * Carga todo las funciones que tiene disponile CI_Model propia de codeigniter
     */
    function __construct($db = null) {
      // llamma el Modelo constructor
      parent::__construct($db);
        $this->load->model('usuarios/aplicaciones_model','oApplicationUser',FALSE,'usuarios');
    }

    public function show_applications_user() {
      return $this->oApplicationUser->find('first',array(
        'field' => array('apl_nombre,apl_id'),
        'conditions' => array('apl_estatus' => 1)
      )); 
/*
    public function show_applications_user($user_id) {
      return $this->oApplicationUser->find('first',array(
        'field' => array('usu_usuario,usu_id,apl_nombre,apl_id'),
        'join' => array(
            'clause' => array('usu_usuarios_mstr' => 'usu_id = usutip_id_asignado'),
           'type' => 'INNER'
          ),
        'conditions' => array('usu_id' => $user_id, 'usu_estatus' => 1, 'usutip_id_tipo' => 3)
      )); 
*/
}

/* End of file plantas_model.php */
/* Location: ./application/models/usuarios/plantas_model.php */