<nav class="navbar" role="navigation">
    	<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('pedidos/home');?>">Orden de compra</a></li>
			<li><a href="<?=site_url('pasos/paso1');?>">1er Paso</a></li>
			<li><a href="<?=site_url('pasos/paso2');?>">2do Paso</a></li>
			<li class="active">3er paso</li>
	 	</ul>	
</nav>
<article>
	<table class="carrito">
		<caption>
			<i class="fa fa-shopping-cart fa-lg"></i>
		</caption>
		<thead>
			<tr>
				<th></th>
				<th> Item </th>
				<th> UM </th>
				<th> Pt. </th>
				<th> Pro. </th>
				<th> Ad. </th>
        		<th> TM </th>
        		<th> Sacos </th>
        		<th></th>
			</tr>
		</thead>
		<tbody>
		<?php
    $cantidad = 0;
    $suma_cantidad = 0;
    $suma_sacos = 0;
			$i = 1;
			foreach ($this->cart->contents() as $items){
		?>
			<tr>
			    <td></td>
			    <td><?=$items['name'];?></td>
			<?php if ($this->cart->has_options($items['rowid']) == TRUE){ 
					$envasado = '';
			      	$presentacion = '';
			      	$proteina = '';
			      	$aditivo = '';
				     foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value){ 
					     $envasado =  $option_name == 'envasado' ? '<td>'.$option_value.'</td>' : $envasado;	
					     $presentacion = $option_name == 'presentacion' ? '<td>'.$option_value.'</td>' : $presentacion;
					     $proteina = $option_name == 'proteina' ? '<td>'.$option_value.'</td>' : $proteina;
					     $aditivo = $option_name == 'aditivo' ? '<td>'.$option_value.'</td>' : $aditivo;
			               if ($option_name == 'envasado') 
			                  $medida = $option_value;
						 		    } 
			      		} 
			      		echo $envasado;
			      		echo $presentacion;
			      		echo $proteina;
			      		echo $aditivo;

			      $cantidad = $items['qty'] / $medida;
        $suma_cantidad = $suma_cantidad + $cantidad;
        $suma_sacos = $suma_sacos + $items['qty'];
        $ton = $items['qty'] / 1000;
        echo "<td>{$ton}</td>";
        echo "<td>{$cantidad}</td>";
      ?>
				<td>
					<a id="eliminar_producto" data-id="<?=$items['rowid'];?>" data-name="<?=$items['name'];?>">
					 <i class="fa fa-trash-o"></i>
					</a>
				</td>
			</tr>			
		<?php $i++;?>
		<?php } ?>
		</tbody>
    <tfoot>
      <tr>
        <td colspan="5" align="right">Total:</td>
        <td >
           <?=($suma_sacos / 1000);?>
        </td>
        <td >
           <?=$suma_cantidad;?>
        </td>
      </tr>  
      <tr>
        <td colspan="8" align="center">
          <a id="vaciar_carrito" class="btn btn-danger btn-sm" ><i class="fa fa-trash-o"></i> Carrito </a> 
        </td>
      </tr>
    </tfoot>
	</table>
