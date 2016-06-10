<section class="vimifos-content mdl-layout__content">
	<section class="flujo ">
		<div class="panel panel-primary">
			<div class="panel-heading vimifos-section-title mdl-typography--display-1-color-contrast">
				<?=$title;?> </div>
			<div class="panel-body shadow">
				<div class="col-md-12 ">
					<?php if ($cuentasinv):?>
						<?php foreach ($cuentasinv->result() as $cuentasinv): ?>
				
							<article class="cta" id="cta<?=$cuentasinv->cued_id;?>">
								<div class="col-md-2">
									<label>
										<?=$cuentasinv->une_nombre;?>
										<?=$cuentasinv->ban_nombre;?> 
										<?=$cuentasinv->cue_numero;?> 
										<?=$cuentasinv->cue_descripcion;?>
									</label>
								</div>

								<div class="col-md-2">
									<div class="tasa">
										<label for="" class="bruta">Tasa Bruta:</label>
										<div class="tasab"><?=number_format($cuentasinv->cueinv_tasa_bruta,2, '.','.');?></div>
									</div>
									<div class="tasa">
										<label for="" class="neta">Tasa Neta:</label>
										<div class="tasan"><?=number_format($cuentasinv->cueinv_tasa_neta,2, '.','.');?></div>
									</div>
								</div>

								<div class="col-md-2">
									<div class="saldo">
										<label for="" class="inversion">Saldo Inversion:</label>
										<div class="saldoi"><?=number_format($cuentasinv->cueinv_sald_ini,2, ',','.');?></div>
									</div>
									<div class="saldo">
										<label for="" class="diario">Saldo diario:</label>
										<div class="saldod"><?=number_format($cuentasinv->cueinv_sald_fin,2, ',','.');?></div>
									</div>
								</div>

								<div class="col-md-2">
								
									<div class="rendimiento">
										<label class="rendimiento">Rendimiento:</label>
										<div class="redimiento"><?=number_format($cuentasinv->cueinv_int_gene,2, ',','.');?></div>
									</div>
									<div class="dias">
										<label class="dias">Dias de inversion:</label>
										<div class="dias"><?=$cuentasinv->cueinv_dias;?></div>
									</div>

								</div>

							</article>
						<hr>
						<?php endforeach; ?>	
					<?php else: ?>
						<div class='nodata'>NO HAY DATOS</div>
					<?php endif;?>
				</div>
			</div>
		</div>
	</section>
</section>
				