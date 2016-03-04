<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
</nav>
<section>
<!-- Menu -->
	<div class="panel panel-primary">
	  <div class="panel-heading"><?=isset($new) ? $new : "";?></div>
	  <div class="panel-body">
	    <?=isset($mensaje_imagen) ? $mensaje_imagen  : "";?>
		<?=isset($mensajes) ? $mensajes  : "";?>
		<?= $formulario; ?>
		<?=validation_errors('<div id="msgError">', '</div>'); ?>
	  </div>
	</div>
</section>