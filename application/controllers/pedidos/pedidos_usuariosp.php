<?php if ( ! defined('BASEPATH')) die('No direct script access allowed');

class Pedidos_usuariosp extends MY_Controller {

    var $param;

    /**
     * [__construct description]
     */
    function __construct() {
        parent::__construct();

        $dbBase = $this->load->database('usuarios', TRUE);
        $this->load->model('pedidos/usuarios_model','opUsuario');
        $this->load->model('pedidos/modelo_generico_model');
        $this->template['module'] = 'pedidos';
        $this->template['titulo'] = 'usuarios';
        $this->param = array(
            'cabecera' => array("Id", "Nombre", "Apellido paterno", "Apelido materno", "Email", "Usuario"),
            'open' => '<table class="table table-striped table-hover table-condensed">',
            'edit' => 'fa fa-pencil-square-o',
            'delete' => 'fa fa-trash-o',
            'url_campo' => 'usu_id'
        );
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $usuario_id = $this->session->userdata('logged_user')->usu_id;
        $campos = $this->opUsuario->find('result', array(
            'fields' => array('usu_id','usu_nombre','usu_apellido_paterno','usu_apellido_materno','usu_email', 'usu_usuario'),
            'join' => array(
                        'clause' => array('usuasi_usuarios_asignados_det' => 'usu_id = usuasi_id_usuario'),
                        'type' => 'INNER'
                    ),
            'conditions' => array('usuasi_id_asignado' => $usuario_id , 'usu_id_tipo' => 3, 'usu_estatus' => 1)
        ));
        $this->param = array_merge($this->param, array('datos' => $campos));
        $this->template['table'] = $this->generate_table('usuariosp/crear', $this->param, 'usuariosp/delete');
        $this->template['action'] = site_url('usuariosp/crear');
        $this->template['control'] = 'usuariosp';
        $this->_run('tabla_ver');
    }
    
