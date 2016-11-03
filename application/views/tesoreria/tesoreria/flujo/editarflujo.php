 <section class="vimifos-content mdl-layout__content">
	<div class="panel panel-primary">
		<div class="panel-heading vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$obtenercuentaune->une_nombre;?> <?=$obtenercuentaune->cue_nombre;?> <?=$obtenercuentaune->cue_numero;?> - <?=$obtenercuentaune->cue_divisa;?>
		</div>
		<div class="panel-body shadow">
			<?=form_open("/flujo/updateFlujo/") ?>

			<input type="hidden" name="cuentaretorn" value="<?=$obtenercuentaune->une_id;?>|<?=$obtenercuentaune->cue_divisa;?>|<?=$obtenercuentaune->cue_id;?>">

			<div class="form">
				<?php
					$sumaentradas = $obtenercuentaune->cued_sald_ini + $obtenercuentaune->cued_depos_fir; 
					$restaflujo = $obtenercuentaune->cued_cheq_circ + $obtenercuentaune->cued_cheques;
					$totaldesaldo = $obtenercuentaune->cued_sald_fin;
				?>	
					<?php
						$cued_sald_ini = array(
							'type'=>'text',
							'id'=>'valor1',
							'tabindex'=>'1',
							'onkeyup'=>'sumar();',
							'style' => 'width: 150%',
							'name' => 'cued_sald_ini',
							'class' => 'form-control',
							'required title' => 'INGRESE SOLO NÚMEROS',
							'value' => $obtenercuentaune->cued_sald_ini
						);
					?>
						<?php
						$cued_cheq_circ = array(
							'type'=>'text',
							'id'=>'valor2',
							'tabindex'=>'2',
							'onkeyup'=>'sumar();',
							'style' => 'width: 150%',
							'class' => 'form-control',
							'name'	=>	'cued_cheq_circ',
							'required title' => 'INGRESE SOLO NÚMEROS',
							'value' => $obtenercuentaune->cued_cheq_circ
						);
					?>
					<?php
						$cued_pagos = array(
							'type'=>'text',
							'id'=>'valor3',
							'onkeyup'=>'sumar();',
							'style' => 'width: 150%',
							'name' => 'cued_pagos',
							'class' => 'form-control disabe',
							'required title' => 'INGRESE SOLO NÚMEROS',
							'value' => $obtenercuentaune->cued_cheques * -1
						);
					?>
					<?php
						$cued_depos_fir = array(
							'type'=>'text',
							'id'=>'valor4',
							'tabindex'=>'3',
							'onkeyup'=>'sumar();',
							'style' => 'width: 150%',
							'name' => 'cued_depos_fir',
							'class' => 'form-control',
							'required title' => 'INGRESE SOLO NÚMEROS',
							'value' => $obtenercuentaune->cued_depos_fir
						);
					?>
					<?php
						$tra_monto_favor = array(
							'type'=>'text',
							'id'=>'valor5',
							'onkeyup'=>'sumar();',
							'style' => 'width: 150%',
							'class' => 'form-control disabe',
							'name'	=>	'tra_monto_favor',
							'value' => $obternertraspasoenflujoorigen->tra_monto
						);
					?>
					<?php
						$tra_monto_contra = array(
							'type'=>'text',
							'id'=>'valor6',
							'onkeyup'=>'sumar();',
							'style' => 'width: 150%',
							'class' => 'form-control disabe',
							'name'	=>	'tra_monto_contra',
							'value' => $obternertraspasoenflujodestino->tra_monto
						);
					?>
					<?php
						$cued_sald_fin = array(
							'id'=>'total',
							'type'=>'text',
							'style' => 'width: 150%',
							'class' => 'form-control disabe',
							'name'	=> 'cued_sald_fin',
							'value' => $totaldesaldo
						);
					?>
					<div class="col-md-4">
						<?= form_label('SALDO INICIAL:','cued_sald_ini')?>
						<div class="input-group col-md-4">
							<div class="input-group-addon">$</div>
							<?=form_input($cued_sald_ini); ?>
						</div>
						<?=form_label('CHEQUES CIRCULACIÓN:','cued_cheq_circ')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon">$</div>
							<?=form_input($cued_cheq_circ); ?>
						</div>
						<?= form_label('PAGOS:','cued_pagos')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon">$</div>
							<?=form_input($cued_pagos); ?>
						</div>

						<?= form_label('DEPOSITOS EN FIRME:','cued_depos_fir')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon">$</div>
							<?=form_input($cued_depos_fir); ?>
						</div>

					</div>

					<div class="col-md-4">
						<?=form_label('TRASPASO A FAVOR:','tra_monto_favor')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon disabe">$</div>
							<?=form_input($tra_monto_favor); ?>
						</div>

						<?=form_label('TRASPASOS EN CONTRA:','tra_monto_contra')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon disabe">$</div>
							<?=form_input($tra_monto_contra); ?>
						</div>

						<?=form_label('SALDO FINAL DEL DIA:','cued_sald_fin')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon disabe">$</div>
							<?=form_input($cued_sald_fin); ?>
						</div>
					</div>
				</div>

				<div class="mdl-card__actions mdl-card--border col-md-12">
					<button type="submit" class="btn btn-success" tabindex="4">Actualizar</button>
					<a href="<?=base_url().'flujo' ?>" type="button" class="btn btn-default">Cancelar</a>
				</div>
			<?= form_close() ?>
		</div>
	</div>
</section>

<script type="text/javascript">
	$('form').attr('autocomplete', 'off');
</script>