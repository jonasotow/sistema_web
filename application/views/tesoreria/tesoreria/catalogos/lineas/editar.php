<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-more-section shadow">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			Editar <?=$titles;?>
		</div>
		<div class="box-catalogo">
			<div class="form-group">
				<?=form_open("/catalogos/updateLinea/".$id);?>
					<div class="form">
						<?php
							$linea_descripcion = array(
								'name'	=>	'linea_descripcion',
								'placeholder' => 'Ejemplo: Linea',
								'class' => 'form-control',
								'required' => '',
								'value' => $lin->lin_descripcion 
							);
						?>
						<?php
							$lin_autorizado = array(
								'name'	=>	'lin_autorizado',
								'placeholder' => 'Ejemplo: $100',
								'class' => 'form-control',
								'type'=>'text',
								'pattern'=>'[0-9]{1,}',
								'required title' => 'INGRESE SOLO NÚMEROS',
								'value' => $lin->lin_autorizado 
							);
						?>

						<?php
							$lin_disponible = array(
								'name'	=>	'lin_disponible',
								'placeholder' => 'Ejemplo: $100',
								'class' => 'form-control',
								'type'=>'text',
								'pattern'=>'[0-9]{1,}',
								'required title' => 'INGRESE SOLO NÚMEROS',
								'value' => $lin->lin_disponible 
							);
						?>
					<div class="col-md-6">
						<label for="lin_banco_id">Selecciones el Banco</label>
						<select name="lin_banco_id" class="form-control" required >
								<option value="<?=$linbans->ban_id;?>">-- <?=$linbans->ban_nombre;?> --</option>

						<?php
							foreach ($ban->result() as $ban) { ?>
								<option value="<?= $ban->ban_id ?>"><?= $ban->ban_nombre ?></option>
						<?php	}	?>
						</select>				

						<?= form_label('Cantidad de Linea Autorizada:','lin_autorizado')?>		
						<?= form_input($lin_autorizado) ?>

						<label for="lin_es_largo_plazo">¿La Linea es a Largo Plazo?</label>
						
						<select name="lin_es_largo_plazo" class="form-control" required="">
							<option value="<?= $lin->lin_es_largo_plazo ?>">-- 
								<?php
									$var = $lin->lin_es_largo_plazo;
									if ( $var == 0) {
										echo "NO";
									}
									else{
										echo "SI";
									}
								?>
							--</option>
							<option value="<?= $lin_es_largo_plazo='1'?>">SI</option>
							<option value="<?= $lin_es_largo_plazo='0'?>">NO</option>
						</select>
					</div>
					<div class="col-md-6">
						<?= form_label('Descripción de la Linea:','linea_descripcion')?>
						<?= form_input($linea_descripcion) ?>
						<?= form_label('Saldo de Linea Disponible:','lin_disponible')?>		
						<?= form_input($lin_disponible) ?>
					</div>
					<div class="mdl-card__actions mdl-card--border">
						<button type="submit" class="btn btn-success">Actualizar</button>
						<a href="<?=base_url().'catalogos/lineas' ?>" type="button" class="btn btn-default">Cancelar</a>
					</div>	

				</div>
			<?= form_close() ?>
			</div>
		</div>
	</div>
</section>