<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-more-section shadow">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			Editar <?=$titles;?>
		</div>
		<div class="box-catalogo">
			<div class="form-group">
				<?=form_open("/catalogos/updateUnidad/".$id);?>
					<div class="form">
						<?php
							$nombre_unidades = array(
								'name'	=>	'nombre_unidades',
								'class' => 'form-control',
								'style' => 'width: 50%',
								'required' => '',
								'value' => $unidad->une_nombre

							);
						?>
						<div class="col-md-6">			
							<?= form_label('Nombre de la Unidad de Negocios a Actualizar:','nombre_unidades')?>
							<?= form_input($nombre_unidades) ?>
						</div>
						<div class="mdl-card__actions mdl-card--borde">
							<button type="submit" class="btn btn-success">Actualizar</button>
							<a href="<?=base_url().'catalogos/une' ?>" type="button" class="btn btn-default">Cancelar</a>
						</div>
					</div>
				<?=form_close() ?>
			</div>
		</div>
	</div>
</section>
