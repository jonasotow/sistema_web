<section class="vimifos-content mdl-layout__content">
	<section class="flujo">
		<div class="panel panel-primary">
			<div class="panel-heading vimifos-section-title mdl-typography--display-1-color-contrast">
				<?=$title;?> 
			</div>
			<div class="panel-body shadow">
				<div class="col-md-12 ">

				<?=form_open("/inversion/saldoant/") ?>

					<?php
						$cueinv_sald_fin = array(
							'type'=>'text', 'id'=>'valor1', 'tabindex'=>'1', 'onkeyup'=>'sumar();', 'style' => 'width: 150%', 'name' => 'cueinv_sald_fin',
							'class' => 'form-control','required title' => 'INGRESE SOLO NÚMEROS',
						);
						$cueinv_dias = array(
							'type'=>'text', 'id'=>'valor1', 'tabindex'=>'1', 'onkeyup'=>'sumar();', 'style' => 'width: 150%', 'name' => 'cueinv_dias',
							'class' => 'form-control','required title' => 'INGRESE SOLO NÚMEROS', 'value' => '1'
						);
					?>

					<article class="ctainvc">
						<div class="col-md-5">
							<label for="ctainv">Nuevo Saldo:</label>
							<select name="ctainv" id="ctainv" style="width:100%" class="form-control left" required="">
								<option value> -- Seleccione una Cuenta -- </option>
							
							<?php foreach ($ctainversion->result() as $ctainversion): ?>
								<option value="<?=$ctainversion->cueinv_id;?>|<?=number_format($ctainversion->cued_sald_fin,2, '.',',');?>|<?=$ctainversion->cued_sald_fin;?>">
									<?=$ctainversion->une_nombre;?> <?=$ctainversion->ban_nombre;?> #<?=$ctainversion->cue_numero;?> 
								</option>
							<?php endforeach; ?>	
							</select>	
						</div>

						<div class="col-md-2">
							<div>
								<label>Saldo Anterior:</label>
								<div class="saldoantinv">
									<span id="saldoantinv">-</span>
									<input type="hidden" name="saldoantinv" id="saldoantinv">
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<label class="bruta">Nuevo Saldo:</label>
							<div class="input-group col-md-6">
								<div class="input-group-addon">$</div>
								<?=form_input($cueinv_sald_fin);?>
							</div>
						</div>
						<div class="col-md-2">
							<label class="bruta">Dia de inversión:</label>
							<div class="input-group col-md-3">
								<?=form_input($cueinv_dias);?>
							</div>
						</div>
					</article>
					<article class="button">
						<div class="col-md-2">
							<button type="reset" class="btn btn-default">Cancelar</button>
							<button type="submit" class="btn btn-success">Guardar</button>
						</div>
					</article>
					
				<?= form_close() ?>
						
				</div>
			</div>
		</div>
	</section>
</section>

<script type="text/javascript">	
	$(document).ready(function() {
		$("#ctainv").change(function() {
			$("#ctainv option:selected").each(function() {

				var s = document.getElementById("ctainv").value;
				var z = s.split('|');
				document.getElementById("saldoantinv").innerHTML = "$ " + z[1];
				document.getElementById("saldoantinv").value = "$ " + z[1];

			});
		})
	});
</script>	