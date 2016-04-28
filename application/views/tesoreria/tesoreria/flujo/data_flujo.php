<?php
	$id_une = $une->une_id; 
?>

<section class="vimifos-content mdl-layout__content">
	<section class="flujo ">
		<div class="panel panel-primary">
			<div class="panel-heading vimifos-section-title mdl-typography--display-1-color-contrast">
				<?=$title;?> DE <?=$une->une_nombre;?> EN <?=$divisa;?> </div>
			<div class="panel-body shadow">
				<div class="col-md-12 ">
					<div class="form-group">
					<?php if ($movcuebanune) {?>
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
										<th></th>
									</tr>
								</thead>
								<tbody>
								
								<?php 
								foreach ($movcuebanune->result() as $movcuebanune) { ?>
	
								<?php 
									$saldoopera = $movcuebanune->cued_sald_ini - $movcuebanune->cued_cheq_circ;
									$saldoandep = $saldoopera - $movcuebanune->cued_cheques - $movcuebanune->cued_pagos_lin;
									$saldoantras = $saldoandep + $movcuebanune->cued_depos_fir + $movcuebanune->cued_depos_24h;?>


								<?php if ($movcuebanune->cued_sald_ini <= 0) { $cued_sald_ini = "zero"; } else { $cued_sald_ini = "saldo";}?>
								<?php if ($movcuebanune->cued_cheq_circ <= 0) { $cued_cheq_circ = "zero"; } else { $cued_cheq_circ = "saldo";}?>
								<?php if ($saldoopera <= 0) { $saldoopera_css = "zero"; } else { $saldoopera_css = "saldo";}?>
								<?php if ($movcuebanune->cued_cheques <= 0) { $cued_cheques = "zero"; } else { $cued_cheques = "saldo";}?>
								<?php if ($movcuebanune->cued_pagos_lin <= 0) { $cued_pagos_lin = "zero"; } else { $cued_pagos_lin = "saldo";}?>
								<?php if ($movcuebanune->cued_cheq_circ <= 0) { $cued_cheq_circ = "zero"; } else { $cued_cheq_circ = "saldo";}?>
								<?php if ($saldoandep <= 0) { $saldoandep_css = "zero"; } else { $saldoandep_css = "saldo";}?>
								<?php if ($movcuebanune->cued_depos_fir <= 0) { $cued_depos_fir = "zero"; } else { $cued_depos_fir = "saldo";}?>
								<?php if ($movcuebanune->cued_depos_24h <= 0) { $cued_depos_24h = "zero"; } else { $cued_depos_24h = "saldo";}?>
								<?php if ($saldoantras <= 0) { $saldoantras_css = "zero"; } else { $saldoantras_css = "saldo";}?>
								<?php if ($movcuebanune->tra_monto <= 0) { $tra_monto = "zero"; } else { $tra_monto = "saldo";}?>						
								<?php if ($movcuebanune->cued_sald_fin <= 0) { $cued_sald_fin = "zero"; } else { $cued_sald_fin = "saldo";}?>

									<tr>
										<td> 
											<a href="<?=base_url().'flujo/editarflujo'?>/<?= $movcuebanune->cued_id;?>">
												<?=$movcuebanune->ban_nombre; ?>  - <?=$movcuebanune->cue_numero;?> <?=$movcuebanune->cue_descripcion;?>
											</a>
										</td>
										<td class="<?=$cued_sald_ini;?>"><?=number_format($movcuebanune->cued_sald_ini);?></td>
										<td class="<?=$cued_cheq_circ;?>"><?=number_format($movcuebanune->cued_cheq_circ);?></td>
										<td class="<?=$saldoopera_css;?>"><?=number_format($saldoopera);?></td>
										<td class="<?=$cued_cheques;?>"><?=number_format($movcuebanune->cued_cheques);?></td>
										<td class="<?=$cued_pagos_lin;?>"><?=number_format($movcuebanune->cued_pagos_lin);?></td>
										<td class="<?=$saldoandep_css;?>"><?=number_format($saldoandep);?></td>
										<td class="<?=$cued_depos_fir;?>"><?=number_format($movcuebanune->cued_depos_fir);?></td>
										<td class="<?=$cued_depos_24h;?>"><?=number_format($movcuebanune->cued_depos_24h);?></td>
										<td class="<?=$saldoantras_css;?>"><?=number_format($saldoantras);?></td>
										<td class="<?=$tra_monto;?>"><?=number_format($movcuebanune->tra_monto);?></td>
										<td class="<?=$cued_sald_fin;?> info"><?=number_format($movcuebanune->cued_sald_fin);?></td>
										<td>
											
											<button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored " data-toggle="modal" data-target="#pagovim<?=$movcuebanune->cued_id?>"><i class="material-icons">add</i></button>

										</td>
										<td>
											
											<button type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored " data-toggle="modal" data-target="#traspaso<?=$movcuebanune->cued_id?>"><i class="material-icons">add</i></button>

										</td>
									</tr>

						
								<?php
									if ($movcuebanune->cued_sald_fin > 0) { ?>

									<div class="flujomodal">
										<div class="modal fade" id="pagovim<?=$movcuebanune->cued_id;?>" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title text-upper" id="myModalLabel">Pagos entre Vimifos</h4>
													</div>
													<?=form_open("/flujo/addpagovim/") ?>
														<div class="modal-body" id="clear">
															<div class="form-group">
																<label for="tra_cue_orig_id" class="control-label right col-xs-2">Cuenta Origen:</label>
																<label class="col-xs-5 left control-label">
																	<?=$movcuebanune->ban_nombre;?> - 
																	<?=$movcuebanune->cue_nombre;?> 
																	<?=$movcuebanune->cue_numero;?> - 
																	<?=$movcuebanune->cue_divisa;?>: 
																	$<?=number_format($movcuebanune->cued_sald_fin);?>
																</label>
																<input type="hidden" name="divisa" value="<?=$movcuebanune->cue_divisa;?>">
																<input type="hidden" name="uneid" value="<?=$id_une;?>">
																<input value="<?=$movcuebanune->cued_id;?>" name="idorigen" id="<?=$movcuebanune->cued_id;?>" type="hidden">
													
															</div>
													
															<div class="form-group">
																<label for="unenego" class="control-label right col-xs-2">Unidad de Negocio:</label>
																<div class="col-xs-7">
																	<select name="unenego" id="unenego<?=$movcuebanune->cued_id;?>" style="width:50%" class="form-control left" required="" onclick="Ldivpag();" >
																		<option value> -- Seleccione una unidad -- </option>
																	<?php
																		foreach ($todo as $t) { ?>
																		<option value="<?=$t->une_id;?>"><?=$t->une_nombre;?></option>
																	<?php } ?>
																	</select>
																</div>
															</div>

															<div class="form-group" id="cleard">
																<label for="cue_divisa" class="control-label right col-xs-2">Divisa:</label>
																<div class="col-xs-7">
																	<select name="cue_divisa" id="cuedivisa<?=$movcuebanune->cued_id;?>" style="width:50%" class="form-control left" required="">
																		<option value> -- Seleccione Divisa -- </option>
																		<option value="USD">USD</option>
																		<option value="MXN">MXN</option>
																		<option value="EUR">EUR</option>
																	</select>
																</div>
															</div>
															<div class="form-group" id="cleard">
																<label for="mcpagovim" class="control-label right col-xs-2">Cuenta a pagar:</label>
																<div class="col-xs-7">
																	<select style="width:80%" class="form-control left" name="mcpagovim" id="mcpagovim<?=$movcuebanune->cued_id;?>">
																	</select>
																</div>
															</div>
															<?php
																$pagointvim = array(
																	'name'=>'pagointvim', 
																	'placeholder' => 'Importe ',
																	'class' => 'form-control',
																	'type'=>'text',
																	'pattern'=>'[0-9]{0,11}',
																	'required title' => 'SOLO NÚMEROS DE 4 A 11 CARACTERES',
																);
															?>
															<div class="form-group">
																<label class="control-label right col-xs-2">Importe:</label>
																<div class="input-group left col-xs-3">
																	<div class="input-group-addon">$</div>
																	<?=form_input($pagointvim) ?>
																</div>
														
														</div><!-- modal-body -->
														<div class="modal-footer">
															<button type="reset" class="btn btn-default" data-dismiss="modal" onclick="limtodo();">Cancelar</button>
															<button type="submit" class="btn btn-success">Capturar</button>
														</div>
													<?=form_close() ?>
												</div><!-- modal-content -->
											</div><!-- modal-dialog -->

											<script type="text/javascript">	
												var path = '<?=base_url()?>index.php/';
												$(document).ready(function() {
													$("#unenego<?=$movcuebanune->cued_id;?>").change(function() {
														$("#unenego<?=$movcuebanune->cued_id;?> option:selected" ).each(function() {
															$("#cuedivisa<?=$movcuebanune->cued_id;?>").change(function() {
																$("#cuedivisa<?=$movcuebanune->cued_id;?> option:selected" ).each(function() {

															var div =$('#cuedivisa<?=$movcuebanune->cued_id;?>').val();
															var idune =$('#unenego<?=$movcuebanune->cued_id;?>').val();
												    	
															$.post(path + 'flujo/mcpagovim', { 
																divisa : div,
																idune : idune
															}, 
															function(resp) {
																$("#mcpagovim<?=$movcuebanune->cued_id;?>").html(resp);
																	});
																});
															});
														});
													})
												});

											</script>
											<script type="text/javascript">
												function limtodo() {
												var t = document.getElementById("clear").getElementsByTagName("select");
												for (var i=0; i<t.length; i++) {
												    t[i].value = "";
												    }
												}
											</script>
											<script type="text/javascript">
												function Ldivpag() {
												var t = document.getElementById("cleard").getElementsByTagName("select");
												for (var i=0; i<t.length; i++) {
												    t[i].value = "";
												    }
												}
											</script>


										</div><!-- modal -->
									</div>
						
 									
					<!-- Traspaso -->

									<div class="flujomodal">
										<div class="modal fade" id="traspaso<?=$movcuebanune->cued_id;?>" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title text-upper" id="myModalLabel">Traspaso entre cuentas</h4>
													</div>
													<?=form_open("/flujo/addtranspaso/") ?>
														<div class="modal-body">
															<div class="form-group">
																<label for="tra_cue_orig_id" class="control-label right col-xs-2">Cuenta Origen:</label>
																<input value="<?=$movcuebanune->cued_id;?>" name="tra_cue_orig_id" id="<?=$movcuebanune->cued_id;?>" type="hidden">
																<label class="col-xs-5 left control-label">
																	<?=$movcuebanune->ban_nombre;?> - <?=$movcuebanune->cue_nombre;?> <?=$movcuebanune->cue_numero;?> - <?=$movcuebanune->cue_divisa;?>: $<?=number_format($movcuebanune->cued_sald_fin);?>
																</label>																	
																<input value="<?=$movcuebanune->cued_sald_fin;?>" name="saldoori" type="hidden">
															</div>

															<div class="form-group">
																<label for="datos_destino" class="control-label right col-xs-2">Cuenta Destino:</label>
																<div class="col-xs-7">
																	<select name="datos_destino" id="datos_destino<?=$movcuebanune->cued_id;?>" style="width:100%" class="form-control left" required="">
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
															<div id="montodetrshtml<?=$movcuebanune->cued_id;?>">
																
															</div>
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
																		<option value="CHEQUE">CHEQUE</option>
																		<option value="CORREO">CORREO</option>
																		<option value="SPEI">PAGO INTERNACIONAL</option>
																		<option value="SPEI">SPEI</option>
																		<option value="TELEFONICO">TELEFONICO</option>
																		<option value="TRASPASO">TRASPASO</option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label right col-xs-2">Operado por:</label>
																<div class="col-xs-3">
																	<select name="tra_responsable" class="form-control left" required="">
																		<option value> -- Tipo de movimiento  -- </option>
																		<option value="TESORERIA CORPORATIVO">TESORERIA CORPORATIVO</option>
																		<option value="TESORERIA OCCIDENTE">TESORERIA OCCIDENTE</option>
																		<option value="TESORERIA NOROESTE">TESORERIA NOROESTE</option>
																	</select>
																</div>
															</div>


															<input value="" type="hidden" name="montoanterior" id="montodetrsval<?=$movcuebanune->cued_id;?>">


														</div><!-- modal-body -->
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
															<button type="submit" class="btn btn-success">Capturar</button>
														</div>
													<?=form_close() ?>
												</div><!-- modal-content -->
											</div><!-- modal-dialog -->
											<script type="text/javascript">	
												var path = '<?= base_url()?>index.php/';

												$(document).ready(function() {
													$("#datos_destino<?=$movcuebanune->cued_id;?>").change(function() {
														$("#datos_destino<?=$movcuebanune->cued_id;?> option:selected").each(function() {


															var sof =$('#<?=$movcuebanune->cued_id;?>').val();
															var vim =$('#datos_destino<?=$movcuebanune->cued_id;?>').val();
												    		var arr = vim.split('|');

															$.post(path + 'flujo/montotraspaso', { 
																id_origen : sof,
																id_destino : arr[0]
															}, function(resp) {
																$("#montodetrshtml<?=$movcuebanune->cued_id;?>").html(resp);
															});
															$.post(path + 'flujo/montotraspasoval', { 
																id_origen : sof,
																id_destino : arr[0]
															}, function(resp) {
																$("#montodetrsval<?=$movcuebanune->cued_id;?>").val(resp);
															});
														});
													})
												});

											</script>
										</div><!-- modal -->
									</div>

								<?php }	
									else
								{?>
									<div class="flujomodal">
										<div class="modal fade" id="traspaso<?=$movcuebanune->cued_id;?>" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
											<div class="modal-dialog ">
												<div class="modal-content">
													<div class="modal-header errorht">
														<h4 class="modal-title text-upper" id="myModalLabel">Traspaso imposible</h4>
													</div>
														<div class="modal-body">
															
															<div class="errort">NO TIENES SALDO</div>
															
														</div><!-- modal-body -->
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
														</div>
												</div><!-- modal-content -->
											</div><!-- modal-dialog -->
										</div><!-- modal -->
									</div>
								<?php }
								?>
								<?php } 
									}else{ ?>
										<div class="fcriterio">No hay cuentas con este criterio</div>
								<?php }?>

								<?php
										foreach ($saldototalune_trapaso as $saldototalune_trapaso) { 

										$saldotraspasoune = $saldototalune_trapaso->tra_monto;
									}?>
									<?php if ($saldotraspasoune <= 0) { $saldotraspasoune_css = "zero"; } else { $saldotraspasoune_css = "saldo";}?>

									<?php
										foreach ($saldototalune as $saldoune) { ?>

											<?php 
												$saldoopera_total = $saldoune->cued_sald_ini - $saldoune->cued_cheq_circ;
												$saldoandep_total = $saldoopera_total - $saldoune->cued_cheques - $saldoune->cued_pagos_lin;
												$saldoantras_total = $saldoandep_total + $saldoune->cued_depos_fir + $saldoune->cued_depos_24h;?>

										<?php if ($saldoune->cued_sald_ini <= 0) { $cued_sald_ini = "zero"; } else { $cued_sald_ini = "saldo";}?>
										<?php if ($saldoune->cued_cheq_circ <= 0) { $cued_cheq_circ = "zero"; } else { $cued_cheq_circ = "saldo";}?>
										<?php if ($saldoopera_total <= 0) { $saldoopera_total_css = "zero"; } else { $saldoopera_total_css = "saldo";}?>
										<?php if ($saldoune->cued_cheques <= 0) { $cued_cheques = "zero"; } else { $cued_cheques = "saldo";}?>
										<?php if ($saldoune->cued_pagos_lin <= 0) { $cued_pagos_lin = "zero"; } else { $cued_pagos_lin = "saldo";}?>
										<?php if ($saldoune->cued_cheq_circ <= 0) { $cued_cheq_circ = "zero"; } else { $cued_cheq_circ = "saldo";}?>
										<?php if ($saldoandep_total <= 0) { $saldoandep_total_css = "zero"; } else { $saldoandep_total_css = "saldo";}?>
										<?php if ($saldoune->cued_depos_fir <= 0) { $cued_depos_fir = "zero"; } else { $cued_depos_fir = "saldo";}?>
										<?php if ($saldoune->cued_depos_24h <= 0) { $cued_depos_24h = "zero"; } else { $cued_depos_24h = "saldo";}?>
										<?php if ($saldoantras_total <= 0) { $saldoantras_total_css = "zero"; } else { $saldoantras_total_css = "saldo";}?>
										<?php if ($saldotraspasoune <= 0) { $saldotraspasoune_css = "zero"; } else { $saldotraspasoune_css = "saldo";}?>				
										<?php if ($saldoune->cued_sald_fin <= 0) { $cued_sald_fin = "zero"; } else { $cued_sald_fin = "saldo";}?>

									<tr class="total info">
										<td >Total:</td>
										<td class="<?=$cued_sald_ini;?>"><?=number_format($saldoune->cued_sald_ini);?></td>
										<td class="<?=$cued_cheq_circ;?>"><?=number_format($saldoune->cued_cheq_circ);?></td>
										<td class="<?=$saldoopera_total_css;?>"><?=number_format($saldoopera_total);?></td>
										<td class="<?=$cued_cheques;?>"><?=number_format($saldoune->cued_cheques);?></td>
										<td class="<?=$cued_pagos_lin;?>"><?=number_format($saldoune->cued_pagos_lin);?></td>
										<td class="<?=$saldoandep_total_css;?>"><?=number_format($saldoandep_total);?></td>
										<td class="<?=$cued_depos_fir;?>"><?=number_format($saldoune->cued_depos_fir);?></td>
										<td class="<?=$cued_depos_24h;?>"><?=number_format($saldoune->cued_depos_24h);?></td>
										<td class="<?=$saldoantras_total_css;?>"><?=number_format($saldoantras_total);?></td>
										<td class="<?=$saldotraspasoune_css;?>"><?=number_format($saldotraspasoune);?></td>
										<td class="<?=$cued_sald_fin;?>"><?=number_format($saldoune->cued_sald_fin);?></td>
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




