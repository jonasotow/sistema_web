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
					<tr> 
						<th scope="row"><?=$saldosunes->une_nombre;?></th> 
						<td><?=$saldosunes->cue_divisa;?></td>
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
						<td class="moneda"><?=number_format($saldosunes->cued_sald_ini);?></td> 
 
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


