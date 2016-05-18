<section class="vimifos-content mdl-layout__content">
	<section class="flujo ">
		<div class="panel panel-primary">
			<div class="panel-heading vimifos-section-title mdl-typography--display-1-color-contrast">
				<?=$title;?> </div>
			<div class="panel-body shadow">
				<div class="col-md-12 ">
					<?php if ($cuentasinv):?>
						<?php foreach ($cuentasinv->result() as $cuentasinv): ?>

							<?php
								$saldoi = $cuentasinv->cueinv_sald_ini; 
								$saldod = $cuentasinv->cueinv_sald_fin; 

								$rendi = $saldod - $saldoi;
								$tasan = ($rendi / $saldoi * 360) * 100;
								$tasab = ($rendi / $saldoi * 360 + 0.006) * 100;
							?>
						
							<article class="cta">
								<div class="col-md-2">
									<label>
										<?=$cuentasinv->ban_nombre;?> 
										<?=$cuentasinv->cue_numero;?> 
										<?=$cuentasinv->cue_descripcion;?>
									</label>
								</div>

								<div class="col-md-2">
									<div class="tasa">
										<label for="" class="bruta">Tasa Bruta:</label>
										<div class="tasab"><?=number_format($tasab,2, '.','.');?></div>
									</div>
									<div class="tasa">
										<label for="" class="neta">Tasa Neta:</label>
										<div class="tasan"><?=number_format($tasan,2, '.','.');?></div>
									</div>
								</div>

								<div class="col-md-2">
									<div class="saldo">
										<label for="" class="inversion">Saldo Inversion:</label>
										<div class="saldoi"><?=number_format($saldoi,2, ',','.');?></div>
									</div>
									<div class="saldo">
										<label for="" class="diario">Saldo diario:</label>
										<div class="saldod"><?=number_format($saldod,2, ',','.');?></div>
									</div>
								</div>

								<div class="col-md-2">
								
									<div class="rendimiento">
										<label class="rendimiento">Rendimiento:</label>
										<div class="redimiento"><?=number_format($rendi,2, ',','.');?></div>
									</div>
									<div class="dias">
										<label class="dias">Dias de inversion:</label>
										<input type="text">
									</div>

								</div>


								<div class="col-md-2">
									<div class="traspaso">
										<label for="" class="salida">Traspaso Salida:</label>
										<div class="saldoi">1000</div>
									</div>
									<div class="traspaso">
										<label for="" class="entrada">Traspaso Entrada:</label>
										<div class="saldoi">1000</div>
									</div>

								</div>

								<div class="col-md-2">
									<div class="otro">
										<label for="" class="cargos">Otros Cargos:</label>
										<div class="saldoi">1000</div>
									</div>
									<div class="otro">
										<label for="" class="abonos">Otros Abonos:</label>
										<div class="saldoi">1000</div>
									</div>

								</div>							
							</article>
							

						<?php endforeach; ?>	
					<?php else: ?>
						<div class='nodata'>NO HAY DATOS</div>
					<?php endif;?>
				</div>
			</div>
		</div>
	</section>
</section>
				