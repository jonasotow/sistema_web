<section>
	<div class="panel">	
	  <div class="panel-body">
		<?=isset($mensajes) ? $mensajes  : "";?>
		<?= $formulario; ?>
		<?=validation_errors('<div id="msgError">', '</div>'); ?>
	  </div>
	</div>
</section>