    public function crear() {
        try{
        //    $this->opUsuario->prepararForm();
            $id = $this->uri->segment(3);
            $this->template['new'] = !is_numeric($id) ? "Nueva" : "Modificar";
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
            if(!is_numeric($id)){
	            $this->form_validation->set_rules('usu_password', 'Password', 'trim|required|matches[usu_password_conf]');
            	$this->form_validation->set_rules('usu_password_conf', 'Password Confirmation', 'trim|required');
            	$this->form_validation->set_rules('usu_usuario', 'Usuario Nombre', 'trim|required|min_length[5]|max_length[12]|xss_clean|is_unique[usu_usuarios_mstr.usu_usuario]');
            }else{
	            $this->form_validation->set_rules('usu_password', 'Password', 'trim|matches[usu_password_conf]');
            	$this->form_validation->set_rules('usu_password_conf', 'Password Confirmation', 'trim');
            }
           	$this->form_validation->set_rules('usu_email', 'Email', 'trim|required|valid_email');            
            $datos = '';
            if(is_numeric($id))
                $this->template['action'] = site_url('usuariosp/crear');
            $datos = $this->opUsuario->find('list',array('conditions' => array( 'usu_id' => $id )));
            if(!empty($datos)){
            	$datos['usu_password'] = '';
	            $this->template['formulario'] = $this->_getForm(
	                                'usuariosp/crear'.'/'.$id,
	                                $this->opUsuario->schema,
	                                $datos,
	                                "Usuario",
	                                '',
	                                '',
	                                FALSE,
	                                $this->opUsuario->schema_add);
            }
            else
            	$this->template['formulario'] = $this->_getForm(
	                                'usuariosp/crear'.'/'.$id,
	                                $this->opUsuario->schema,
	                                NULL,
	                                "Usuario",
	                                '',
	                                '',
	                                FALSE,
	                                $this->opUsuario->schema_add);

            if($this->form_validation->run()){
	            
	            $datos = elements($this->opUsuario->schema(),$this->input->post(NULL, TRUE));
                if($this->input->post('eliminar',TRUE) != NULL)
                    $datos['usu_estatus'] = 0;
                else
                    $datos['usu_estatus'] = 1;
                $usu_id_relacion = $this->session->userdata('logged_user')->usu_id;
                $datos['usu_id_tipo'] = 3;
                $id = $this->opUsuario->find("first",array('fields' => 'usu_id,usu_password', 'conditions' => array('usu_usuario' => $datos['usu_usuario'], 'usu_estatus' => 1)));
                if(isset($id->usu_id) && !($this->input->post('usu_id',TRUE) != '' || $this->input->post('usu_id',TRUE) != null)){
                    $this->template['mensajes'] = '<div class="alert alert-danger" role="alert">El usuario '.$datos['usu_usuario'].' ya existe</div>';
                }
                else{
	                if(!empty($id) && $id->usu_password != ''){
		                if( ! ($this->input->post('usu_password',TRUE) != '' && ($this->input->post('usu_password',TRUE) == $this->input->post('usu_password_conf',TRUE))))
		                	$datos['usu_password'] = $id->usu_password;
		                else {
			                $datos['usu_password'] = md5($datos['usu_password']);
		                	$this->_enviar_correo($datos['usu_email'],$datos['usu_usuario'],$this->input->post('usu_password_conf',TRUE));
	                	}
	                }else{
		                $datos['usu_password'] = md5($datos['usu_password']);
	                	$this->_enviar_correo($datos['usu_email'],$datos['usu_usuario'],$this->input->post('usu_password_conf',TRUE));
	                }
                    $id_registro = $this->opUsuario->save($datos); 
                  
                    if($this->input->post('usu_id',TRUE) == '' || $this->input->post('usu_id',TRUE) == null){
                    	$this->opUsuario->insert_usu_apl($id_registro);
                    	$this->opUsuario->insert_usu_tip($id_registro, $usu_id_relacion);
                	}
                    if($this->input->post('usu_id',TRUE) == '' || $this->input->post('usu_id',TRUE) == null)
                    	$this->template['mensajes'] = '<div class="alert alert-info" role="alert">Usuario agregado correctamente</div>';
                    else
                    	$this->template['mensajes'] = '<div class="alert alert-info" role="alert">Usuario actualizado correctamente</div>';
                    $usuario_id = $this->session->userdata('logged_user')->usu_id;
                    $campos = $this->opUsuario->find('result', array(
                                'fields' => array('usu_id','usu_nombre','usu_apellido_paterno','usu_apellido_materno','usu_email', 'usu_usuario'),
                                'join' => array(
                                            'clause' => array('usuasi_usuarios_asignados_det' => 'usu_id = usuasi_id_usuario'),
                                            'type' => 'INNER'
                                        ),
                                'conditions' => array('usuasi_id_asignado' => $usuario_id , 'usu_id_tipo' => 3, 'usu_estatus' => 1)
                            ));
                    $this->param = array_merge($this->param, array('datos' => $campos));
                    $this->template['table'] = $this->generate_table('usuariosp/crear', $this->param, 'usuariosp/delete');
                    $this->template['action'] = site_url('usuariosp/crear');
                    $this->_run('tabla_ver');
                    return;
                }
            }
        } catch(Excepcion $e){
            
        }  
        if($this->input->post('eliminar',TRUE) != NULL)
            $this->index();
        else
            $this->_run('crud');
    }

    public function delete() {
        $id = $this->uri->segment(3);
        $this->opUsuario->delete_t($id);
        $this->index();
    }

    private function _enviar_correo($correo,$usuario,$password){
        $this->email->from('web@vimifos.com','Vimifos');
        $list_correos = array('agmarron@vimifos.com',$correo);
        $this->email->to($list_correos);
        
        $this->email->subject('::VIMIFOS::Orden de compra -> usuario');
        $message = "<fieldset>
                        <p> 
                            ''Estimado Cliente a sido registrado , '' 
                        </p> 
                        <p>Usuario : {$usuario}</p> 
                        <p>Contrase&ntilde;a : {$password}</p> 
                        <img src='http://test.vimifos.com:9999/assets/img/pedidos_firma.jpg'>
                    </fieldset> ";
        $this->email->message($message);

        $this->email->send();
    }
}

/* End of file usuarios_usuarios.php */
/* Location: ./application/controllers/usuarios/usuarios_usuarios.php */