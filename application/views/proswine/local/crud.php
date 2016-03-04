<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('censos/home');?>">Censos</a></li>

			<li class="active"><?=!isset($new) ? "" : $new;?></li>
	 	</ul>	
</nav>
<section>
	<div class="panel panel-primary">
	  <div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
	  <div class="panel-body">
		<?= $formulario; ?>
		<?=validation_errors('<div id="msgError">', '</div>'); ?>
	  </div>
	  <div class="panel-footer"></div>
	</div>
</section>
<script>
	$(document).ready(function(){
		$("label[for=pmed_via]").hide();
		$("textarea[name=pmed_via]").hide();
		$("label[for=pmed_dosis]").hide();
		$("textarea[name=pmed_dosis]").hide();
		$("label[for=pmed_marca]").hide();
		$("textarea[name=pmed_marca]").hide();
		$("select[name=pmed_type]").change(function(){
			if($(this).val() != ''){
				$("select[name=pmed_typed]").load("<?=site_url('monitores/buscarTipos');?>",{ id: $(this).val() });				
			}
			else{
				$("select[name=pmed_typed]").find('option').remove();
				$('<option>').val('').text('Seleccione un Tipo').appendTo($("select[name=pmed_typed]"));
			}
		});
		$("select[name=pmed_typed]").change(function(){
			if ($("select[name=pmed_type]").val() == 2){
				$("label[for=pmed_via]").html('Via');
				$("label[for=pmed_via]").show();
				$("textarea[name=pmed_via]").show();
				$("label[for=pmed_dosis]").show();
				$("textarea[name=pmed_dosis]").show();
				$("label[for=pmed_marca]").show();
				$("textarea[name=pmed_marca]").show();
			}
			else{
				$("label[for=pmed_via]").html('Observaciones');
				$("label[for=pmed_via]").show();
				$("textarea[name=pmed_via]").show();
				$("label[for=pmed_dosis]").hide();
				$("textarea[name=pmed_dosis]").hide();
				$("label[for=pmed_marca]").hide();
				$("textarea[name=pmed_marca]").hide()
			}
		});
	});
</script>