<?php if (!defined('BASEPATH')) die('No direct script access allowed');

/**
 *  MY_controller Class
 *
 *  @category:  Controlador
 *  @author:    José Manzo, Miguel Pineda
 */
class MY_Controller extends CI_Controller {

	public $user;

    function __construct() {
        parent::__construct();
        $this->load->model('inicio_model');
        $this->load->model('tesoreria/tipocambio_model');

        // Se carga el modelo de usuarios.
		$this->load->model('users');

		// Se le asigna a la informacion a la variable $user.
		$this->user = @$this->session->userdata('logged_user');
        
        //$this->output->enable_profiler(TRUE);
        if(method_exists($this,'cargar_' . $this->session->userdata('app')))
        	$this->{'cargar_' . $this->session->userdata('app')}();
        
    }

    /**
     * Genera tablas de acuardo a los datos
     * @param string $controlador
     * @param array $params
     * @return string
     */
    public function generate_table($controller_edit = NULL, $params = array(), $controller_delete = NULL) {
	    if (isset($params['leyenda'])) {
		    $this->table->set_caption($params['leyenda']);
	    }
        if (isset($params['cabecera'])) {
            $this->table->set_heading($params['cabecera']);
        }
        if (isset($params['open'])) {
            $this->table->set_template(array('table_open' => $params['open']));
        }
        if (isset($params['datos'])) {
            $i = count($params['cabecera']);
            $j = 0;
            foreach ($params['datos']->result_array() as $dato) {
                $dato = str_replace(",", "", $dato);
                if ($j <= $i) {
              
                	////
                	if (isset($params['url_campo']) AND isset($params['edit']) AND isset($params['delete'])) {
                		$a_edit = anchor(site_url($controller_edit . "/" . $dato[$params['url_campo']]), " " , 'class="'.$params['edit'].'"');
                		$a_delete = anchor(site_url($controller_delete. "/" . $dato[$params['url_campo']]), " " , "class='".$params['delete']."' data-id='".$params['url_campo']."'");
                		$this->table->add_row(explode(",", implode(",", $dato) . ',' . $a_edit. ',' . $a_delete));
                	}
                	elseif (isset($params['url_campo']) AND isset($params['edit']) AND !isset($params['delete'])) {
                		$a_edit = anchor(site_url($controller_edit . "/" . $dato[$params['url_campo']]), " " , 'class="'.$params['edit'].'"');
                		$this->table->add_row(explode(",", implode(",", $dato) . ',' . $a_edit));	
                	}
                	elseif (isset($params['url_campo']) AND isset($params['delete']) AND !isset($params['edit'])) {
                		$a_delete = anchor(site_url($controller_delete. "/" . $dato[$params['url_campo']]), " " , "class='".$params['delete']."' data-id='".$params['url_campo']."'");
                		$this->table->add_row(explode(",", implode(",", $dato) . ',' . $a_delete));	
                	}
                	else{
                		$this->table->add_row(explode(",", implode(",", $dato)));
                	}

                	///
/*
                    if (isset($params['edit'])) {
                        if (isset($params['url_campo'])) {
                            $a_edit = anchor(site_url($controller_edit . "/" . $dato[$params['url_campo']]), " " , "class='".$dato[$params['edit']]."'");
                            // cambios para poder borrar
		                	if (isset($params['delete'])) {
		                    	$a_delete = anchor(site_url($controller_delete. "/" . $dato[$params['url_campo']]), " " , "class='".$dato[$params['delete']]."' id='".$dato[$params['url_campo']]."'");
		                    	$this->table->add_row(explode(",", implode(",", $dato) . ',' . $a_edit. ',' . $a_delete));
		                    } else {
		                    	$this->table->add_row(explode(",", implode(",", $dato) . ',' . $a_edit));	
		                    }
		                	// fin de los cabios 
                        } else {
                            $this->table->add_row(explode(",", implode(",", $dato)));
                        }
                    } else {
                        $this->table->add_row(explode(",", implode(",", $dato)));
                    }
*/
                    //$this->table->add_row(explode(",", implode(",", $dato)));
                }
            }
        }
        return $this->table->generate();
    }

