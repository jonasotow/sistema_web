<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-more-section shadow">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			Editar <?=$titles;?>
		</div>
		<div class="box-catalogo">
			<div class="form-group">
				<?=form_open("/catalogos/updatebank/".$id);?>
					<div class="form">
						<?php
							$nombre_bancos = array(
								'name'	=>	'nombre_bancos',
								'class' => 'form-control',
								'required' => '',
								'value' => $banco->ban_nombre
							);
						?>
						<div class="col-md-6">		
							<?= form_label('Nombre del Banco a Actualizar:','nombre_bancos')?>
							<?= form_input($nombre_bancos) ?>
						</div>
						<div class="mdl-card__actions mdl-card--borde">
							<button type="submit" class="btn btn-success">Actualizar</button>
							<a href="<?=base_url().'catalogos/bancos' ?>" type="button" class="btn btn-default">Cancelar</a>
						</div>
					</div>
				<?=form_close() ?>
			</div>
		</div>
	</div>
</section>
