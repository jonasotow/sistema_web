<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-section box">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$title;?>
		</div>
		<div class="form-group shadow ">        

			<table class="table table-hover"> 
				<thead>
					<tr> 
						<th>UNIDAD DE NEGOCIOS</th> 
						<th>DIVISA</th>
						<th>Saldo Inicial</th>
						<th>Cheques Circulación</th>
						<th>Saldo de Operación</th>
						<th>Cheques</th>
						<th>PAGOS DE LINEA</th>
						<th>SALDO ANTES DE DEPOSITOS</th>
						<th>DEPOSITOS EN FIRME</th>
						<th>DEPOSITOS 24 HRS</th>
						<th>TRASPASO</th>
						<th>SALDO FINAL DEL DIA</th> 
					</tr> 
				</thead> 
				<tbody>
				<?php
					if ($saldosunes) {
					foreach ($saldosunes as $saldosunes) { ?> 
						<?php 
							$saldoopera = $saldosunes->cued_sald_ini - $saldosunes->cued_cheq_circ;
							$saldoandep = $saldoopera - $saldosunes->cued_cheques - $saldosunes->cued_pagos_lin;?>

					<tr> 
						<th scope="row"><?=$saldosunes->une_nombre;?> <?=$saldosunes->cue_descripcion;?> </th> 
						<td><?=$saldosunes->cue_divisa;?></td>
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_cheq_circ);?></td> 
						<td class="moneda"><?=number_format($saldoopera);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_cheques);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_pagos_lin);?></td> 
						<td class="moneda"><?=number_format($saldoandep);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_depos_fir);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_depos_24h);?></td> 
						<td class="moneda"><?=number_format($saldosunes->tra_monto);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_sald_fin);?></td> 
 
					</tr> 
				<?php } 
				}else{
					echo "<div class='nodata'>NO HAY INFORMACION DE ESA FECHA</div>";
				}?>
				</tbody> 
			</table>
		</div>
	</div>
</section>


