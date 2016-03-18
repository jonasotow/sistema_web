<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-section box">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$title;?>
		</div>
			<div class="form-group shadow ">        
				<div class="cambiotipo">
				<table class="table table-hover"> 
					<thead>
						<tr> 
							<th>FECHAS</th> 
							<th>INSTITUCIÓN</th>
							<th>COMPRA</th> 
							<th>VENTA</th> 
							<th>HORA</th> 
							<th>DESCRIPCIÓN</th> 
						</tr> 
					</thead> 
					<tbody>
					<?php
						if ($displaytipo) {
						foreach ($displaytipo as $displaytipo) { ?> 
						<tr> 
							<th scope="row"><?=$displaytipo->tcd_fecha;?></th> 
							<td><?=$displaytipo->tc_institucion;?></td>
							<th class="moneda"><?=($displaytipo->tcd_tc_compra);?></th> 
							<th class="moneda"><?=($displaytipo->tcd_tc_venta);?></th> 
							<td><?=$displaytipo->tcd_hora;?></td> 
							<td><?=$displaytipo->tcd_descripcion;?></td> 
						</tr> 
					<?php } 
					}else{
						echo "<div class='nodata'>Aún no se captura el tipo de cambio.</div>";
					}?>
					</tbody> 
				</table>
			</div>
		</div>
	</div>	
</section>


