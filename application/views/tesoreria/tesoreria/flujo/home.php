
<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-more-section shadow">
		<div class="form-fc">
			<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
				<?=$title;?>
			</div>
			<?=form_open("/flujo/data/")?>
				<label for="cue_uninegocio_id">Selecciones la Unidad</label>
				<select name="cue_uninegocio_id" class="form-control" required="">
					<option value> -- Seleccione una Unidad -- </option>
					<?php
						if ($une) {
							foreach ($une->result() as $une) { ?>
					<option value="<?=$une->une_id ?>" ><?=$une->une_nombre ?></option>
					<?php } 
						}else{
							echo "<div class='nodata'>NO HAY DATOS</div>";
						}
					?>
				</select>
				<label for="cue_divisa">Selecciones la Divisa</label>
				<select name="cue_divisa" class="form-control" required="">
					<option value> -- Seleccione Divisa -- </option>
					<option value="USD">USD</option>
					<option value="MXN">MXN</option>
					<option value="EUR">EUR</option>
				</select>
				<div class="mdl-card__actions mdl-card--border">
					<button type="submit" class="btn btn-success">Entrar</button>
				</div>
			<?= form_close() ?>    
		</div>			    
	</div>
</section>

