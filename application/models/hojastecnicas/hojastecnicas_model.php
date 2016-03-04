<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

/**
 * Aplicaciones_model
 *
 * @package None
 * @subpackage None
 * @category Model
 * @author Alfredo Garcia
 * @link http://localhost/sistema_web/usuarios.php/
 */
class Hojastecnicas_model extends My_Model {
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
    //    $this->load->model('hojastecnicas/modelo_generico_model');
        $this->table_name = 'hoja_tecnica';
        $this->schema_add = array(
          'Borrar'  => array(
            'tipo'    => 'reset',
            'label'   => 'Limpiar',
            'class'   => 'btn btn-default',
            'id'      => 'limpiar'
          ),
          'Guardar' => array(
            'tipo'    => 'submit',
            'label'   => 'Guardar',
            'class'   => 'btn btn-primary',
            'id'      => 'guardar'
          )
        );
        $this->schema_up = array(
          'Borrar'   => array(
            'tipo'     => 'reset',
            'label'    => 'Borrar',
            'class'    => 'btn btn-primary',
            'id'       => 'borrar'
          ),
          'Guardar'  => array(
            'tipo'     => 'submit',
            'label'    => 'Guardar',
            'class'    => 'btn btn-primary',
            'id'       => 'guardar'
          ),
          'Eliminar' => array(
            'tipo'     => 'submit',
            'label'    => 'Eliminar',
            'class'    => 'btn btn-primary',
            'id'       => 'eliminar'
          )
        );
         $this->schema = array(
            'Hojas Tecnicas' => array(
              'class'  => 'ejemplo',
              'id'     => 'ejemplo',
              'idhoja_tecnica' => array(
                'name'    => 'Id',
                'tipo'    => 'int',
                'lenght'  => 11,
                'null'    => FALSE,
                'primary' => TRUE,
                'update'  => FALSE,
                'type'    => 'hidden',
                'class'   => 'form-control'
              ),

              'descripcion' => array(
                'name'    => 'Descripcion',
                'tipo'    => 'varchar',
                'lenght'  => 100,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),

              'subdescripcion' => array(
                'name'    => 'Subdescripcion',
                'tipo'    => 'varchar',
                'lenght'  => 100,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'text',
                'class'   => 'form-control'
              ),

              'link' => array(
                'name'    => 'Link',
                'tipo'    => 'varchar',
                'lenght'  => 100,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'url',
                'class'   => 'form-control'
              ),

              'especie' => array(
                'name'    => 'Especie',
                'tipo'    => 'varchar',
                'lenght'  => 100,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'dropdown',
                'data'    => array(
                        ''                   => 'Seleccione un Tipo',
                        'Acuicultura'        => 'Acuicultura',
                        'Comerciales'        => 'Comerciales',
                        'Equinos'            => 'Equinos',
                        'Ganaderia_lechero'  => 'Ganadería lechero',
                        'Ganado_carne'       => 'Ganado de carne',
                        'Pequenos_rumiantes' => 'Pequeños rumiantes',
                        'Porcicultura'       => 'Porcicultura',
                        'Venados'            => 'Venados'
                      ),  
                'class'   => 'form-control'
              ),
              'imagen' => array(
                'name'    => 'Imagen',
                'tipo'    => 'varchar',
                'lenght'  => 255,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'file',
                'class'   => 'form-control'
              ),
              'posicion' => array(
                'name'    => 'Posicion',
                'tipo'    => 'varchar',
                'lenght'  => 100,
                'null'    => FALSE,
                'primary' => FALSE,
                'update'  => TRUE,
                'type'    => 'number',
                'class'   => 'form-control'
              )
            )        
          );
    }
    
     public function show_species($specie) {
      $query = $this->db->get_where('hoja_tecnica', array('especie' => $specie, 'activo' => 1 ));
      return $query->result();
    }

    public function delete_t($id) {
        $this->dbUse->trans_begin();
        $this->dbUse->update('hoja_tecnica', array('activo' => 0 ), array('idHoja_tecnica' => $id));
        if ($this->dbUse->trans_status() === FALSE) {
            $this->dbUse->trans_rollback();
            return false;
        }
        $this->dbUse->trans_commit();
        return true;
    }
}

/* End of file plantas_model.php */
/* Location: ./application/models/usuarios/plantas_model.php */