    /**
     * Paginacion para las tablas   
     * @param string $url
     * @param int $count
     * @return string
     */
    public function pagination($url, $count) {
        $config = array(
            'base_url' => site_url($url),
            'total_rows' => $count,
            'per_page' => '10',
            'uri_segment' => 3,
            'num_links' => 5,
            'use_page_numbers' => TRUE
        );
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    /**
     * Carga vistas y envia datos a ella
     * @access private
     * @param  string
     */
    public function _run($view) {
      $this->template['usuario'] = $this->session->userdata('logged_user')->usu_nombre.' '
 								  .$this->session->userdata('logged_user')->usu_apellido_paterno.' '
 		                          .$this->session->userdata('logged_user')->usu_apellido_materno;
      $this->template['view_dir'] = $this->session->userdata('app');
      $this->template['view'] = $view;
      $this->load->view('loader', $this->template);
    }
    
    public function cargar_censos(){
	    $this->template['sub_menu'] = $this->inicio_model->menu();
	    $this->load->model('censos/modelo_generico_model');
    }

    public function cargar_pedidos(){
        $this->template['sub_menu'] = $this->inicio_model->menu();
        $this->load->model('pedidos/modelo_generico_model');
        $clave_cliente = $this->inicio_model->clave_cliente($this->session->userdata('logged_user')->usu_id);
        if (!empty($clave_cliente)) {
        	$this->template['clave_cliente'] = '('.$clave_cliente->usu_usuario.') '.
        								   $clave_cliente->usu_nombre.' '.
        								   $clave_cliente->usu_apellido_paterno.' '.
        								   $clave_cliente->usu_apellido_materno;
	        $this->session->set_userdata('clave_cliente', $this->template['clave_cliente']);          
        }
    }

    public function cargar_usuarios(){
        $this->template['sub_menu'] = $this->inicio_model->menu();
        $this->load->model('usuarios/modelo_generico_model');
    }

    public function cargar_fletes(){
	    $this->template['sub_menu'] = $this->inicio_model->menu();
	    $this->load->model('fletes/modelo_generico_model');
    }

     public function cargar_hojastecnicas(){
        $this->template['sub_menu'] = $this->inicio_model->menu();
        $this->load->model('hojastecnicas/modelo_generico_model');
    }

    public function cargar_aplicaciones(){
        $this->template['menu'] = $this->inicio_model->menu();
        $this->load->model('aplicaciones/aplicaciones_model');
    }

    public function cargar_formulacion(){
	    $this->template['sub_menu'] = $this->inicio_model->menu();
	    $this->template['sub_menu2'] = $this->inicio_model->submenu();	
	    $this->load->model('formulacion/modelo_generico_model');
    }

    public function cargar_estadoscta(){
    	$this->template['sub_menu'] = $this->inicio_model->menu();
	    $this->load->model('estadoscta/modelo_generico_model');
    }

    public function cargar_bioeconomico(){
    	$this->template['sub_menu'] = $this->inicio_model->menu();
	    $this->load->model('bioeconomico/modelo_generico_model');
    }

    public function cargar_video(){
    	$this->template['sub_menu'] = $this->inicio_model->menu();
	    $this->load->model('video/modelo_generico_model');
    }

    public function cargar_prenomina(){
    	$this->template['sub_menu'] = $this->inicio_model->menu();
	    $this->load->model('prenomina/modelo_generico_model');
    }
     public function cargar_tesoreria(){
    	$this->template['sub_menu'] = $this->inicio_model->menu();
     	$this->load->model('tesoreria/modelo_generico_model');
     	$this->template['displaytipo'] = $this->inicio_model->displaytipo();

// Iniciar saldo para operaciones

     	$this->template['contadorflujo'] = $this->inicio_model->contadorflujo();
        if($this->template['contadorflujo'] > 0){
            $this->template['datos'] = 'Datos';
        }
        else{
            $this->template['datos'] = 'Cero';
// Ceros *****
            $cuentasflujo = $this->inicio_model->cuentasflujo();
                foreach ($cuentasflujo as $cuentas) {
                $data =  array(
                    'cued_id' => $cuentas->cue_id,
                    );
                $fecha = date('Y-m-d');    
            $this->template['agregarsaldoencero'] = $this->inicio_model->agregarsaldoencero($fecha,$data);
            }
// Saldo anterior *****  
            $flujoinvfecha = $this->inicio_model->flujoinvfecha();
                foreach ($flujoinvfecha as $flujoinvfecha) {
            $this->template['fs'] = $flujoinvfecha->cued_fecha;

            }
            $fech = $this->template['fs'];
            $cuentasflujoinv = $this->inicio_model->cuentasflujoinv($fech);
                foreach ($cuentasflujoinv as $cuentass) {
                    $datos = array(
                        'cued_id' => $cuentass->cue_id,
                        'cued_sald_fin' => $cuentass->cued_sald_fin,
                    );
            $fecha = date('Y-m-d');    
            $this->template['agregarsaldoant'] = $this->inicio_model->agregarsaldoant($fecha,$datos);
            $this->template['agregarsaldoenceroinv'] = $this->inicio_model->agregarsaldoenceroinv($fecha,$datos);
          
            }
        }
    }
    
    /*
    	<form action="<?=site_url('formularios/nuevo'); ?>" method="post" >
	   		<input name="form_nombre" type="text" value="<?=set_value('form_nombre');?>" class="form-control" placeholder="Nombre del formulario" required />
	   		<input name="form_descripcion" type="text" value="<?=set_value('form_descripcion');?>" class="form-control" placeholder="Descripcion del formulario" />
	   		<input name="form_estatus" type="text" value="<?=set_value('form_estatus');?>" class="form-control" placeholder="Status del formulario" />		
			<button type="submit" class="btn btn-primary" >Guardar</button>
			<!-- No usar reset si va a se regresar, tiene que ser una url -->
			<button type="reset" class="btn btn-danger regresar" >Regresar</button>
			<button name="Borrar" id="Borrar" type="reset" value="Reset" class="btn btn-danger">Borrar</button>
		</form>
		
		botones = array(
			'Borrar' => array(
				'tipo' = 'reset',
				'label' = 'label',
				'class' = '',
				'id' = 'borrar',
				'js' = ''
			)
		)
    */
   	public function _getForm($action,$schema,$datos = NULL,$nombre = NULL,$class = NULL, $id = NULL, $read = FALSE, $botones = NULL, $upload = NULL){
   		$update = is_array($datos) == TRUE ? TRUE : FALSE;
	   	if(isset($upload))
	   		$formulario = form_open_multipart($action,array('class' => $class == NULL ? 'form-inline' : $class, 'id' => $id == NULL ? 'id' : $id, 'name' => $nombre == NULL ? 'name' : $nombre))."\n";
	   	else
	   		$formulario = form_open($action,array('class' => $class == NULL ? 'form-inline' : $class, 'id' => $id == NULL ? 'id' : $id, 'name' => $nombre == NULL ? 'name' : $nombre))."\n";
	   	foreach($schema as $fieldset => $fields){
		   	$formulario .= form_fieldset($fieldset,array('class' => $fields['class'], 'id' => $fields['id']));
		   	foreach($fields as $field => $data){
			   	if(is_array($data)){
				   	$required = "";
			   	   	if($update){
					   	if(!$data['update'] OR $read)
							$required = $data['type'] != 'dropdown' ? 'readonly' : 'disabled';
					}
				   	else
				   		$required = $data['null'] == FALSE ? 'required' : '';
				   	$required .= empty($data['data-campo']) == FALSE ? ' data-campo='.$data['data-campo'] : '';
				   	$required .= empty($data['data-id']) == FALSE ? ' data-id='.$data['data-id'] : '';
				   	$required .= empty($data['js']) == FALSE ? ' '.$data['js'] : '';
				   	$required .= empty($data['step']) == FALSE ? ' '.$data['step'] : '';
				   	$input = array(
				   		'type'		=> $data['type'],
				   		'name'		=> $field,
				   		'id'		=> $field,
				   		'value'		=> $datos !== NULL ? element($field,$datos,NULL) : set_value($field),
				   		'maxlength'	=> $data['lenght'],
				   		'size'		=> $data['lenght'],
				   		'class'		=> 'form-control'
		            );
		            $formulario .= "<div class='form-group'>";
		            //$estilo = empty($data['visible']) == FALSE && $data['visible'] != null && $data['type'] != 'checkbox' ? array('style' => 'display: none','class' => 'estilo_pedidos') : array('class' => 'estilo_pedidos');
		            $estilo = '';
				   	$formulario .= $data['type'] != 'hidden' ? form_label($data['name'].":",$field,$estilo)."\n" : '';
				   	switch($data['type']){
					   	case 'dropdown':
							$formulario .= form_dropdown($field,$data['data'],$datos !== NULL ? element($field,$datos,'') : '', 'class="form-control" '.$required)."\n";
							break;
						case 'checkbox':
							if (empty($data['data'])){
								$formulario .= '<label>'.$field."\n";
								$formulario .= form_checkbox($field,1,FALSE,$required)."\n";
								$formulario .= '</label>'."\n";
							}
		 					else{
		 						foreach($data['data'] as $campo){
			 						$campo = trim($campo);
			 						$checked = $datos !== NULL ? in_array($campo,explode("\n",element($field,$datos,''))) !== FALSE ? TRUE : FALSE : FALSE;
			 						$formulario .= '<br /><label>'.$campo;
		 							$formulario .= form_checkbox($field,$campo,$checked,$required)."\n";
		 							$formulario .= '</label>';
		 						}
		 					}
							break;
						case 'radio':
							if (empty($data['data'])){
								$formulario .= '<label>'.$field."\n";
								$formulario .= form_radio($field,1,FALSE,$required)."\n";
								$formulario .= '</label>'."\n";
							}
		 					else{
		 						foreach($data['data'] as $campo){
			 						$checked = $datos !== NULL ? element($field,$datos,'') == $campo ? TRUE : FALSE : FALSE;
			 						$formulario .= '<br /><label>'.$campo;
		 							$formulario .= form_radio($field,$campo,$checked,$required)."\n";
		 							$formulario .= '</label>';
		 						}
		 					}
							break;
						case 'file':
							$formulario .= form_upload($input,'',$required)."\n";
							break;
						case 'password':
							$formulario .= form_password($input,'',$required)."\n";
							break;
						case 'hidden':
							$temp = $datos !== NULL ? element($field,$datos,NULL) : '';
							$temp = $temp == '' ? isset($data['value']) ? $data['value'] : '' : $temp;
							$formulario .= form_hidden($field,$temp)."\n";
							break;
						case 'textarea':
							$input = array(
							   		'type'		=> $data['type'],
							   		'name'		=> $field,
							   		'id'		=> $field,
							   		'value'		=> $datos !== NULL ? element($field,$datos,NULL) : set_value($field),
							   		'rows'		=>  4,
							   		'cols'		=> $data['lenght'],
							   		'class'		=> 'form-control'
					            );
							$formulario .= form_textarea($input,'',$required)."\n";
							break;
						default:
							$formulario .= form_input($input,'',$required)."\n";
							break;
				   	}
				   	$formulario .= "</div>\n";
			   	}
		   	}
		   	$formulario .= form_fieldset_close();
	   	}
	   	$formulario .= "\n";
	   	if(is_array($botones)){
		   	$formulario .= form_fieldset('',array('class'=> 'botones', 'id' => 'botones'));
		   	foreach($botones as $field => $data){
		   		$boton_valor = isset($data['value']) ? $data['value'] : '';
			   	$formulario .= form_button(array('id' => $data['id'],'content' => $data['label'], 'name' => $data['label'], 'class' => $data['class'], 'type' => $data['tipo'], 'value' => $boton_valor))."\n";
		   	}
			$formulario .= form_fieldset_close()."\n";
		}
	   	$formulario .= form_close()."\n";
	   	return $formulario;
   	}
}
