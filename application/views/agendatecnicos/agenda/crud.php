<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
      		<?=!isset($agregar) ? "" : $agregar; ?>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('agendatecnicos/home');?>">Agenda</a></li>
			<li><a href="<?=site_url($titulo);?>"><?=!isset($titulo) ? "" : $titulo; ?></a></li>
			<li class="active"><?=!isset($new) ? "" : $new; ?></li>
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
	  <div class="panel-footer"></div>
	</div>
</section>