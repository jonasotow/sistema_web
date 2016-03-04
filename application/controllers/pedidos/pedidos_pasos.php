<?php if (!defined('BASEPATH')) die('No direct script access allowed');

class Pedidos_Pasos extends MY_Controller {

	/**
	 * carga la libreria del carrito
	 * carga la libreria del la contruccion del pdf
	 * carga la libreria del webservices
	 * carga el modelo pasos_model
	 * carga el modelo productos_detalles_model
	 * 
	 */
	function __construct() {
		parent::__construct();
		$this->load->library('cart');
		$this->load->library('html2pdf');
		$this->load->library('NuSoap_lib');
		$this->load->model('pedidos/pasos_model','oPasos',FALSE,'pedidos');
		$this->load->model('pedidos/productos_detalles_model','oProductoDetalles',FALSE,'pedidos');
		$this->template['module'] = 'pasos';
		$this->template['titulo'] = 'pasos';

		$cliente_id = $this->oPasos->asignado($this->session->userdata('logged_user')->usu_id);
		$cliente = $this->oPasos->cliente($this->session->userdata('logged_user')->usu_id);
		$this->valida_modelo = isset($cliente_id->usuasi_id_asignado) ? $cliente_id->usuasi_id_asignado : '';		
		$this->usu_cliente = isset($cliente_id->usu_usuario) ? $cliente_id->usu_usuario : $cliente->usu_usuario;
		$this->usu_id_asignado = isset($cliente_id->usuasi_id_asignado) ? $cliente_id->usuasi_id_asignado : $cliente->usu_id;
    	//carga los datos del webservices
    	$this->nusoap_client = new nusoap_client(WEBSERVICE_PEDIDOS,true);

    	$sol = $this->oPasos->insert_status($this->usu_id_asignado);
    	if (!empty($sol)) {
			foreach ($sol as $key => $value) {	
				$this->clave_empresa = substr($value->sol_empresa,0,strrpos($value->sol_empresa,'-') -1);
				$valor1 = $this->nusoap_client->call( "validarSolicitud" , array("Solicitud" => $value->sol_id_solicitud, "Cliente" => $this->clave_empresa ));
				$val = json_decode($valor1["return"]);
				if (isset($val->orden)) {
					$this->oPasos->update_solicitud(2,$value->sol_id_solicitud);
				}
				
				if (isset($val->inv_nbr)) {
					$this->oPasos->update_solicitud(3,$value->sol_id_solicitud);
				} 
			}
		}	
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index() {
		if(!empty($this->valida_modelo)){
			$this->template['nuevo'] = "<a class='navbar-brand' href='".site_url('pasos/paso2')."'><i class='fa fa-plus-square'></i><span class='section-text'></span></a>";
		}
		$sol = $this->oPasos->paso($this->usu_id_asignado, 1);
		$this->template['pedidos'] = $sol;
		$this->_run('paso');
	}
	
	public function pedidos() {
		if(!empty($this->valida_modelo)){
			$this->template['nuevo'] = "<a class='navbar-brand' href='".site_url('pasos/paso2')."'><i class='fa fa-plus-square'></i><span class='section-text'></span></a>";
		}
		$fac = $this->oPasos->paso($this->usu_id_asignado, 2);
		if (!empty($fac)) {
			foreach ($fac as $key => $value) {		
				$valor = $this->nusoap_client->call( "validarSolicitud" , array("Solicitud" => $value->sol_id_solicitud, "Cliente" => substr($value->sol_empresa,0,strrpos($value->sol_empresa,'-') -1)) );
				$val = json_decode($valor["return"]);
				$this->template['factura'][] = isset($val->orden) ? $val->orden : '';	
			}
		}		
		$this->template['pedidos'] = $fac;

		$this->_run('paso');
	}

	public function facturas() {
		if(!empty($this->valida_modelo)){
			$this->template['nuevo'] = "<a class='navbar-brand' href='".site_url('pasos/paso2')."'><i class='fa fa-plus-square'></i><span class='section-text'></span></a>";
		}
		$dbBase = $this->load->database('pedidos', TRUE);
		$fac = $this->oPasos->paso($this->usu_id_asignado,3);
		if (!empty($fac)) {
			foreach ($fac as $key => $value) {	
				$valor = $this->nusoap_client->call( "validarSolicitud" , array("Solicitud" => $value->sol_id_solicitud, "Cliente" => $this->clave_empresa) );
				$val = json_decode($valor["return"]);
				$this->template['factura'][] = isset($val->inv_nbr) ? $val->inv_nbr : '';	
			}
		}
		$this->template['pedidos'] = $fac;

		$this->_run('factura');
	}

	public function canceladas() {
		if(!empty($this->valida_modelo)){
			$this->template['nuevo'] = "<a class='navbar-brand' href='".site_url('pasos/paso2')."'><i class='fa fa-plus-square'></i><span class='section-text'></span></a>";
		}
		$fac = $this->oPasos->paso($this->usu_id_asignado, 4);
		$this->template['pedidos'] = $fac;
		$this->_run('factura');
	}

 	public function orden_detalles_pdf(){
		$id_solicitud = $this->uri->segment(3);
		$nombre_fichero = "../../../assets/upload/pedidos/pdfs/orden{$id_solicitud}_detalle.pdf";
		if(file_exists($nombre_fichero)){
			redirect(base_url()."assets/upload/pedidos/pdfs/orden{$id_solicitud}_detalle.pdf");
		}else{

			$valor = $this->nusoap_client->call( "validarSolicitud" , array("Solicitud" => $id_solicitud, "Cliente" => $this->clave_empresa) );
	 	//	$valor = $this->nusoap_client->call( "validarSolicitud" , array("Solicitud" => "453", "Cliente" => "CN01046") );
	 		$val = json_decode($valor["return"]);
	 		$solicitud = $this->oPasos->solicitud($id_solicitud);
	 	
	 		$val->solicitud = $solicitud;
			// Creacion PDF
			//Set folder to save PDF to
			$this->html2pdf->folder('./assets/upload/pedidos/pdfs/');

			//Set the filename to save/download as
	
			$this->html2pdf->filename("orden{$id_solicitud}_detalle.pdf");

			//Set the paper defaults
			$this->html2pdf->paper('A4', 'portrait');

			//Load html view
			$this->html2pdf->html($this->load->view('pedidos/pdf_detalles', $val, true));
				    
			$this->html2pdf->create('save');
			redirect(base_url().'assets/upload/pedidos/pdfs/orden'.$id_solicitud.'_detalle.pdf');
		}
	}

	public function paso1() {
		$this->template['plantas'] = $this->oPasos->paso1();
		$this->_run('paso1');
	}

	public function paso2() {
		$this->_run('paso2');
	}

	public function paso3() {
		$this->session->set_userdata('id_transporte', $this->uri->segment(3));
		$this->_run('paso3');
	}

	public function paso4() {
		$this->template['grupo_empresariales'] = $this->oPasos->grupo_empresarial($this->usu_id_asignado);
		$this->template['pedidos']    = $this->oPasos->show_formulario('1');
		$this->template['ejecutivos'] = $this->oPasos->ejecutivos($this->usu_id_asignado); 
		$this->template['ubicaciones'] = Array();
		$this->_run('paso4');
	}
	
	public function buscarUbicaciones(){
		echo json_encode($this->oPasos->ubicaciones($this->input->post('id_cliente',TRUE),$this->usu_id_asignado));
	}

	public function factura_pdf_xml() {
		$id = $this->uri->segment(3);
		ini_set("mssql.textlimit" , "2147483647");
		ini_set("mssql.textsize" , "2147483647");
		$fact = $this->oPasos->factura_pdfxml($id);	
		header("Content-type: application/pdf");
		header("Content-Disposition: attachment; filename=".$id.".pdf");
		echo $fact->pdf;
	}

	public function productos_solicitud() {
		echo json_encode($this->oPasos->detalles_solicitud($this->input->post('solicitud_id', TRUE)));
	}

	public function transportes() {
		echo json_encode($this->oPasos->paso2());
	}

	public function productos() {
		if($this->input->post('id_producto', TRUE) == null)
			echo json_encode($this->oPasos->paso3($this->input->post('especie', TRUE), $this->input->post('id_producto', TRUE)));
		else {
			$this->oProductoDetalles->show($this->input->post('id_producto', TRUE));
			echo $this->oProductoDetalles->_getFormProductos('#',$this->oProductoDetalles->schema);
		}
	}

	public function productos_detalles() {
		echo json_encode($this->oPasos->paso3($this->input->post('especie', TRUE), $this->input->post('id_producto', TRUE), $this->input->post('presentacion', TRUE)));
	}

	public function insert_carrito() {
		$temp = $this->input->post('Aditivo', TRUE);
		$valor = "";
		if(!empty($temp)){
			foreach($temp as $val){
				$valor .= $val.'|';
			}
		}
		$rowid = '';
		$qty = 0;
		foreach ($this->cart->contents() as $items){
			if($items['id'] == $this->input->post('pro_id_producto', TRUE)){
				$envasado = '';
		      	$presentacion = '';
		      	$proteina = '';
		      	$aditivo = '';
			     foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value){ 
				     $envasado =  $option_name == 'envasado' ? $option_value : $envasado;	
				     $presentacion = $option_name == 'presentacion' ? $option_value : $presentacion;
				     $proteina = $option_name == 'proteina' ? $option_value : $proteina;
				     $aditivo = $option_name == 'aditivo' ? $option_value : $aditivo;
	      		}
	      		if($envasado == $this->input->post('Envasado', TRUE) && $presentacion == $this->input->post('Presentacion', TRUE) && $proteina == $this->input->post('Proteina', TRUE) && $aditivo === $valor){
		      		$rowid = $items['rowid'];
		      		$qty = $items['qty'];
		      		break;
	      		}
			}
   		}
		if($rowid == ''){
			$data = array(
				'id'           => $this->input->post('pro_id_producto', TRUE),
				'qty'          => $this->input->post('Cantidad', TRUE),
				'price'        => 1.00,
				'name'         => $this->input->post('nombre', TRUE),
				'options'      => array('presentacion' => $this->input->post('Presentacion', TRUE),
										'clave'        => $this->input->post('clave', TRUE),
										'tipo'         => $this->input->post('tipo', TRUE),
										'proteina'     => $this->input->post('Proteina', TRUE),
										'envasado'     => $this->input->post('Envasado', TRUE),
										'aditivo'      => $valor,
										'otros'     => $this->input->post('otros', TRUE),
										)
			);
			$this->cart->insert($data);
		}
		else{
			$data = array(
				'rowid' => $rowid,
				'qty'   => $qty + $this->input->post('Cantidad', TRUE)
			);
			$this->cart->update($data);
		}
		$this->_run('paso3');
	}

