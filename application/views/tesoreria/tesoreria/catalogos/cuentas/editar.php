<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-more-section shadow">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			Editar <?=$titles;?>
		</div>
		<div class="box-catalogo">
			<div class="form-group">
				<?=form_open("/catalogos/updateCuenta/".$id);?>
					<div class="form">
						<?php
							$cue_numero = array(
								'name'	=>	'cue_numero',
								'placeholder' => 'Ejemplo: 2141483596 ',
								'class' => 'form-control',
								'type'=>'text',
								'pattern'=>'[0-9]{3,11}',
								'required title' => 'SOLO NÚMEROS DE 4 A 11 CARACTERES',
								'value' => $ctabanune->cue_numero
							);
						?>
						<?php
							$cue_nombre = array(
								'name'	=>	'cue_nombre',
								'placeholder' => 'Ejemplo: Chequera',
								'class' => 'form-control',
								'value' => $ctabanune->cue_nombre
							);	
						?>

						<div class="col-md-6">
							<label for="cue_banco_id">Selecciones el Banco</label>
							<select name="cue_banco_id" class="form-control" required="">
									<option value="<?= $ctabanune->ban_id ?>">-- <?= $ctabanune->ban_nombre ?> --</option>
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

							<label for="cue_descripcion">Selecciones Origen </label>
							<select name="cue_descripcion" class="form-control">
								<option value="<?= $ctabanune->cue_descripcion ?>">-- <?= $ctabanune->cue_descripcion ?> --</option>
								<option value="GDL">GDL</option>
								<option value="OBR">OBR</option>
							</select>

							<label for="cue_es_inversion">¿Es Cuenta de Inversión?</label>
							<select name="cue_es_inversion" class="form-control" required="">
								<option value="<?= $ctabanune->cue_es_inversion ?>">-- Seleccione una Opción --</option>
								<option value="<?= $cue_es_inversion='1'?>">SI</option>
								<option value="<?= $cue_es_inversion='0'?>">NO</option>
							</select>
						</div>

						<div class="col-md-6">
							<label for="cue_uninegocio_id">Seleccione la Unidad</label>
							<select name="cue_uninegocio_id" class="form-control" required="">
									<option value="<?= $ctabanune->une_id ?>">-- <?= $ctabanune->une_nombre ?> --</option>

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

							<label for="cue_divisa">Seleccione la Divisa</label>
							<select name="cue_divisa" class="form-control" required="">
								<option value="<?= $ctabanune->cue_divisa ?>">-- <?= $ctabanune->cue_divisa ?> --</option>
								<option value="USD">USD</option>
								<option value="MXN">MXN</option>
								<option value="EUR">EUR</option>

							</select>
						</div>
						<div class="mdl-card__actions mdl-card--border">
							<button type="submit" class="btn btn-success">Actualizar</button>
							<a href="<?=base_url().'catalogos/cuentas' ?>" type="button" class="btn btn-default">Cancelar</a>

						</div>	
					</div>	
				<?=form_close() ?>
			</div>
		</div>
	</div>
</section>