</article>
<script>
	var llamada;
	var selectOtros = function(){
		if($("input[type=checkbox]").focus())
			$("#otros").focus();
	}
	var buscarAtributo = function(Id,Principal,Envia,Recibe){
		if(Principal == Envia){
			//Borramos Todos
			$("label[for=Cantidad]").attr('style','display:none');
		    $("#Cantidad").attr('style','display:none');
		    $("label[for=Proteina]").attr('style','display:none');
		    $("#Proteina").attr('style','display:none');
		    $("label[for=Envasado]").attr('style','display:none');
		    $("#Envasado").attr('style','display:none');
		    $("#checkAditivo").attr('style','display:none');
		}
		var datoEnviar = $('#' + Envia).val();
		var datoPrincipal = $('#' + Principal).val();
		if(Recibe !== 'Cantidad' && Envia !== 'Cantidad' && Recibe !== 'Aditivo' && Envia !== 'Aditivo'){
			var llamada = undefined;
			if(llamada == undefined){
				llamada = $.ajax({
		          url: base_url + 'pasos/buscarAtributo',
		          dataType: 'json',
		          data : { id: Id, campoPrincipal: Principal, principal: datoPrincipal, recibe: Recibe, envia: datoEnviar, campoEnvia: Envia},
		          type : 'POST',
		          success:function(atributos){
			          $("#" + Recibe).empty();
			          var agregar = true;
			          var evento = false;
			          if(atributos.length !== 1)
		          	  	$("#" + Recibe).append($(document.createElement('option')).html('Seleccione un elemento'));
		          	  else
		          	  	evento = true;
		              $.each(atributos,function(i,items){
			              if(items["profiedet_" + Recibe] == 0 && Recibe == 'Proteina' && atributos.length == 1){
				              $("label[for=Cantidad]").attr('style','');
			          		  $("#Cantidad").attr('style','');
			          		  $("#anadir_carrito").attr('disabled',false);
			          		  agregar = false;
			              }
			              else
			              	$("#" + Recibe).append($(document.createElement('option')).html(items["profiedet_" + Recibe]));
		              });
		              if(agregar){
		              	$('#' + Envia).append('<br>');
		              	$("label[for=" + Recibe + "]").attr('style','');
		              	$("#" + Recibe).attr('style','');
	              	 }
	              	 if(evento){
		              	    var fireOnThis = document.getElementById(Recibe);
						    if (document.createEvent){
						        var evObj = document.createEvent('HTMLEvents');
						        evObj.initEvent( 'change', false, true );
						        fireOnThis.dispatchEvent(evObj);
						    }else if (document.createEventObject)
						    	fireOnThis.fireEvent('onchange');
	              	 }
	              	 llamada = undefined;
		          }
		        }); 
	        }
        }
        else{
	        if(Recibe === 'Aditivo'){
		        if(llamada == undefined){
					llamada = $.ajax({
			          url: base_url + 'pasos/buscarAtributo',
			          data : { id: Id, campoPrincipal: Principal, principal: datoPrincipal, recibe: Recibe, envia: datoEnviar, campoEnvia: Envia},
			          type : 'POST',
			          dataType: 'json',
			          success:function(atributos){
				         if(atributos[0]['profiedet_' + Recibe] > 0){
					         $("#check" + Recibe).attr('style','');
				         }
				         $('#' + Envia).append('<br>');
		          		 $("label[for=Cantidad]").attr('style','');
		          		 $("#Cantidad").attr('style','');
		          		 $("#anadir_carrito").attr('disabled',false);
		          		 llamada = undefined;
			          }
			        }); 
		        }
	        }
	        else{
	      		$('#' + Envia).append('<br>');
          		$("label[for=" + Recibe + "]").attr('style','');
          		$("#" + Recibe).attr('style','');
          		$("#anadir_carrito").attr('disabled',false);
      		}
        }
	}
</script>
<section>
	<div class="panel panel-primary">
		<div class="panel-heading">Selecciona los productos</div>
	  	<div class="panel-body">
			<div class="especies">
		        <img id ="camaron"  src="<?=base_url().'assets/img/pedidos/acuicultura.jpg';?>">
		        <img id ="avicultura" src="<?=base_url().'assets/img/pedidos/avicultura.jpg';?>" class="opacity">
		        <img id ="bovino"  src="<?=base_url().'assets/img/pedidos/bovino.jpg';?>" class="opacity">
		        <img id ="equinos" src="<?=base_url().'assets/img/pedidos/equinos.jpg';?>" class="opacity">
		        <img id ="pez"  src="<?=base_url().'assets/img/pedidos/pescado.jpg';?>" >
		        <img id ="porcicultura"  src="<?=base_url().'assets/img/pedidos/porcicultura.jpg';?>" class="opacity">
			</div>
			<div id="productos">
			</div>
			<?php
			$atributos = array('class' => 'form-inline', 'id' => 'form_carrito');
			echo form_open('pasos/insert_carrito', $atributos);
			?>
			<div id="productos_detalles">
			</div>
			<?=form_close();?>
			<br/>
			<a href="<?=site_url('pasos/paso4');?>" class="btn btn-primary siguiente_paso3" ><i class="fa fa-angle-double-right"> Siguiente </i></a>
		</div>
	</div>
