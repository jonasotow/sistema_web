<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
      	<?=!isset($agregar_contacto) ? "" : $agregar_contacto; ?>
      	<?=!isset($agregar_granja) ? "" : $agregar_granja; ?>
      	<?=!isset($agregar_censo) ? "" : $agregar_censo; ?>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('censos/home');?>">Censos</a></li>
			<li><a href="<?=!isset($titulo) ? "" : site_url($titulo); ?>"><?=!isset($titulo) ? "" : $titulo; ?></a></li>
			<li class="active"><?=!isset($new) ? "" : $new; ?><li>
	 	</ul>	
</nav>
<section>
	<!-- Menu -->
	<div class="panel panel-primary">
	  <div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
	  <div class="panel-body">
		<?=!isset($mensajes) ? "" : $mensajes;?>
		<?= $formulario; ?>
		<?=validation_errors('<div id="msgError">', '</div>'); ?>
	  </div>
	</div>
	<!-- Formulario referente a la especie -->
	<div id="formulario_especie">
		
	</div>
	<?php if( isset($contactos) or isset($granjas) or isset($censos)){ ?>

		
	<div class="panel panel-primary">
	  <div class="panel-heading"></div>
	  <div class="panel-body">
	  <?=validation_errors('<div id="msgError">', '</div>'); ?>
		<!-- Tabla de Contactos relacionados a el cliente -->
		<?=!isset($contactos) ? "" : $contactos;?>
		<!-- Tabla de Granjas relacionados a el cliente -->
		<?=!isset($granjas) ? "" : $granjas;?>
		<!-- Censos disponibles de los clientes por granjas -->
		<?=!isset($censos) ? "" : $censos;?>
	  </div>
	</div>
	<?php } ?>
</section>
<script>
 	$( document ).ready(function() {
     	$('table tbody').delegate("tr", "click", function(){
	     	location.href = '<?=site_url();?>' + "/" + $(this).closest('table').data('name') + "/editar/" + this.cells[0].innerHTML;
    	});
    	$('#censos').on("submit", function(event){
	    	event.preventDefault();
	    	fields = $(this).serializeArray();
	    	var temp = new Array();
	    	jQuery.each( fields, function( i, field ) {
		      temp.push({name: field.name, value: field.value, id: $('[name="' + field.name + '"]').data('id'), campo: $('[name="' + field.name + '"]').data('campo') });
		    });
	    	$.ajax({
		        type: 'post',
		        url: this.action,
		        data: { datos: JSON.stringify(temp)},
    			async: false,
		        success: function(msg) {}
		    });
    	});
    	
    	$('select[name="cli_estado"]').change(function(event){
	    	$.ajax({
		        type: 'post',
		        url: "<?=site_url('clientes/getMunicipios');?>",
		        data: { estado: $(this).val()},
    			async: false,
    			dataType: 'json',
		        success: function(temp) {
			        var $select = $('select[name="cli_municipio"]');
					$select.find('option').remove();                          
					$.each(temp, function(key, value) {              
					    $('<option>').val(key).text(value).appendTo($select);
					});
			    }
		    });
    	});
    	
    	var llenarForm = function(id,action){
	    	$.ajax({
		        type: 'post',
		        url: action,
		        data: { especie: $('select[name="' + id + '"]').val()},
    			async: false,
		        success: function(temp) {
			       $('#form_enviar fieldset:first form').empty();
			       $('#form_enviar fieldset:first').append(temp);
			    }
		    });
    	};
    	<?php if (isset($formulario_especie)){  ?>
    		llenarForm('cli_tipo_cliente',"<?=site_url('clientes/getFormularioEspecie');?>");
	    <?php } ?>
    	$('select[name="cli_tipo_cliente"]').change(function(event){llenarForm('cli_tipo_cliente',"<?=site_url('clientes/getFormularioEspecie');?>")});
    	$('select[name="per_id_especie"]').change(function(event){llenarForm('per_id_especie',"<?=site_url('periodos/getFormularioEspecie');?>")});
    	
    	var enviarForm = function(action){
	    	if($("#especies").serializeArray() != undefined || $("#especies").serializeArray() != ''){
		    	fields = $("#especies").serializeArray();
		    	var temp = new Array();
		    	jQuery.each( fields, function( i, field ) {
		    		temp.push({name: field.name, value: field.value, id: $('[name="' + field.name + '"]').data('id'), campo: $('[name="' + field.name + '"]').data('campo') });
			    });
		    	$.ajax({
			        type: 'post',
			        url: action,
			        data: { datos: JSON.stringify(temp)},
	    			async: true,
			        success: function(msg) { $('#form_enviar').submit(); }
			    });
			}
			else
				$('#form_enviar').submit();
    	}
    	
    	$('#guardar_especie').on("click", function(event){ event.preventDefault(); enviarForm("<?=site_url('censos/recibirDatosForm');?>");});    	
	   	$('#guardar_tipoespecie').on("click", function(event){event.preventDefault(); enviarForm("<?=site_url('censos/recibirDatos');?>");});
 	});
</script>