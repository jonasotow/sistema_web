
<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Hojastecnicas_hojas_tecnicas extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();
        $this->load->model('hojastecnicas/hojastecnicas_model','oHojasTecnicas',FALSE,'hojastecnicas');
        $this->load->model('hojastecnicas/modelo_generico_model',FALSE,'hojastecnicas');
        $this->template['module'] = 'hojastecnicas';
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $this->param = array(
            'cabecera' => array("Id", "Imagen", "Descripcion", "Subdescripcion", "Especie"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => 'fa fa-pencil-square-o fa-lg',
            'delete' => 'fa fa-times fa-lg',
            'url_campo' => 'idhoja_tecnica'
        );
        $campos = $this->oHojasTecnicas->find('result', array('fields' => array('idhoja_tecnica','Imagen','descripcion','subdescripcion','Especie'),'conditions' => array('activo' => 1)));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['titulo'] = 'Hojas tecnicas';
        $this->template['table'] = $this->generate_table('hojas_tecnicas/crear', $this->param, 'hojas_tecnicas/delete');
        $this->template['action'] = site_url('hojas_tecnicas/crear');
        $this->_run('tabla_ver');
    }

    public function especie() {
        $specie = $this->uri->segment(3);
        $this->template['titulo'] = $specie;
        $this->template['species'] = $this->oHojasTecnicas->show_species($specie);
        $this->_run('especies');
    }

     public function crear() {
        try{
        //    $this->oHojasTecnicas->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_rules('descripcion','Descripcion','required');
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('hojas_tecnicas/crear');
                $datos = $this->oHojasTecnicas->find('list',array('conditions' => array( 'idHoja_tecnica' => $id )));
                $this->template['formulario'] = $this->_getForm(
                                    'hojas_tecnicas/crear'.'/'.$id,
                                    $this->oHojasTecnicas->schema,
                                    $datos,
                                    "Hojas Tecnicas",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oHojasTecnicas->schema_add,
                                    TRUE);

            if($this->form_validation->run()){
                $datos = elements($this->oHojasTecnicas->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['activo'] = 0;
                else
                    $datos['activo'] = 1;
                    $this->template['formulario'] = $this->_getForm(
                                    'hojas_tecnicas/crear'.'/'.$id,
                                    $this->oHojasTecnicas->schema,
                                    $datos,
                                    "Hojas Tecnicas",
                                    'form-inline',
                                    'form-inline',
                                    FALSE,
                                    $this->oHojasTecnicas->schema_add,
                                    TRUE);
                    
            $target_path = "./assets/upload/hojastecnicas/img/";
            $target_path = $target_path . basename( $_FILES['imagen']['name']); 
            if(move_uploaded_file($_FILES['imagen']['tmp_name'], $target_path)) {
                $datos['imagen'] = basename( $_FILES['imagen']['name']);
                $this->template['mensaje_imagen'] = "El archivo ". basename( $_FILES['imagen']['name']). " ha sido subido";
            } else{
                 $this->template['mensaje_imagen'] = "Ha ocurrido un error, trate de nuevo!";
            }

           $this->oHojasTecnicas->save($datos);
            }
        } catch(Excepcion $e){
            $this->template['mensajes'] = $e->__toString();
        }  
        if($this->input->post('eliminar',TRUE) != NULL){
            $this->template['mensajes'] = '<div class="alert alert-danger" role="alert">La hoja tecnica de la especie '.$datos['especie'].' fue eliminada</div>';
            $this->index();
        }
        else
            $this->_run('crud');
    }

    function delete() {
        $id = $this->uri->segment(3);
        $this->oHojasTecnicas->delete_t($id);
        $this->index();
    }
}
/* End of file usuarios_usuarios.php */
/* Location: ./application/controllers/usuarios/usuarios_usuarios.php */