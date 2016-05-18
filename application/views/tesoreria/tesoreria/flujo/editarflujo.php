 <section class="vimifos-content mdl-layout__content">
	<div class="panel panel-primary">
		<div class="panel-heading vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$title;?> | <?=$obtenercuentaune->une_nombre;?> <?=$obtenercuentaune->cue_descripcion;?> - <?=$obtenercuentaune->cue_divisa;?> - <?=$obtenercuentaune->ban_nombre;?> <?=$obtenercuentaune->cue_numero;?> 
		</div>
		<div class="panel-body shadow">
			<?=form_open("/flujo/updateFlujo/".$id) ?>

			<input type="hidden" name="datoscuenta" value="<?=$obtenercuentaune->une_nombre;?> <?=$obtenercuentaune->cue_descripcion;?> <?=$obtenercuentaune->cue_divisa;?> <?=$obtenercuentaune->ban_nombre;?> <?=$obtenercuentaune->cue_numero;?>">
			<input value="<?=$usuario;?>" name="usuario" type="hidden">
			<input type="hidden" name="cuentaretorn" value="<?=$obtenercuentaune->une_id;?>|<?=$obtenercuentaune->cue_divisa;?>">



			<div class="form">
				<?php
					$sumaentradas = $obtenercuentaune->cued_sald_ini + $obtenercuentaune->cued_depos_fir + $obtenercuentaune->cued_depos_24h; 
					$restaflujo = $obtenercuentaune->cued_cheq_circ + $obtenercuentaune->cued_cheques + $obtenercuentaune->cued_pagos_lin;
					$totaldesaldo = $obtenercuentaune->cued_sald_fin;
				?>	
					<?php
						$cued_sald_ini = array(
							'type'=>'text',
							'id'=>'valor1',
							'tabindex'=>'1',
							'onkeyup'=>'sumar();',
							'pattern'=>'[0-9]{1,}',
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
							'id'=>'valor5',
							'tabindex'=>'2',
							'onkeyup'=>'sumar();',
							'pattern'=>'[0-9]{1,}',
							'style' => 'width: 150%',
							'class' => 'form-control',
							'name'	=>	'cued_cheq_circ',
							'required title' => 'INGRESE SOLO NÚMEROS',
							'value' => $obtenercuentaune->cued_cheq_circ 
						);
					?>
					<?php
						$cued_cheques = array(
							'type'=>'text',
							'id'=>'valor4',
							'tabindex'=>'3',
							'onkeyup'=>'sumar();',
							'pattern'=>'[0-9]{1,}',
							'style' => 'width: 150%',
							'name' => 'cued_cheques',
							'class' => 'form-control',
							'required title' => 'INGRESE SOLO NÚMEROS',
							'value' => $obtenercuentaune->cued_cheques 
						);
					?>
					<?php
						$cued_pagos_lin = array(
							'type'=>'text',
							'id'=>'valor6',
							'tabindex'=>'4',
							'onkeyup'=>'sumar();',
							'pattern'=>'[0-9]{1,}',
							'style' => 'width: 150%',
							'class' => 'form-control',
							'name'	=>	'cued_pagos_lin',
							'required title' => 'INGRESE SOLO NÚMEROS',
							'value' => $obtenercuentaune->cued_pagos_lin 
						);
					?>
					<?php
						$cued_depos_fir = array(
							'type'=>'text',
							'id'=>'valor2',
							'tabindex'=>'5',
							'onkeyup'=>'sumar();',
							'pattern'=>'[0-9]{1,}',
							'style' => 'width: 150%',
							'name' => 'cued_depos_fir',
							'class' => 'form-control',
							'required title' => 'INGRESE SOLO NÚMEROS',
							'value' => $obtenercuentaune->cued_depos_fir 
						);
					?>
					<?php
						$cued_depos_24h = array(
							'type'=>'text',
							'id'=>'valor3',
							'tabindex'=>'6',
							'onkeyup'=>'sumar();',
							'pattern'=>'[0-9]{1,}',
							'style' => 'width: 150%',
							'name' => 'cued_depos_24h',
							'class' => 'form-control',
							'required title' => 'INGRESE SOLO NÚMEROS',
							'value' => $obtenercuentaune->cued_depos_24h 
						);
					?>
					<?php
						$tra_monto_favor = array(
							'type'=>'text',
							'id'=>'valor7',
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
							'id'=>'valor8',
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
							'name'	=>	'cued_sald_fin',
							'value' => $totaldesaldo
						);
					?>
					<div class="col-md-4">
						<?= form_label('SALDO INICIAL:','cued_sald_ini')?>
						<div class="input-group col-md-4">
							<div class="input-group-addon">$</div>
							<?=form_input($cued_sald_ini); ?>
						</div>
						<?= form_label('CHEQUES CIRCULACIÓN:','cued_cheq_circ')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon">$</div>
							<?=form_input($cued_cheq_circ); ?>
						</div>
						<?= form_label('CHEQUES:','cued_cheques')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon">$</div>
							<?=form_input($cued_cheques); ?>
						</div>
						<?= form_label('PAGOS DE LINEA:','cued_pagos_lin')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon">$</div>
							<?=form_input($cued_pagos_lin); ?>
						</div>
						<?= form_label('DEPOSITOS EN FIRME:','cued_depos_fir')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon">$</div>
							<?=form_input($cued_depos_fir); ?>
						</div>
						<?= form_label('DEPOSITOS 24 HRS:','cued_depos_24h')?>		
						<div class="input-group col-md-4">
							<div class="input-group-addon">$</div>
							<?=form_input($cued_depos_24h); ?>
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
					<button type="submit" class="btn btn-success" tabindex="7">Actualizar</button>
					<a href="<?=base_url().'flujo' ?>" type="button" class="btn btn-default">Cancelar</a>
				</div>
			<?= form_close() ?>
		</div>
	</div>
</section>

<script type="text/javascript">
	$('form').attr('autocomplete', 'off');
</script>