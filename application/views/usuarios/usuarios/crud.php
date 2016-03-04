<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('');?>">donde estoy</a></li>
			<li class="active">Primer paso</li>
	 	</ul>
</nav>
<section>
<!-- Menu -->
	<?=validation_errors('<div id="msgError">', '</div>'); ?>
	<div class="panel panel-primary">
	  	<div class="panel-heading"></div>
	  	<div class="panel-body">
			<?=!isset($mensajes) ? "" : $mensajes;?>
			<?= $formulario; ?>
			<div id="usuarios_aplicaciones"></div>
		</div>
		<div class="panel-footer"></div>
	</div>
	<br>
</section>
<script>
	$(document).ready(function(){

     	
		$.ajax({
			url: base_url + '<?=$controller_script;?>',
		//	data : { id: 'nada'},
			type : 'POST',
			dataType: 'json',
			success:function(application){
				$.each(application, function(index, appl) {
					$("#usuarios_aplicaciones").append("<div id='checkbox_roles'> " +
						                                 "<div class='checkbox'><label>" + appl.apl_nombre + 
														 "<input type='checkbox' name='' value=''/></label></div>");
					$.ajax({
						url: base_url + 'usuarios1/roles',
						data : { application_id: appl.apl_id},
						type : 'POST',
						dataType: 'json',
						success:function(a){
							$.each(a, function(index, val) {
								$("#checkbox_roles").append("<div class='checkbox-inline'><label>" + val.rol_nombre + 
															"<input type='checkbox' name='' value=''/></label></div>");

							});
						}
					});
					$("#usuarios_aplicaciones").append("<div id='checkbox_roles'>") 
				});
			}
		}); 
	});
</script>