	public function update_carrito() {

		$data = array(
			'rowid' => $this->uri->segment(3),
			'qty'   => 0,
		);
		$this->cart->update($data);
		redirect("pasos/paso3");
	}

	public function delete_carrito() {
		$this->cart->destroy();
		//redirect("pasos/paso3");
	}

	/**
	 * [actualizar description]
	 * @return [type] [description]
	 */
	public function paso5() {
		// aqui se guardara todo
		$persona_solicita = $this->session->userdata('logged_user')->usu_nombre." ".
							$this->session->userdata('logged_user')->usu_apellido_paterno." ".
							$this->session->userdata('logged_user')->usu_apellido_materno;
		$correo_solicitante = $this->session->userdata('logged_user')->usu_email;
		$datos_ejecutivo = $this->oPasos->ejecutivos_correo($this->input->post('ejecutivo'));

		$sol_correos 	 = $datos_ejecutivo->eje_correo.','.$correo_solicitante;
		$grupo_empresarial = $this->input->post('grupo_empresarial');
		$data_solicitud = array(
			'sol_id_cliente'                => $this->usu_id_asignado,
			'sol_empresa'   				=> $grupo_empresarial,
			'sol_id_planta'                 => 1,
			'sol_id_transporte'             => $this->session->userdata('id_transporte'),
			'sol_fecha_creacion'            => date("Y-m-d H:i:s"),	
			'sol_fecha_deseada'             => $this->input->post('fecha_deseada'),
			'sol_persona_solicita'          => $persona_solicita,
			'sol_requerimientos_especiales' => $this->input->post('requerimientos_especiales'),
			'sol_num_orden'                 => $this->input->post('num_orden'),
			'sol_ubicacion'                 => $this->input->post('ubicacion'),
			'sol_ejecutivo'                 => $this->input->post('ejecutivo'),
			'sol_correos'                   => $sol_correos,
			'sol_estatus'                   => 1,
		);
		// inserta los primeros datos de la solicitud
		$the_last_id = $this->oPasos->insert_solicitud($data_solicitud);

			//carrito

		foreach ($this->cart->contents() as $items) {

			if ($this->cart->has_options($items['rowid']) == TRUE) {
				foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value) {
					if ($option_name == 'presentacion') {
						$medida = $option_value;
					}
					elseif ($option_name == 'clave') {
						$clave = $option_value;
					}
					elseif ($option_name == 'tipo') {
						$tipo = $option_value;
					}
					elseif ($option_name == 'proteina') {
						$proteina = $option_value;
					}
					elseif ($option_name == 'envasado') {
						$envasado = $option_value;
					}
					elseif ($option_name == 'aditivo') {
						$aditivo = $option_value;
					}
					elseif ($option_name == 'otros') {
						$otros = $option_value;
					}
				}
			}

			$cantidad = $items['qty'] / $envasado;

			$data_solicitud_detalle = array(
				'soldet_id_solicitud' => $the_last_id,
				'soldet_id_producto'  => $items['id'],
				'soldet_clave'        => $clave,
				'soldet_nombre'       => $items['name'],
				'soldet_presentacion' => $medida,
				'soldet_cantidad'     => $items['qty'] / 1000,
				'soldet_sacos'        => $cantidad,
				'soldet_tipo'         => $tipo,
				'soldet_aditivos'     => $aditivo,
				'soldet_envasado'     => $envasado,
				'soldet_proteina'     => $proteina,
				'soldet_otros'        => $otros
			);

			$prod_solicitud['prod'][] = $data_solicitud_detalle;
			$this->oPasos->insert_solicitud_detalle($data_solicitud_detalle);
		}

