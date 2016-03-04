<nav class="navbar" role="navigation">
	<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
	<?=isset($nuevo) ? $nuevo : ''  ?>
	<!--
  	<form class="navbar-form navbar-left" role="search">
	    <div class="form-group">
	      <input type="text" class="form-control input-sm" placeholder="Buscar">
	    </div>
	    <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
	</form>
	-->
  	<ul class="navbar-right breadcrumb">
		  <li><a href="<?=site_url('pedidos/home');?>">Orden de compra</a></li>
 	</ul>	
</nav>
<section>
	<div class="panel panel-primary">
	  <div class="panel-heading">
	  	<h3 class="panel-title">Ordenes de compra</h3>
	  </div>
	  <div class="panel-body">
	  <?php
			if ( is_array($pedidos) ) {
		?>
			<table class="table table-striped table-hover table-condensed">
				 <thead>
					<tr>
						<th></th>
						<th><i class="fa fa-slack fa-lg"></i></th>
						<th><i class="fa fa-university fa-lg"></i></th>
						<th><i class="fa fa-truck fa-lg"></i></th>
						<th><i class="fa fa-calendar fa-lg"></i><span class="thead-text">Creacion</span></th>
						<th><i class="fa fa-calendar fa-lg"></i><span class="thead-text">Deseada</span></th>
						<th><i class="fa fa-male fa-lg"></i><span class="thead-text">Solicita</span></th>
						<th><i class="fa fa-male fa-lg"></i><span class="thead-text">Ejecutivo</span></th>
						<th></th>
						<th></th>
					</tr>
				 </thead>
				 <tbody>
		<?php 
				foreach ($pedidos as $key => $pedido) {
					// fecha creacion
						$fecha_crea  = explode(' ', $pedido->sol_fecha_creacion );
						$fech_crea = explode('-', $fecha_crea[0] );
						$fecha_creacion = $fech_crea[2].'/'.$fech_crea[1].'/'.$fech_crea[0];
					//   fecha deseada
						$fecha_desea  = explode(' ', $pedido->sol_fecha_creacion );
						$fech_dese = explode('-', $fecha_desea[0] );
						$fecha_deseada = $fech_dese[2].'/'.$fech_dese[1].'/'.$fech_dese[0];
		?>
					<tr>
						<td></td>
						<td><?=$pedido->sol_id_solicitud;?></td>
						<td><?=$pedido->pla_nombre;?></td>
						<td><?=$pedido->tra_nombre;?></td>
						<td><?=$fecha_creacion;?></td>
						<td><?=$fecha_deseada;?></td>
						<td><?=$pedido->sol_persona_solicita;?></td>
						<td><?=$pedido->sol_ejecutivo;?></td>
						<td>
							<?php $cancelar = "<a id='{$pedido->sol_id_solicitud}' title='Eliminar' class='cancelar_factura' ><i class='fa fa-trash-o'></i></a>" ?>
							<?=$orden_clave = !empty($factura[$key]) ?  $factura[$key] : $cancelar ?>
						</td>
						<td>
							<?php if (!empty($factura[$key])) { ?>
							<a href="<?=base_url().'index.php/pasos/orden_detalles_pdf/'.$pedido->sol_id_solicitud ?>" target="_blank" class="td">
								<i class="fa fa-file-pdf-o"></i>
							</a>
							<?php }else{ ?>
							<a href="<?=base_url().'assets/upload/pedidos/pdfs/orden'.$pedido->sol_id_solicitud.'.pdf'; ?>" target="_blank" class="td">
								<i class="fa fa-file-pdf-o"></i>
							</a>
							<?php } ?>
						</td>
					</tr>
		<?php 
				}
			
		?>		
				 </tbody>
			</table>
			<div id="seguimiento_pedido"></div>
		<?php
			}else{	
				echo '<h4>No existe orden de compra</h4>' ;
			}
		?>	

	  </div>
	</div>
</section>
<!-- Modal -->
<div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="detalleOrdenModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="labelDetalle"></h4>
      </div>
      <div class="modal-body" id="detalleOrden">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
