<?php
	$id_une = $une->une_id; 
?>
<?php
	foreach ($obtben as $obtben) {
		$benvar = "<option value='$obtben->ben_id'>$obtben->ben_nombre</option>";
	}
?>

<section class="vimifos-content mdl-layout__content">
	<section class="flujo ">
		<div class="panel panel-primary">
			<div class="panel-heading vimifos-section-title mdl-typography--display-1-color-contrast"><?=$title;?> DE <?=$une->une_nombre;?> EN <?=$divisa;?> </div>
			<div class="panel-body">
			<?php if ($movcuebanune) {?>

				<div class="boxl" id="table_container_left">
					<div class="col-fixed" >
						<table class="table table-hover tablefix">
							<thead>
								<tr>
									<th>Cuenta</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($movcuebanune->result() as $dtf) { ?>
								<tr>
									<td>
										<a href="/sistema_web/flujo/editarflujo/<?=$dtf->cued_id?>">
											<?=$dtf->ban_nombre;?> - <?=$dtf->cue_nombre;?> <?=$dtf->cue_numero;?>
										</a>
									</td>

								</tr>
							<?php } ?>
								<tr class="total info"> 
									<td >Total:</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

					<div class="boxr" id="table_container_right">
						<div class="table-responsive">
							<table class="table table-hover full">
								<thead>
									<tr>
										<th>Saldo Inicial</th>
										<th>Cheques Circulación</th>
										<th>Saldo de Operación</th>
										<th>PAGOS</th>
										<th>PAGOS A FILIALES</th>
										<th>PAGOS DE FILIALES</th>
										<th>SALDO ANTES DE DEPOSITOS</th>
										<th>DEPOSITOS EN FIRME</th>
										<th>SALDO ANTES DE TRASPASOS</th>
										<th>COMPRAS DE DIVISAS</th>
										<th>TRASPASO SALIDA</th>
										<th>TRASPASO ENTRADA</th>
										<th>SALDO FINAL DEL DIA</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								<?php 
									foreach ($movcuebanune->result() as $dtf) {
									$saldoopera = $dtf->cued_sald_ini - $dtf->cued_cheq_circ;
									$saldoandep = $saldoopera - $dtf->cued_cheques;
									$saldoantras = $saldoandep + $dtf->cued_depos_fir;?>

								<?php if ($dtf->cued_sald_ini < 0) { $cued_sald_ini = "zero"; } else { $cued_sald_ini = "saldo";}?>
								<?php if ($dtf->cued_cheq_circ < 0) { $cued_cheq_circ = "zero"; } else { $cued_cheq_circ = "saldo";}?>
								<?php if ($saldoopera < 0) { $saldoopera_css = "zero"; } else { $saldoopera_css = "saldo";}?>
								<?php if ($dtf->cued_cheques < 0) { $cued_cheques = "zero"; } else { $cued_cheques = "saldo";}?>
								<?php if ($dtf->PV < 0) { $PV_css = "zero"; } else { $PV_css = "saldo";}?>
								<?php if ($dtf->cued_pagos_lin < 0) { $cued_pagos_lin = "zero"; } else { $cued_pagos_lin = "saldo";}?>
								<?php if ($dtf->cued_cheq_circ < 0) { $cued_cheq_circ = "zero"; } else { $cued_cheq_circ = "saldo";}?>
								<?php if ($saldoandep < 0) { $saldoandep_css = "zero"; } else { $saldoandep_css = "saldo";}?>
								<?php if ($dtf->cued_depos_fir < 0) { $cued_depos_fir = "zero"; } else { $cued_depos_fir = "saldo";}?>
								<?php if ($saldoantras < 0) { $saldoantras_css = "zero"; } else { $saldoantras_css = "saldo";}?>
								<?php if ($dtf->CD < 0) { $CD = "zero"; } else { $CD = "saldo";}?>				
								<?php if ($dtf->TS < 0) { $TS_css = "zero"; } else { $TS_css = "saldo";}?>				
								<?php if ($dtf->TP < 0) { $TP_css = "zero"; } else { $TP_css = "saldo";}?>				
								<?php if ($dtf->cued_sald_fin < 0) { $cued_sald_fin = "zero"; } else { $cued_sald_fin = "saldo";}?>
								<?php if ($dtf->cued_sald_fin <= 0) { $statusbtn = "hidden"; } else { $statusbtn = "activo";}?>
								<?php if ($divisa != 'USD') { $statuspb = "hidden"; } else { $statuspb = "";}?>
									<tr>
										<td class="<?=$cued_sald_ini;?>"><?=number_format($dtf->cued_sald_ini,2, '.',',');?></td>
										<td class="<?=$cued_cheq_circ;?>"><?=number_format($dtf->cued_cheq_circ,2, '.',',');?></td>
										<td class="<?=$saldoopera_css;?>"><?=number_format($saldoopera,2, '.',',');?></td>
										<td class="<?=$cued_cheques;?>"><?=number_format($dtf->cued_cheques,2, '.',',');?></td>
										<td class="<?=$PV_css;?>"><?=number_format($dtf->PV,2, '.',',');?></td>
										<td class="<?=$cued_pagos_lin;?>"><?=number_format($dtf->cued_pagos_lin,2, '.',',');?></td>
										<td class="<?=$saldoandep_css;?>"><?=number_format($saldoandep,2, '.',',');?></td>
										<td class="<?=$cued_depos_fir;?>"><?=number_format($dtf->cued_depos_fir,2, '.',',');?></td>
										<td class="<?=$saldoantras_css;?>"><?=number_format($saldoantras,2, '.',',');?></td>
										<td class="<?=$CD;?>"><?=number_format($dtf->CD,2, '.',',');?></td>
										<td class="<?=$TS_css;?>"><?=number_format($dtf->TS,2, '.',',');?></td>
										<td class="<?=$TP_css;?>"><?=number_format($dtf->TP,2, '.',',');?></td>
										<td class="<?=$cued_sald_fin;?> info"><?=number_format($dtf->cued_sald_fin,2, '.',',');?></td>
										<td class="<?=$statusbtn;?>">
											<!-- Right aligned menu below button -->
											<button id="vx-menu-lower-right<?=$dtf->cued_id;?>" class="mdl-button mdl-js-button mdl-button--icon">
												  <i class="material-icons">more_vert</i>
											</button>

											<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
												    for="vx-menu-lower-right<?=$dtf->cued_id;?>">
												<li class="mdl-menu__item" data-toggle="modal" data-target="#pagovim<?=$dtf->cued_id?>">Pagos entre filiales</li>
												<li class="mdl-menu__item" <?=$statuspb;?> ><a href="<?=base_url()?>flujo/pagobendls">Pagos a Beneficiario</a></li>
												<li class="mdl-menu__item" data-toggle="modal" data-target="#traspaso<?=$dtf->cued_id?>">Traspasos</li>
											</ul>
										</td>
									</tr>


										<script type="text/javascript">	
											var path = '<?=base_url()?>';
											$("#demo-menu-lower-right<?=$dtf->cued_id;?>" ).click(function() {
												var ctaorig = <?=$dtf->cued_id;?>;
												var divisa = "<?=$divisa;?>";
												var une = <?=$id_une?>;
												$.post(path + 'flujo/ctaft', { 	
													ctaorig : ctaorig, divisa : divisa, une : une
												}, function(resp) {	
													$("#datos_destino<?=$dtf->cued_id;?>").html(resp);
												});
											});
										</script>
															
					<!-- Pago a vimifos -->

									<div class="flujomodal">
										<div class="modal fade" id="pagovim<?=$dtf->cued_id;?>" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header"><h4 class="modal-title text-upper" id="myModalLabel">Pagos entre Vimifos</h4></div>
													<?=form_open("/flujo/addpagovim/") ?>
														<div class="modal-body">
															<div class="form-group">
																<label for="tra_cue_orig_id" class="control-label right col-xs-2">Cuenta Origen:</label>
																<label class="col-xs-5 left control-label"> 
																	<?=$dtf->une_nombre;?> - <?=$dtf->ban_nombre;?> - <?=$dtf->cue_numero;?> <?=$dtf->cue_nombre;?> - <?=$dtf->cue_divisa;?> SALDO: $<?=number_format($dtf->cued_sald_fin,2, '.',',');?>
																</label>
																<input type="hidden" name="divisa" value="<?=$dtf->cue_divisa;?>">
																<input type="hidden" name="uneid" value="<?=$id_une;?>">
																<input value="<?=$dtf->cued_id;?>" name="idorigen" id="<?=$dtf->cued_id;?>" type="hidden">
																<input value="<?=$dtf->cued_sald_fin;?>" name="saldooripg" type="hidden">
															</div>
															<div class="form-group">
																<label for="unenego" class="control-label right col-xs-2">Unidad de Negocio:</label>
																<div class="col-xs-7">
																	<select name="unenego" style="width:50%" class="form-control left" required="" id="unenego<?=$dtf->cued_id;?>">
																		<option value> -- Seleccione una unidad -- </option>
																	<?php
																		foreach ($todo as $t) { ?>
																		<option value="<?=$t->une_id;?>"><?=$t->une_nombre;?></option>
																	<?php } ?>
																	</select>
																</div>
															</div>

															<div id="montodetrshtml2<?=$dtf->cued_id;?>">
																
															</div>
															<input value="" type="hidden" name="montoanteriorpg" id="montodetrsval2<?=$dtf->cued_id;?>">

															<div class="form-group">
																<label for="mcpagovim" class="control-label right col-xs-2">Cuenta a pagar:</label>
																<div class="col-xs-7">
																	<select style="width:90%" class="form-control left" name="mcpagovim" id="mcpagovim<?=$dtf->cued_id;?>">
																	</select>
																</div>
															</div>
															<?php
																$pagointvim = array(
																	'name'=>'pagointvim', 
																	'placeholder' => 'Importe ',
																	'class' => 'form-control',
																	'type'=>'text',
																	'required title' => 'SOLO NÚMEROS DE 4 A 11 CARACTERES',
																);
															?>

															<div class="form-group">
																<label class="control-label right col-xs-2">Importe:</label>
																<div class="input-group left col-xs-3">
																	<div class="input-group-addon">$</div>
																	<?=form_input($pagointvim) ?>
																</div>
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
												var path = '<?=base_url()?>';
												$(document).ready(function() {
													$("#mcpagovim<?=$dtf->cued_id;?>").change(function() {
														$("#mcpagovim<?=$dtf->cued_id;?> option:selected").each(function() {
															var cueogin = '<?=$dtf->cued_id;?>';
															var vim =$('#mcpagovim<?=$dtf->cued_id;?>').val();
												    		var arr = vim.split('|');
															
															$.post(path + 'flujo/montopago', { 
																id_origen : cueogin, id_destino : arr[0]
															}, function(resp) {
																$("#montodetrshtml2<?=$dtf->cued_id;?>").html(resp);
															});
															
															$.post(path + 'flujo/montopagoval', { 
																id_origen : cueogin, id_destino : arr[0]
															}, function(resp) {
																$("#montodetrsval2<?=$dtf->cued_id;?>").val(resp);
															});
														});
													})
												});
											</script>

											<script type="text/javascript">	
												var path = '<?=base_url()?>index.php/';
												$(document).ready(function() {
													$("#unenego<?=$dtf->cued_id;?>").change(function() {
														$("#unenego<?=$dtf->cued_id;?> option:selected" ).each(function() {
															var div = '<?=$dtf->cue_divisa;?>';
															var cueogin = '<?=$dtf->cued_id;?>';
															var idune = $('#unenego<?=$dtf->cued_id;?>').val();
															$.post(path + 'flujo/mcpagovim', { 
																divisa : div, cueogin : cueogin, idune : idune
															}, 
															function(resp) {
																$("#mcpagovim<?=$dtf->cued_id;?>").html(resp);
																	});
																});
															})
												});
											</script>
											<script type="text/javascript">
												function limtodo() {
													location.reload();
												}
											</script>
										</div><!-- modal -->
									</div>

							<!-- Traspaso -->

									<div class="flujomodal">
										<div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);" id="traspaso<?=$dtf->cued_id;?>">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header"><h4 class="modal-title text-upper" id="myModalLabel">Traspaso entre cuentas</h4></div>
													<?=form_open("/flujo/addtranspaso/") ?>
														<div class="modal-body">
															<div class="form-group">
																<label for="tra_cue_orig_id" class="control-label right col-xs-2">Cuenta Origen:</label>
																<input value="<?=$dtf->cued_id;?>" name="tra_cue_orig_id" id="<?=$dtf->cued_id;?>" type="hidden">
																<label class="col-xs-5 left control-label">
																	<?=$dtf->ban_nombre;?> - <?=$dtf->cue_nombre;?> <?=$dtf->cue_numero;?> - <?=$dtf->cue_divisa;?>: $<?=number_format($dtf->cued_sald_fin,2, '.',',');?>
																</label>																	
																<input value="<?=$dtf->cued_sald_fin;?>" name="saldoori" type="hidden">
															</div>
															<div class="form-group">
																<label for="datos_destino" class="control-label right col-xs-2">Cuenta Destino:</label>
																<div class="col-xs-7">
																	<select class="form-control" name="datos_destino" id="datos_destino<?=$dtf->cued_id;?>" style="width:100%" left" required="">
																	
																	</select>
																</div>
															</div>

															<?php
																$tra_monto = array(
																	'name'=>'tra_monto', 
																	'placeholder' => 'Importe ',
																	'class' => 'form-control ',
																	'type'=>'text',
																	'id' => 'tra_monto<?=$dtf->cued_id;?>',
																	'required title' => 'SOLO NÚMEROS DE 4 A 11 CARACTERES',
																);
															?>
															<div id="montodetrshtml<?=$dtf->cued_id;?>">
																
															</div>
															<div class="form-group" id="cleart">
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
																		<option value="INTERNACIONAL">INTERNACIONAL</option>
																		<option value="SPEI">SPEI</option>
																		<option value="TELEFONICO">TELEFONICO</option>
																		<option value="TRASPASO">TRASPASO</option>
																	</select>
																</div>
															</div>
															<div class="form-group">
																<label class="control-label right col-xs-2">Operado por:</label>
																<div class="col-xs-3" >
																	<select name="tra_responsable" class="form-control left" required="">
																		<option value> -- Tipo de movimiento  -- </option>
																		<option value="CORPORATIVO">CORPORATIVO</option>
																		<option value="GUADALAJARA">GUADALAJARA</option>
																		<option value="OBREGON">OBREGON</option>
																	</select>
																</div>
															</div>

															<input value="" type="hidden" name="montoanterior" id="montodetrsval<?=$dtf->cued_id;?>">

														</div><!-- modal-body -->
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal" onclick="limtras();" >Cancelar</button>
															<button type="submit" class="btn btn-success">Capturar</button>
														</div>
													<?=form_close() ?>
												</div><!-- modal-content -->
											</div><!-- modal-dialog -->
											
											<script type="text/javascript">	
												var path = '<?=base_url()?>';
												$(document).ready(function() {
													$("#datos_destino<?=$dtf->cued_id;?>").change(function() {
														$("#datos_destino<?=$dtf->cued_id;?> option:selected").each(function() {
															var sof =$('#<?=$dtf->cued_id;?>').val();
															var vim =$('#datos_destino<?=$dtf->cued_id;?>').val();
												    		var arr = vim.split('|');
															
															$.post(path + 'flujo/montotraspaso', { 
																id_origen : sof, id_destino : arr[0]
															}, function(resp) {
																$("#montodetrshtml<?=$dtf->cued_id;?>").html(resp);
															});
															
															$.post(path + 'flujo/montotraspasoval', { 
																id_origen : sof, id_destino : arr[0]
															}, function(resp) {
																$("#montodetrsval<?=$dtf->cued_id;?>").val(resp);
															});
														});
													})
												});
											</script>
											<script type="text/javascript">
												function limtras() {
													location.reload();
												}
											</script>
										</div><!-- modal -->
									</div>




								<?php } }?>


									<?php
										
										foreach ($saldototalune_trapaso as $sldtu_t){ $saldotraspasoune = $sldtu_t->tra_monto;}
										if ($saldotraspasoune < 0){ $saldotraspasoune_css = "zero"; } else { $saldotraspasoune_css = "saldo"; }
										foreach ($saldototalune_divisas as $sldtu_dv) { $saldodivisaune = $sldtu_dv->tra_monto; }

										if ($saldotraspasoune < 0) { $saldotraspasoune_css = "zero"; } else { $saldotraspasoune_css = "saldo"; }
										
										foreach ($saldototalune_pagov as $sldtu_dv) { $saldopagovune = $sldtu_dv->tra_monto; }
										if ($saldotraspasoune < 0) { $saldotraspasoune_css = "zero"; } else { $saldotraspasoune_css = "saldo"; }
										
										foreach ($saldototalune_ts as $sldtu_dv) { $saldotsune = $sldtu_dv->tra_monto; }
										if ($saldotraspasoune < 0) { $saldotraspasoune_css = "zero"; } else { $saldotraspasoune_css = "saldo"; }


										foreach ($saldototalune as $su) { 
											$saldoopera_total = $su->cued_sald_ini - $su->cued_cheq_circ;
											$saldoandep_total = $saldoopera_total - $su->cued_cheques;
											$saldoantras_total = $saldoandep_total + $su->cued_depos_fir;?>

										<?php if ($su->cued_sald_ini < 0) { $cued_sald_ini = "zero"; } else { $cued_sald_ini = "saldo";}?>
										<?php if ($su->cued_cheq_circ < 0) { $cued_cheq_circ = "zero"; } else { $cued_cheq_circ = "saldo";}?>
										<?php if ($saldoopera_total < 0) { $saldoopera_total_css = "zero"; } else { $saldoopera_total_css = "saldo";}?>
										<?php if ($su->cued_cheques < 0) { $cued_cheques = "zero"; } else { $cued_cheques = "saldo";}?>
										<?php if ($saldopagovune < 0) { $saldopagovune_css = "zero"; } else { $saldopagovune_css = "saldo";}?>
										<?php if ($su->cued_pagos_lin < 0) { $cued_pagos_lin = "zero"; } else { $cued_pagos_lin = "saldo";}?>
										<?php if ($su->cued_cheq_circ < 0) { $cued_cheq_circ = "zero"; } else { $cued_cheq_circ = "saldo";}?>
										<?php if ($saldoandep_total < 0) { $saldoandep_total_css = "zero"; } else { $saldoandep_total_css = "saldo";}?>
										<?php if ($su->cued_depos_fir < 0) { $cued_depos_fir = "zero"; } else { $cued_depos_fir = "saldo";}?>
										<?php if ($saldoantras_total < 0) { $saldoantras_total_css = "zero"; } else { $saldoantras_total_css = "saldo";}?>
										<?php if ($saldotraspasoune < 0) { $saldotraspasoune_css = "zero"; } else { $saldotraspasoune_css = "saldo";}?>					
										<?php if ($saldotsune < 0) { $saldotsune_css = "zero"; } else { $saldotsune_css = "saldo";}?>				
										<?php if ($saldodivisaune < 0) { $saldodivisaune_css = "zero"; } else { $saldodivisaune_css = "saldo";}?>				
										<?php if ($su->cued_sald_fin < 0) { $cued_sald_fin = "zero"; } else { $cued_sald_fin = "saldo";}?>

										<tr class="total info">
											<td class="<?=$cued_sald_ini;?>"><?=number_format($su->cued_sald_ini,2, '.',',');?></td>
											<td class="<?=$cued_cheq_circ;?>"><?=number_format($su->cued_cheq_circ,2, '.',',');?></td>
											<td class="<?=$saldoopera_total_css;?>"><?=number_format($saldoopera_total,2, '.',',');?></td>
											<td class="<?=$cued_cheques;?>"><?=number_format($su->cued_cheques,2, '.',',');?></td>
											<td class="<?=$saldopagovune_css;?>"><?=number_format($saldopagovune,2, '.',',');?></td>
											<td class="<?=$cued_pagos_lin;?>"><?=number_format($su->cued_pagos_lin,2, '.',',');?></td>
											<td class="<?=$saldoandep_total_css;?>"><?=number_format($saldoandep_total,2, '.',',');?></td>
											<td class="<?=$cued_depos_fir;?>"><?=number_format($su->cued_depos_fir,2, '.',',');?></td>
											<td class="<?=$saldoantras_total_css;?>"><?=number_format($saldoantras_total,2, '.',',');?></td>
											<td class="<?=$saldodivisaune_css;?>"><?=number_format($saldodivisaune,2, '.',',');?></td>
											<td class="<?=$saldotsune_css;?>"><?=number_format($saldotsune,2, '.',',');?></td>
											<td class="<?=$saldotraspasoune_css;?>"><?=number_format($saldotraspasoune,2, '.',',');?></td>
											<td class="<?=$cued_sald_fin;?>"><?=number_format($su->cued_sald_fin,2, '.',',');?></td>
										</tr>

										<?php }?>


								</tbody>
							</table>
						</div>
					</div>


			</div>
		</div>
	</section>
</section>
