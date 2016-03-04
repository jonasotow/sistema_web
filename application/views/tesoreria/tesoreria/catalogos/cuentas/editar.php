<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-more-section shadow">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			Editar <?=$titles;?>
		</div>
		<div class="box-catalogo">
			<div class="form-group">
				<?=form_open("/catalogos/addCuenta") ?>
					<div class="form">
						<?php
							$cue_numero = array(
								'name'	=>	'cue_numero',
								'placeholder' => 'Ejemplo: 2141483596 ',
								'class' => 'form-control',
								'type'=>'text',
								'pattern'=>'[0-9]{4,11}',
								'required title' => 'SOLO NÚMEROS DE 4 A 11 CARACTERES',
							);
						?>
						<?php
							$cue_nombre = array(
								'name'	=>	'cue_nombre',
								'placeholder' => 'Ejemplo: Chequera',
								'class' => 'form-control',
							);	
						?>
						<?php
							$cue_descripcion = array(
								'name'	=>	'cue_descripcion',
								'placeholder' => 'Ejemplo: Cuenta de Chequera ',
								'class' => 'form-control',
							);
						?>

						<div class="col-md-6">
							<label for="cue_banco_id">Selecciones el Banco</label>
							<select name="cue_banco_id" class="form-control" required="">
									<option value> -- Seleccione uno Banco -- </option>
							<?php
								if ($ban) {
								foreach ($ban->result() as $ban) { 
							?>
									<option value="<?= $ban->ban_id ?>" ><?= $ban->ban_nombre ?></option>
							<?php }	
								}else{
									echo "<div class='nodata'>NO HAY DATOS</div>";
								}
								?>
							</select>

							<?=form_label('Número de Cuenta:','cue_numero')?>
							<?=form_input($cue_numero) ?>
							<?=form_label('Descripción de Cuenta:','cue_descripcion')?>		
							<?=form_input($cue_descripcion) ?>

							<label for="cue_es_inversion">¿Es Cuenta de Inversión?</label>
							<select name="cue_es_inversion" class="form-control" required="">
								<option value>-- Seleccione una Opción	--</option>
								<option value="<?= $cue_es_inversion='1'?>">SI</option>
								<option value="<?= $cue_es_inversion='0'?>">NO</option>
							</select>
						</div>

						<div class="col-md-6">
							<label for="cue_uninegocio_id">Selecciones la Unidad</label>
							<select name="cue_uninegocio_id" class="form-control" required="">
									<option value> -- Seleccione una Unidad -- </option>
							<?php
								if ($une) {
								foreach ($une->result() as $une) { ?>
									<option value="<?= $une->une_id ?>" ><?= $une->une_nombre ?></option>
							<?php }	
								}else{
									echo "<div class='nodata'>NO HAY DATOS</div>";
								}?>
							</select>
								<?= form_label('Nombre de Cuenta:','cue_nombre')?>		
								<?= form_input($cue_nombre) ?>

							<label for="cue_divisa">Selecciones la Divisa</label>
							<select name="cue_divisa" class="form-control" required="">
								<option value> -- Seleccione Divisa -- </option>
								<option value="USD">USD</option>
								<option value="MXN">MXN</option>
								<option value="EUR">EUR</option>

							</select>
						</div>
						<div class="mdl-card__actions mdl-card--border">
							<button type="submit" class="btn btn-success">Actualizar</button>
							<a href="<?=base_url().'catalogos/bancos' ?>" type="button" class="btn btn-default">Cancelar</a>

						</div>	
					</div>	
				<?=form_close() ?>
			</div>
		</div>
	</div>
</section>