<script>

	$(document).ready(function() {

		$( ".regresar" ).click(function () {
			location.href = base_url + 'pedidos/home' ;
		});

		$( ".cancelar_factura" ).click(function( event ) {
			id = $( this ).attr('id');
	    	$.liga('pregunta', {tit: 'Eliminar', msj: '¿Estas seguro de eliminar la orden de compra ' + id + ' ?',
	        funcS:function() {
				$.ajax({
					url: base_url + 'pasos/cancelar/' + id,
					type : 'POST',
					dataType: 'text',
					success:function(){
						$('section').liga('mensaje', 'Eliminando...<i class="fa fa-spinner fa-spin"></i>');	
						location.href = base_url + 'pasos' ;
					}
				});
	      	},
	      	funcN:function() {}
	    	});
    	event.preventDefault();  
  	});

		$('table tbody').css('cursor', 'pointer' );
		$('table tbody tr').delegate("td", "click", function(){
			if(this.innerHTML.indexOf('href') < 0 && this.innerHTML.indexOf('cancelar_factura') < 0){
				var RowIndex =$(this).parent().parent().children().index($(this).parent());
				var Row = $('table tbody tr')[RowIndex];
				$.ajax({
			        type: 'post',
			        url: "<?=site_url('pasos/productos_solicitud');?>",
					dataType: 'json',
					async: false,
					data: { 'solicitud_id': Row.cells[1].innerHTML },
			        success: function(datos) {
				        $("#labelDetalle").html('Orden de Compra #' + datos[0].sol_id_solicitud);
				        var cuerpo = document.createElement('div');
				        cuerpo = $(cuerpo);
				        cuerpo.append($(document.createElement('p')).html("Cliente: " + datos[0].usu_usuario + " - " + datos[0].usu_nombre + " " + datos[0].usu_apellido_paterno + " " + datos[0].usu_apellido_materno));
				        cuerpo.append($(document.createElement('p')).html("Persona que solicita: " + datos[0].sol_persona_solicita));
				        cuerpo.append($(document.createElement('p')).html("Fecha de creaci&oacute;n: " + strFecha(new Date(datos[0].sol_fecha_creacion.substring(0,datos[0].sol_fecha_creacion.length - 9)))));
				        cuerpo.append($(document.createElement('p')).html("Fecha de deseada: " + strFecha(new Date(datos[0].sol_fecha_deseada.substring(0,datos[0].sol_fecha_creacion.length - 9)))));
				        var Tabla = document.createElement('table');
					    Tabla.setAttribute("class",'table table-striped table-hover table-condensed');
					    Tabla = $(Tabla);
					    Tabla.append($(document.createElement('caption')).html('Productos Solicitados'));
					
					    var Head = $(document.createElement('thead'));
					    var trHead = $(document.createElement('tr'));
					    trHead.append($(document.createElement('th')).html('id'));
				    	trHead.append($(document.createElement('th')).html('Producto'));
				    	trHead.append($(document.createElement('th')).html('Envasado'));
				    	trHead.append($(document.createElement('th')).html('Presentaci&oacute;n'));
				    	trHead.append($(document.createElement('th')).html('Proteina'));
				    	trHead.append($(document.createElement('th')).html('Aditivos'));
				    	trHead.append($(document.createElement('th')).html('Tipo'));				    	
				    	trHead.append($(document.createElement('th')).html('Cantidad Sacos'));
				    	trHead.append($(document.createElement('th')).html('Cantidad KG'));
						
						Head.append(trHead);
						Tabla.append(Head);
						
						var Body = $(document.createElement('tbody'));
						$.each(datos,function(i,items){
							var TR = $(document.createElement('tr'));
							TR.append($(document.createElement('td')).html(i));
							TR.append($(document.createElement('td')).html(items.soldet_nombre));
							TR.append($(document.createElement('td')).html(items.soldet_envasado));
							TR.append($(document.createElement('td')).html(items.soldet_presentacion));
							TR.append($(document.createElement('td')).html(items.soldet_proteina));
							TR.append($(document.createElement('td')).html(items.soldet_aditivos));
							TR.append($(document.createElement('td')).html(items.soldet_tipo));													
							TR.append($(document.createElement('td')).html(items.soldet_cantidad));
							TR.append($(document.createElement('td')).html(items.soldet_sacos));
							Body.append(TR);
						});
						Tabla.append(Body);
						cuerpo.append(Tabla);
						$("#detalleOrden").html(cuerpo[0].outerHTML);
				    }
			    });
	            $('#detalleModal').modal({
	 	          	keyboard: true,
	 	          	show: true
	            });
            }
	    });
	});

</script>