	    $data_cliente = array(
			'sol_cve_cliente' => $this->session->userdata('clave_cliente'),
			'sol_extension_ejecutivo' => $datos_ejecutivo->eje_extension
	    );
    	$data = array_merge($data_solicitud, $prod_solicitud);
    	$data_all = array_merge($data, $data_cliente);	  

		// Creacion PDF
		 //Set folder to save PDF to
		    $this->html2pdf->folder('./assets/upload/pedidos/pdfs/');
		    
		    //Set the filename to save/download as
		    $this->html2pdf->filename("orden{$the_last_id}.pdf");
		    
		    //Set the paper defaults
		    $this->html2pdf->paper('A4', 'portrait');
		    
		    //Load html view
		    $this->html2pdf->html($this->load->view('pedidos/pdf', $data_all, true));
				    
		    if($path = $this->html2pdf->create('save')) {
		    	//PDF was successfully saved or downloaded
		    	$ruta = base_url()."assets/img/pedidos_firma.jpg";
		    	$this->email->from('web@vimifos.com','Vimifos');

				$list_correos = "agmarron@vimifos.com,".$sol_correos;
				$this->email->to($list_correos);
				
				$this->email->subject('::VIMIFOS::Orden de compra');
				$message = "<fieldset>
								<legend>
									<strong>Estimado Cliente {$grupo_empresarial}</strong>
								</legend>
								<p> 
									'' Se confirma envi&oacute; exitoso de su pedido, Agradecemos su preferencia. En menos de 2 hrs. Un Ejecutivo de Servicio a Clientes se comunicar&aacute; con usted para el seguimiento oportuno de su pedido.'' 
								</p> 
									<img src='{$ruta}'>	
							</fieldset>	";
        		$this->email->message($message);

				$this->email->attach($path);

				$this->email->send();
	        }
		$this->cart->destroy();
		$this->session->unset_userdata('id_transporte');
		redirect("pasos");				
	}

	public function cancelar() {
		$id = $this->uri->segment(3);
		$this->oPasos->update_solicitud(4,$id);
		$correos_sol = $this->oPasos->solicitud_correos($id);
		$list_correos = "agmarron@vimifos.com,".$correos_sol->sol_correos;
		$ruta = base_url()."assets/img/pedidos_firma.jpg";
		    $this->email->from('web@vimifos.com','Vimifos');
			$this->email->to($list_correos);
			$this->email->subject('::VIMIFOS::Orden de compra eliminada');
			$message = "<fieldset>
							<p> 
								''Estimado Cliente {$correos_sol->sol_empresa}, confirmamos que tu orden de compra con el folio {$correos_sol->sol_id_solicitud} ha sido eliminada'' 
							</p> 
							<img src='{$ruta}'>
						</fieldset>	";
    		$this->email->message($message);

			$this->email->send();
				
		redirect('pasos');
	}
	
	function buscarAtributo(){
		echo json_encode($this->oProductoDetalles->get_array(
			'profiedet_profie_detalles_det',
			'profiedet_'.$this->input->post('recibe',TRUE),
			array(
				'profiedet_'.$this->input->post('campoEnvia',TRUE) => $this->input->post('envia',TRUE), 
				'profiedet_producto_id' => $this->input->post('id',TRUE), 
				'profiedet_'.$this->input->post('campoPrincipal',TRUE) => $this->input->post('principal',TRUE)
			)
		));
	}
}

/* End of file frontpage.php */
/* Location: ./application/controllers/pedidos.php */