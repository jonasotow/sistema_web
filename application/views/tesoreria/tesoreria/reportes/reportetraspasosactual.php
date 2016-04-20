<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-section box">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$title;?>
		</div>
		<div class="form-group shadow ">        

			<table class="table table-hover"> 
				<thead>
					<tr> 
						<th>FECHAS</th> 
						<th>UNIDAD DE NEGOCIOS</th>
						<th>CUENTA ORIGEN</th> 
						<th>CUENTA DESTINO</th> 
						<th>DIVISA</th> 
						<th>MONTO</th> 
						<th>MOVIMIENTO</th> 
						<th>OPERADO</th> 
					</tr> 
				</thead> 
				<tbody>
				<?php
					if ($reportetrapasos) {
					foreach ($reportetrapasos as $reportetrapasos) { ?> 
					<tr> 
						<th scope="row"><?=$reportetrapasos->tra_fecha;?></th> 
						<td><?=$reportetrapasos->une_nombre;?> <?=$reportetrapasos->T1CD;?></td>
						<td><?=$reportetrapasos->T1C;?> <?=$reportetrapasos->T1N;?></td> 
						<td><?=$reportetrapasos->T2C;?> <?=$reportetrapasos->T2N;?></td> 
						<td><?=$reportetrapasos->divisa;?></td> 
						<th class="moneda"><?=number_format($reportetrapasos->tra_monto);?></th> 
						<td><?=$reportetrapasos->tra_descripcion;?></td> 
						<td><?=$reportetrapasos->tra_responsable;?></td> 
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