</section>
<script>
$(document).ready(function() {
  $( ".regresar" ).click(function () {
    location.href = base_url + 'pasos/paso2' ;
  });
  
  var buscarDetalles = function(especie, id, marca, descripcion, clave){
	  if(llamada == undefined){
		  llamada = $.ajax({
	          url: base_url + 'pasos/productos',
	          data : { especie: especie , id_producto: id},
	          async: true,
	          type : 'POST',
	          success:function(productos_detalle){
		        $('#productos_detalles').empty();
	            $('#productos_detalles').append("<label class='label-marca'><strong>Marca : </strong>" + marca +"</label>");
	            $('#productos_detalles').append("<label class='label-desc'><strong>Descripción : </strong>" + descripcion +"</label>");
	            $('#productos_detalles').append("<input id='pro_id_producto' name='pro_id_producto' type='hidden' value='" + id +"' />");
	            $('#productos_detalles').append("<input id='nombre' name='nombre' type='hidden' value='" + marca +"' />");
	            $('#productos_detalles').append("<input id='clave' name='clave' type='hidden' value='" + clave +"' /><br>");
	            $('#productos_detalles').append("<input id='tipo' name='tipo' type='hidden' value='" + especie +"' /><br>");
	            $('#productos_detalles').append(productos_detalle);
	            $('#productos_detalles').append("<button id='anadir_carrito' name='anadir_carrito' type='submit' class='btn btn-primary btn-sm' disabled >A&ntilde;adir producto <i class='fa fa-shopping-cart'></i></button>");
	            llamada = undefined;
	          }
	        });
	      }   
      }

  //funciones para ocutaly y mostrar los productos a comprar
  $( ".especies img" ).click(function () {
    $('#productos').empty();
    $('#productos_detalles').empty();
    var valor_especie = $(this).attr("id");
    if(llamada == undefined){
	    llamada = $.ajax({
	      url: base_url + 'pasos/productos',
	      data : { especie : valor_especie },
	      type : 'POST',
	      dataType: 'json',
	      async: true,
	      success:function(productos){
	        $.each(productos, function(indice, dato){
	          $('#productos').append("<img id='" + dato.pro_id_producto + "' src='" + base_url + "../assets/upload/" + dato.pro_imagen + "' class='imagenes_pequenas' />");
	          $('#' + dato.pro_id_producto).click(function(){
		          buscarDetalles(valor_especie,dato.pro_id_producto, dato.pro_marca, dato.pro_descripcion, dato.clave);
	          });
	        });
	        llamada = undefined;
	      }
	    });
    }
    $('#productos').empty();
  });   
  // desactiva el boton enviar y eliminar carrito
  $('.btn-primary').attr("disabled", true);
  $('#vaciar_carrito').attr("disabled", true);
  if ('<?=$suma_cantidad ?>' != 0 ) {
  	//activa el boton enviar y eliminar carrito
    $('.btn-primary').attr("disabled", false);
    $('#vaciar_carrito').attr("disabled", false);
    //pregunta si deseas eliminar los productos del carrito
    $( "#vaciar_carrito" ).click(function( event ) {
			$.liga('pregunta', {tit: '¿Estas seguro de eliminar los productos?',
			    funcS:function() {
					$.ajax({
						url: base_url + 'pasos/delete_carrito',
					//	data : {},
						type : 'GET',
						success:function(productos_detalle){
						$('section').liga('mensaje', 'Eliminando...<i class="fa fa-spinner fa-spin"></i>');
						location.href = base_url + 'pasos/paso3' ;
						}
					});  
			  	},
			  	funcN:function() {}
			});
			event.preventDefault();  
		});
    //
    //
  }
  $( "a[id=eliminar_producto]" ).click(function( event ) {
    	var id_pro = $(this).data('id');
			$.liga('pregunta', {tit: '¿Estas seguro de eliminar el producto?',
			    funcS:function() {
					$.ajax({
						url: base_url + 'pasos/update_carrito/' + id_pro,
						data : {},
						type : 'GET',
						success:function(productos_detalle){
						location.href = base_url + 'pasos/paso3' ;
						}
					});  
			  	},
			  	funcN:function() {}
			});	
			event.preventDefault();  
		});
});
</script>
