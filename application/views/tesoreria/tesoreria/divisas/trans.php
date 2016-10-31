<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-section">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$title;?>
		</div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="col-sm-2">Nombre cuenta Origen</th>
					<th class="col-sm-2">Nombre cuenta Destino</th>
					<th class="col-sm-1">Institución</th>
					<th class="col-sm-1">Divisa</th>
					<th class="col-sm-1">Monto</th>
					<th class="col-sm-1">Tipo de Cambio</th>
					<th class="col-sm-2">Importe</th>
					<th class="col-sm-2">Acciónes</th>
				</tr>
			</thead>
			<tbody>
			<?php if ($trans) {?>
				<?php 
					foreach ($trans->result() as $tdv) { 

				$fecha = date('Ymd');
				$corigen = $tdv->bNombre_origen.' '.$tdv->cNombre_origen.' '.$tdv->cNumero_origen.' '.$tdv->cDescr_origen;
				$cdestino = $tdv->bNombre_destino.' '.$tdv->cNombre_destino.' '.$tdv->cNumero_destino.' '.$tdv->cDescr_destino;
				$conv = $tdv->tra_monto * $tdv->tra_tc;
				$urlid = $tdv->tCuenta_destino.$tdv->tCuenta_origen.$fecha;
					?>
				<tr>
					<td><?=$corigen;?></td>
					<td><?=$cdestino;?></td>
					<td><?=$tdv->institucion;?></td>
					<td><?=$tdv->tra_divisa;?></td>
					<td>$<?=number_format($tdv->tra_monto,2, '.',',');?></td>
					<td>$<?=number_format($tdv->tra_tc,4, '.',',');?></td>
					<td>$<?=number_format($conv,2, '.',',')?></td>
					<td>

						<button class="btn btn-default" data-toggle="modal" data-target="#editransdivisas<?=$urlid;?>">
							<i class="material-icons">mode_edit</i>
						</button>
						<button class="btn btn-danger" data-toggle="modal" data-target="#deletetransdivisas<?=$urlid;?>">
							<i class="material-icons ">delete_forever</i>
						</button>

					</td>
				</tr>
					<?php
						$tramonton = array(
							'type'=>'text',
							'style' => 'width: 150%',
							'class' => 'form-control',
							'name'	=> 'tramonton',
							'value' => number_format($tdv->tra_monto,2, '.',',')
						);
					?>

					<?php
						$tratcn = array(
							'type'=>'text',
							'style' => 'width: 150%',
							'class' => 'form-control',
							'name'	=> 'tratcn',
							'value' => number_format($tdv->tra_tc,4, '.',',') 
						);
					?>

				<div class="divisamodal">
					<div class="modal fade" id="editransdivisas<?=$urlid;?>" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title text-upper" id="myModalLabel">Modificar Transacción</h4>
								</div>
								<?=form_open("/divisas/editransdivisas");?>
									<div class="modal-body">
										<?=form_label('Monto:','tramonton')?>		
										<div class="input-group col-md-4">
											<div class="input-group-addon">$</div>
											<?=form_input($tramonton); ?>
										</div>
										<?=form_label('Tipo de cambio:','tratcn')?>		
										<div class="input-group col-md-4">
											<div class="input-group-addon">$</div>
											<?=form_input($tratcn); ?>
										</div>
										<div>
											<input type="hidden" name="origen" value="<?=$tdv->tCuenta_origen;?>">
											<input type="hidden" name="destino" value="<?=$tdv->tCuenta_destino;?>">
											<input type="hidden" name="saldoctaorigen" value="<?=$tdv->cdsaldo_origen;?>">
											<input type="hidden" name="saldoctadestino" value="<?=$tdv->cdsaldo_destino;?>">
											<input type="hidden" name="tramonto" value="<?=$tdv->tra_monto;?>">
											<input type="hidden" name="tratc" value="<?=$tdv->tra_tc;?>">
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-success">Aceptar</button>
										<button type="reset" class="btn btn-default" data-dismiss="modal" onclick="limtodo();">Cancelar</button>
									</div>
								<?=form_close();?>
							</div>
						</div>
					</div>
				</div>	

				<div class="divisamodal">
					<div class="modal fade" id="deletetransdivisas<?=$urlid;?>" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header errorht">
									<h4 class="modal-title text-upper" id="myModalLabel">Eliminar Transacción</h4>
								</div>
								<?=form_open("/divisas/deletedivisa");?>
									<div class="modal-body">
										<p>Esta seguro que desea eliminar esta transacción</p>
										<!-- Input ocultos -->
										<div>
											<input type="hidden" name="origen" value="<?=$tdv->tCuenta_origen;?>">
											<input type="hidden" name="destino" value="<?=$tdv->tCuenta_destino;?>">
											<input type="hidden" name="saldoctaorigen" value="<?=$tdv->cdsaldo_origen;?>">
											<input type="hidden" name="saldoctadestino" value="<?=$tdv->cdsaldo_destino;?>">
											<input type="hidden" name="tramonto" value="<?=$tdv->tra_monto;?>">
											<input type="hidden" name="tratc" value="<?=$tdv->tra_tc;?>">
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-danger">Aceptar</button>
										<button type="reset" class="btn btn-default" data-dismiss="modal" onclick="limtodo();">Cancelar</button>
									</div>
								<?=form_close();?>
							</div>
						</div>
					</div>
				</div>	

			<?php }	
				}else{
					echo "<div class='nodata'>NO HAY NINGUNA TRANSANCCIÓN</div>";
			}?>

			</tbody>
		</table>

		<div class="detalles">
			
			<div class="mdl-card__actions mdl-card--border">
				<a href="<?=base_url();?>divisas/" class="btn btn-primary">Realizar nueva transacción</a>
			</div>
		</div>

	</div>
</section>
<script type="text/javascript">
	function limtodo() {
		location.reload();
	}
</script>