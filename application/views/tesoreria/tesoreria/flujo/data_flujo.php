<?php
	$id_une = $une->result()[0]->une_id; 
?>
<section class="vimifos-content mdl-layout__content">
	<section class="flujo ">
		<div class="panel panel-primary">
			<div class="panel-heading vimifos-section-title mdl-typography--display-1-color-contrast"><?=$title;?> DE <?=$une->result()[0]->une_nombre; ?> EN <?=$divisa;?> </div>
			<div class="panel-body shadow">
				<div class="col-md-12 ">
					<div class="form-group">
						<div class="panel panel-default">
							<table class="table ">
								<thead>
									<tr>
										<th>Cuenta</th>
										<th>Saldo Inicial</th>
										<th>Cheques Circulación</th>
										<th>Saldo de Operación</th>
										<th>Cheques</th>
										<th>PAGOS DE LINEA</th>
										<th>SALDO ANTES DE DEPOSITOS</th>
										<th>DEPOSITOS EN FIRME</th>
										<th>DEPOSITOS 24 HRS</th>
										<th>SALDO ANTES DE TRASPASOS</th>
										<th>TRASPASO</th>
										<th>SALDO FINAL DEL DIA</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if ($movcuebanune) {
								foreach ($movcuebanune->result() as $movcuebanune) { ?>
									<tr>
										<td> 
											<a href="<?=base_url().'flujo/editarflujo'?>/<?= $movcuebanune->cued_id; ?>"><?=$movcuebanune->ban_nombre; ?>-<?= $movcuebanune->cue_numero;?>
											</a>
										</td>
										<td class="saldo" width="10%"><?=number_format($movcuebanune->cued_sald_ini);?></td>
										<td class="saldo"><?=number_format($movcuebanune->cued_cheq_circ);?></td>
										<td class="saldo">
											<?php $saldoopera = $movcuebanune->cued_sald_ini - $movcuebanune->cued_cheq_circ?>
											<?=number_format($saldoopera);?>
										</td>
										<td class="saldo"><?=number_format($movcuebanune->cued_cheques);?></td>
										<td class="saldo"><?=number_format($movcuebanune->cued_pagos_lin);?></td>
										<td class="saldo">
											<?php $saldoandep = $saldoopera - $movcuebanune->cued_cheques - $movcuebanune->cued_pagos_lin ?>
											<?=number_format($saldoandep);?>
										</td>
										<td class="saldo"><?=number_format($movcuebanune->cued_depos_fir);?></td>
										<td class="saldo"><?=number_format($movcuebanune->cued_depos_24h);?></td>
										<td class="saldo">											
											<?php $saldoantras = $saldoandep + $movcuebanune->cued_depos_fir + $movcuebanune->cued_depos_24h ?>
											<?=number_format($saldoantras);?>
										</td>
										<td class="saldo"><?=number_format($movcuebanune->tra_monto);?></td>
										<td class="saldo"><?=number_format($movcuebanune->cued_sald_fin);?>
										</td>
										<td>
											<button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored " data-toggle="modal" data-target="#traspaso<?=$movcuebanune->cued_id?>"><i class="material-icons">add</i></button>
										</td>
									</tr>

									<div class="flujomodal">
										<div class="modal fade" id="traspaso<?=$movcuebanune->cued_id;?>" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														
														<h4 class="modal-title text-upper" id="myModalLabel">Traspaso a la fecha <?=date('Y-m-d')?></h4>
													</div>
													<?=form_open("/flujo/addtranspaso/") ?>
														<div class="modal-body">

															<div class="form-group">
																<label for="tra_cue_orig_id" class="control-label right col-xs-2">Cuenta Origen:</label>
																<input value="<?=$movcuebanune->cued_id;?>" name="tra_cue_orig_id" class="form-control disabe" type="hidden" required="">
																<label class="col-xs-5 left control-label">
																	<?=$movcuebanune->ban_nombre;?> - <?=$movcuebanune->cue_nombre;?> <?=$movcuebanune->cue_numero;?> - <?=$movcuebanune->cue_divisa;?>: $<?=number_format($movcuebanune->cued_sald_fin);?>
																	<input value="<?=$movcuebanune->cued_sald_fin;?>" name="saldoori" type="hidden" >
																</label>																	
															</div>

															<div class="form-group">
																<label for="datos_destino" class="control-label right col-xs-2">Cuenta Destino:</label>
																<div class="col-xs-7">
																	<select name="datos_destino" style="width:100%" class="form-control left" required="">
																		<option value> -- Seleccione una Cuenta -- </option>
																<?php
																	foreach ($obtenertodo as $bancos) { ?>
																		<option value="<?=$bancos->cued_id;?>|<?=$bancos->cued_sald_fin;?>|<?=$bancos->cue_divisa;?>|<?=$id_une;?>">
																			<?=$bancos->ban_nombre;?> - <?=$bancos->cue_nombre;?> <?=$bancos->cue_numero;?> - 
																			<?=$bancos->cue_divisa;?>: $<?=number_format($bancos->cued_sald_fin);?> 
																		</option>
																	
																<?php } ?>

																	</select>
																</div>
															</div>

															<?php
																$tra_monto = array(
																	'name'=>'tra_monto', 
																	'placeholder' => 'Importe ',
																	'class' => 'form-control',
																	'type'=>'text',
																	'pattern'=>'[0-9]{0,11}',
																	'required title' => 'SOLO NÚMEROS DE 4 A 11 CARACTERES',
																);
															?>
															<?php
																$tra_descripcion = array(
																	'required'=>'', 'style'=>'width:100%', 'class'=>'form-control', 
																	'name'=>'tra_descripcion', 
																);
															?>
															<div class="form-group">
																<label class="control-label right col-xs-2">Importe:</label>
																<div class="input-group left col-xs-3">
																	<div class="input-group-addon">$</div>
																	<?=form_input($tra_monto) ?>
																</div>
																<label class="control-label right col-xs-2">Movimiento:</label>
																<div class="col-xs-3">
																	<select name="tra_descripcion" class="form-control left" required="">
																		<option value> -- Tipo de movimiento  -- </option>
																		<option value="SPEI">SPEI</option>
																		<option value="TRASPASO">TRASPASO</option>
																		<option value="CHEQUE">CHEQUE</option>
																		<option value="CORREO">CORREO</option>
																		<option value="TELEFONICO">TELEFONICO</option>
																	</select>
																</div>
															</div>
														</div><!-- modal-body -->
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
															<button type="submit" class="btn btn-success">Capturar</button>
														</div>
													<?= form_close() ?>
												</div><!-- modal-content -->
											</div><!-- modal-dialog -->
										</div><!-- modal -->
									</div>


									<?php } 
									}else{
									echo'
										
										Uy tenemos un error
									';											 
									}?>

									<?php

											foreach ($saldototalune_trapaso as $saldototalune_trapaso) { 
											$saldotraspasoune = $saldototalune_trapaso->tra_monto;
									}?>

									


									<?php
										foreach ($saldototalune as $saldoune) { ?>
									<tr class="total">
										<td >Total:</td>
										<td class="saldo"><?=number_format($saldoune->cued_sald_ini);?></td>
										<td class="saldo"><?=number_format($saldoune->cued_cheq_circ);?></td>
										<td class="saldo"><?php $saldoopera_total = $saldoune->cued_sald_ini - $saldoune->cued_cheq_circ?>
											<?=number_format($saldoopera_total);?></td>
										<td class="saldo"><?=number_format($saldoune->cued_cheques);?></td>
										<td class="saldo"><?=number_format($saldoune->cued_pagos_lin);?></td>
										<td class="saldo"><?php $saldoandep_total = $saldoopera - $saldoune->cued_cheques - $saldoune->cued_pagos_lin ?>
											<?=number_format($saldoandep_total);?></td>
										<td class="saldo"><?=number_format($saldoune->cued_depos_fir);?></td>
										<td class="saldo"><?=number_format($saldoune->cued_depos_24h);?></td>
										<td class="saldo"><?php $saldoantras_total = $saldoandep + $saldoune->cued_depos_fir + $saldoune->cued_depos_24h ?>
											<?=number_format($saldoantras_total);?></td>
										<td class="saldo"><?=number_format($saldotraspasoune);?></td>
										<td class="saldo"><?=number_format($saldoune->cued_sald_fin);?></td>
									</tr>
									<?php }
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>