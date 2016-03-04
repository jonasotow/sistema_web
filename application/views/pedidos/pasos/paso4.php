<nav class="navbar" role="navigation">
    	<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('pedidos/home');?>">Orden de compra</a></li>
			<li><a href="<?=site_url('pasos/paso1');?>">1er Paso</a></li>
			<li><a href="<?=site_url('pasos/paso2');?>">2do Paso</a></li>
			<li><a href="<?=site_url('pasos/paso3');?>">3er Paso</a></li>
			<li class="active">4to paso</li>
	 	</ul>	
</nav>
<section>
	<div class="panel panel-primary">
		<div class="panel-heading">Contestar el siguiente formulario</div>
	  	<div class="panel-body">
			<form id="paso5_form" action="<?=site_url('pasos/paso5');?>" method="post" class="form-inline form_vista_paso4" >
			<?php
			foreach ($pedidos as $key => $pedido) {
				$list         = explode("\n", $pedido->cam_value);
				$cuenta_paids = count($list);
				?>
				<div class="form-group">
				<?php
				$required = $pedido->cam_required == 1 ? 'required' : '' ;
				switch ($pedido->cam_type) {
					case 'text':
						?>
							<label><?=$pedido->cam_label;?></label>
							<input type="text" id="<?=$pedido->cam_id;?>" name="<?=$pedido->cam_name;?>" class="form-control"  value="<?=$pedido->cam_value?>"  <?=$required?> placeholder="" style="width:220px" />
						<?php
						break;

					case 'date':
						?>
							<label><?=$pedido->cam_label;?></label>
						   	<input type="date" id="<?=$pedido->cam_id;?>" name="<?=$pedido->cam_name;?>" class="form-control"  value="<?=$pedido->cam_value?>" <?=$required?> placeholder="" style="width:220px"/>
						<?php
						break;

					case 'radio':
						?>
							<label><?=$pedido->cam_label;?></label>
							<br>
						<?php
						for ($i = 0; $cuenta_paids > $i; $i++) {
							?>
							<label><?=$list[$i];?>
							<input type="radio" id="<?=$pedido->cam_id;?>" name="<?=$pedido->cam_name;?>" />
							</label>

							<?php
						}
						echo "<br>";
						break;

					case 'checkbox':
						?>
							<label><?=$pedido->cam_label;?></label>
							<br>
						<?php
						for ($i = 0; $cuenta_paids > $i; $i++) {
							?>
							<label>
							<?=$list[$i];?>
								<input type="checkbox" id="<?=$pedido->cam_id;?>" name="<?=$pedido->cam_name;?>[]" class="form-control" />
								</label>
							<?php
						}
						echo "<br>";
						break;

					case 'textarea':
						?>
							<label>	<?=$pedido->cam_label;?></label>
							<br>
						   	<textarea id="<?=$pedido->cam_id;?>" name="<?=$pedido->cam_name;?>" value="<?=$pedido->cam_value?>" class="form-control" cols="60" rows="5" <?=$required?> ></textarea>
						<?php
						break;

					case 'select':
						?>

							<label>	<?=$pedido->cam_label;?></label>
						   	<select id="<?=$pedido->cam_id;?>" name="<?=$pedido->cam_name;?>" class="form-control" style="width:800" <?=$required?> >
						<?php

						if($pedido->cam_name === 'ejecutivo'){
							foreach ($ejecutivos as $key_ejecutivo => $ejecutivo) {
								echo "<option>{$ejecutivo->eje_nombre} {$ejecutivo->eje_apellido_paterno}</option>";
							}
						}
						elseif($pedido->cam_name === 'grupo_empresarial'){
							foreach ($grupo_empresariales as $key_grupo_empresariales => $grupo_empresarial) {
								echo "<option>".$grupo_empresarial->gruemp_clave." - ".$grupo_empresarial->gruemp_nombre."</option>";
							}
						}else{
							for ($i = 0; $cuenta_paids > $i; $i++) {
								?>
									<option><?=$list[$i];?></option>
								<?php
							}
						}
						?>
						</select>
						<?php
						break;
					default:
						echo "No es un valor aceptable para un input 'error en la creacion de los campos dinamicos'";
						break;
				}
				echo "</div>";
			}
			?>
				   		<br><br>
				   			<!-- <input id="terminos" type="checkbox" name="terminos"> -->
				   			<i data-toggle="modal" data-target="#myModal" class="modal_terminos">Terminos</i>
				   			<!-- Modal de terminos -->
								<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								        <h4 class="modal-title" id="myModalLabel">T&eacute;rminos y Condiciones</h4>
								      </div>
								      <div class="modal-body">
								       1)	Productos de L&iacute;nea en Firme  liberado por Cr&eacute;dito, se enviar&aacute;n m&aacute;ximo 4 días, posteriores a la fecha del pedido.
								       <br><br>
								       2)	Productos Especiales en Firme liberado por Cr&eacute;dito se enviar&aacute;n m&aacute;ximo 7 d&iacute;as, posteriores a la fecha del pedido. 
								      </div>
								      <div class="modal-footer">
								        <button id="negar_terminos" type="button" class="btn btn-default" data-dismiss="modal">No, acepto</button>
								        <button id="aceptar_terminos" type="button" class="btn btn-primary" data-dismiss="modal">Acepto</button>
								      </div>
								    </div>
								  </div>
								</div>
							<button id="pregunta_envio" type="submit" class="btn btn-primary" >Enviar</button>

			</form>
			<i data-toggle="modal" data-target="#myModalGracias" class="modal_terminos"></i>
				<!-- Modal Gracias-->
				<div class="modal fade" id="myModalGracias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title" id="myModalLabel">¡Gracias!</h4>
				      </div>
				      <div class="modal-body">
				    	Se confirma envi&oacute; exitoso de su pedido, Agradecemos su preferencia. En menos de 2 hrs. Un Ejecutivo de Servicio a Clientes se comunicar&aacute; con usted para el seguimiento oportuno de su pedido.
				      </div>
				      <div class="modal-footer">
				        <button id="negar_terminos" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				      </div>
				    </div>
				  </div>
				</div>
			<?php 
			foreach ($this->cart->contents() as $items) {

				if ($this->cart->has_options($items['rowid']) == TRUE) {
					foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value) {
						if ($option_name == 'envasado') {
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

						elseif ($option_name == 'aditivo') {
							$aditivos = $option_value;
						}
//


					}
				}

				$cantidad = $items['qty'] / $medida;
				$aditivo =  str_replace('|', ',', $aditivos); 
				$productos[] = array(
					'Nombre'      => $items['name'],
					'UM'          => $medida,
					'Cantidad TM' => $items['qty'] / 1000,
					'Sacos'       => $cantidad,
					'Proteina'    => $proteina,
					'Aditivo'     => $aditivo,
					'Tipo'        => $tipo,
				);
			}	 
		?>
			</div>
		</div>
