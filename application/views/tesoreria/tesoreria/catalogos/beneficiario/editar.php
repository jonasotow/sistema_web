<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-more-section shadow">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			Editar <?=$title;?>
		</div>
		<div class="box-catalogo">
			<div class="form-group">
				<?=form_open("/catalogos/updateBeneficiario/".$id);?>
					<div class="form">
						<?php
							$nombre_beneficiarios = array(
								'name'	=>	'nombre_beneficiarios',
								'class' => 'form-control',
								'required' => '',
								'value' => $beneficiario->ben_nombre

							);
						?>
						<div class="col-md-6">		
							<?= form_label('Nombre del Banco a Actualizar:','nombre_beneficiarios')?>
							<?= form_input($nombre_beneficiarios) ?>
						</div>	
						<div class="mdl-card__actions mdl-card--borde">
							<button type="submit" class="btn btn-success">Actualizar</button>
							<a href="<?=base_url().'catalogos/beneficiarios' ?>" type="button" class="btn btn-default">Cancelar</a>
						</div>
					</div>
				<?= form_close() ?>
			</div>
		</div>
	</div>
</section>