</section>
<script>
$(document).ready(function() {

	$( ".regresar" ).click(function () {
    	location.href = base_url + 'pasos/paso3' ;
    });
    $.datepicker.regional['es'] = {
				closeText: 'Cerrar',
				prevText: '',
				nextText: 'Sig>',
				currentText: 'Hoy',
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
				dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;;', 'Juv', 'Vie', 'S&aacute;b'],
				dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
				weekHeader: 'Sm',
				dateFormat: 'yy-mm-dd',
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};
		$.datepicker.setDefaults($.datepicker.regional['es']);
		//Navegadores que no soportan input type=date
		(navigator.userAgent.indexOf('MSIE') != -1 || navigator.userAgent.indexOf('Firefox') != -1 || navigator.userAgent.indexOf('Media Center PC') != -1) && $('input[type=date]').datepicker();

		//valida la fecha
			$('#fecha_deseada').change(function(event) {
				var date = $(this).val();
				var x = new Date();
				var fecha = date.split("-");
				x.setFullYear(fecha[0],fecha[1]-1,fecha[2]);
				var today = new Date();
				if (x < today){
					alert('La fecha debe de ser mayor a la actual');
					$(this).val('');
				}
		    });

	// desactiva y activa el boton enviar
	$('#pregunta_envio').attr("disabled", true);
	$("#aceptar_terminos").click(function() {  
       $('#pregunta_envio').attr("disabled", false);
    });
    $("#negar_terminos").click(function() {  
       $('#pregunta_envio').attr("disabled", true);
    });  
       
	var data = $.parseJSON('<?=json_encode($productos);?>');
 	$( "#pregunta_envio" ).click(function( event ) {
    	$.liga('pregunta', {tit: '¿Hacer el envio de la orden de compra?', msj: crearTabla(data,'tabla','table table-striped table-hover table-condensed',''),
        funcS:function() {
        	$('#myModalGracias').modal('show');
       		$( "#paso5_form" ).submit();
      	},
      	funcN:function() {

      	}
    	});
    event.preventDefault();  
  	});
  	
  	$("#grupo_empresarial").on('change',function(){
	  	var llamada = null;
			if(llamada == undefined){
				llamada = $.ajax({
		          url: base_url + 'pasos/buscarUbicaciones',
		          dataType: 'json',
		          data : { id_cliente: $("#grupo_empresarial").val().substring(0,$("#grupo_empresarial").val().indexOf('-') - 1) },
		          type : 'POST',
		          success:function(ubicaciones){
			          $("#ubicacion").empty();
			          $.each(ubicaciones,function(i,items){
				          $("#ubicacion").append($(document.createElement('option')).html(items["ubi_direccion"]));
			          });
		          }
		        }); 
	        }
	        llamada.done( function(){llamada = undefined;} );
  	});

  	// carga la primera ubicacion del cliente
	  	var llamada = null;
			if(llamada == undefined){
				llamada = $.ajax({
		          url: base_url + 'pasos/buscarUbicaciones',
		          dataType: 'json',
		          data : { id_cliente: $("#grupo_empresarial").val().substring(0,$("#grupo_empresarial").val().indexOf('-') - 1) },
		          type : 'POST',
		          success:function(ubicaciones){
			          $("#ubicacion").empty();
			          $.each(ubicaciones,function(i,items){
				          $("#ubicacion").append($(document.createElement('option')).html(items["ubi_direccion"]));
			          });
		          }
		        }); 
	        }
	        llamada.done( function(){llamada = undefined;} );
  
});  
</script>