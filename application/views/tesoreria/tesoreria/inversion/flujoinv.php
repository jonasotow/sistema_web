<section class="vimifos-content mdl-layout__content">
	<section class="flujo ">
		<div class="panel panel-primary">
			<div class="panel-heading vimifos-section-title mdl-typography--display-1-color-contrast">
				<?=$title;?> </div>
			<div class="panel-body ">
				<div class="col-md-12 ">
					<div class="panel panel-default">
						<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Cuenta</th>
									<th>Tasa Bruta</th>
									<th>Tasa Neta</th>
									<th>Saldo Inicial</th>
									<th>Saldo Final</th>
									<th>Rendimiento</th>
									<th>Días de Inversión</th>
									<th></th>
										
								</tr>
							</thead>
							<?php if ($cuentasinv):?>
								<?php foreach ($cuentasinv->result() as $cuentasinv): ?>
							<tbody>
								<tr>
									<td class="cta">
										<?=$cuentasinv->une_nombre;?>
										<?=$cuentasinv->cue_nombre;?> 
										<?=$cuentasinv->cue_numero;?> 
										<?=$cuentasinv->cue_descripcion;?>
									</td> 
									<td>
										<div class="tasab"><?=number_format($cuentasinv->cueinv_tasa_bruta,2, '.',',');?></div>
									</td> 
									<td>
										<div class="tasan"><?=number_format($cuentasinv->cueinv_tasa_neta,2, '.',',');?></div>
									</td> 
									<td>
										<div class="saldoi"><?=number_format($cuentasinv->cueinv_sald_ini,2, '.',',');?></div>
									</td>
									<td>
										<div class="saldof"><?=number_format($cuentasinv->cueinv_sald_fin,2, '.',',');?></div>
									</td>
									<td>
										<div class="redimiento"><?=number_format($cuentasinv->cueinv_int_gene,2, '.',',');?></div>								
									</td>
									<td>
										<div class="dias"><?=$cuentasinv->cueinv_dias;?></div>
									</td>
									<td>
										<!-- Right aligned menu below button -->
										<button id="demo-menu-lower-right<?=$cuentasinv->cueinv_id;?>"
											        class="mdl-button mdl-js-button mdl-button--icon">
										  <i class="material-icons">more_vert</i>
										</button>

										<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="demo-menu-lower-right<?=$cuentasinv->cueinv_id;?>">
											<li class="mdl-menu__item" data-toggle="modal" data-target="#captinv<?=$cuentasinv->cueinv_id?>">Capturar Saldo</li>
											<li class="mdl-menu__item" data-toggle="modal" data-target="#traspaso<?=$cuentasinv->cueinv_id?>">Traspasos</li>

										</ul>
									</td>

								</tr>


								<div class="flujomodal">
									<div class="modal fade" id="captinv<?=$cuentasinv->cueinv_id;?>" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
										<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title text-upper" id="myModalLabel">Pagos entre Vimifos</h4>
											</div>
											<?=form_open("/inversion/saldoant/") ?>

												<?php
													$cueinv_sald_fin = array(
														'type'=>'text', 'id'=>'valor1', 'tabindex'=>'1', 'onkeyup'=>'sumar();', 'style' => 'width: 150%', 'name' => 'cueinv_sald_fin',
														'class' => 'form-control','required title' => 'INGRESE SOLO NÚMEROS',
													);
													$cueinv_dias = array(
														'type'=>'text', 'id'=>'valor1', 'tabindex'=>'1', 'onkeyup'=>'sumar();', 'style' => 'width: 150%', 'name' => 'cueinv_dias',
														'class' => 'form-control','required title' => 'INGRESE SOLO NÚMEROS', 'value' => '1'
													);
												?>

												<div class="modal-body">
													<div class="form-group">
														<label for="cueinv_id" class="control-label right col-xs-2">Cuenta:</label>
														<label class="col-xs-5 left control-label">
															<?=$cuentasinv->une_nombre;?>
															<?=$cuentasinv->cue_nombre;?>
															<?=$cuentasinv->cue_numero;?>
														</label>
														<input type="hidden" name="cueinv_id" value="<?=$cuentasinv->cueinv_id;?>">

													</div>
													<div class="form-group">
														<label for="cueinv_sald_ini" class="control-label right col-xs-2">Saldo Anterior:</label>
														<label class="col-xs-5 left control-label">
														<span class="saldoi"></span>
															<?=number_format($cuentasinv->cueinv_sald_ini,2, '.',',');?>
														</label>
															<input type="hidden" name="cueinv_sald_ini" value="<?=$cuentasinv->cueinv_sald_ini;?>">
													</div>
													<div class="form-group">
														<label for="cueinv_sald_fin" class="control-label right col-xs-2">Nuevo Saldo:</label>
														<div class="input-group left col-xs-2">
															<div class="input-group-addon">$</div>
															<?=form_input($cueinv_sald_fin);?>
														</div>
													</div>
													<div class="form-group">
														<label for="cueinv_dias" class="control-label right col-xs-2">Días de inversión:</label>
														<div class="input-group left col-xs-1">
															<?=form_input($cueinv_dias);?>
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
									</div><!-- modal -->
								</div>


									<div class="flujomodal">
										<div class="modal fade" id="traspaso<?=$cuentasinv->cued_id;?>" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title text-upper" id="myModalLabel">Pagos entre Vimifos</h4>
													</div>
													<?=form_open("/inversion/addtranspaso/") ?>
														<div class="modal-body">
															<div class="form-group">
																<label for="tra_cue_orig_id" class="control-label right col-xs-2">Cuenta Origen:</label>
																<label class="col-xs-5 left control-label">
																	<?=$cuentasinv->une_nombre;?> - 
																	<?=$cuentasinv->ban_nombre;?> - 
																	<?=$cuentasinv->cue_numero;?>  
																	<?=$cuentasinv->cue_nombre;?> -
																	<?=$cuentasinv->cue_divisa;?> SALDO:
																	$<?=number_format($cuentasinv->cueinv_sald_ini,2, '.',',');?>
																</label>
																<input value="<?=$cuentasinv->cued_id;?>" name="idorigen" id="<?=$cuentasinv->cued_id;?>" type="hidden">
																<input value="<?=$cuentasinv->cued_sald_fin;?>" name="saldooripg" type="hidden">
													
															</div>
															<div class="form-group">
																<label for="unenego" class="control-label right col-xs-2">Unidad de Negocio:</label>
																<div class="col-xs-7">
																	<select name="unenego" id="unenego<?=$cuentasinv->cued_id;?>" style="width:50%" class="form-control left" required="">
																		<option value> -- Seleccione una unidad -- </option>
																	<?php
																		foreach ($todo as $t) { ?>
																		<option value="<?=$t->une_id;?>"><?=$t->une_nombre;?></option>
																	<?php } ?>
																	</select>
																</div>
															</div>

															<div class="form-group">
																<label for="mcpagovim" class="control-label right col-xs-2">Cuenta a pagar:</label>
																<div class="col-xs-7">
																	<select style="width:90%" class="form-control left" name="mcpagovim" id="mcpagovim<?=$cuentasinv->cued_id;?>">
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
													$("#unenego<?=$cuentasinv->cued_id;?>").change(function() {
														$("#unenego<?=$cuentasinv->cued_id;?> option:selected" ).each(function() {
														
															var div = '<?=$cuentasinv->cue_divisa;?>';
															var cueogin = '<?=$cuentasinv->cued_id;?>';
															var idune = $('#unenego<?=$cuentasinv->cued_id;?>').val();
												    	
															$.post(path + 'flujo/mcpagovim', { 
																divisa : div,
																cueogin : cueogin,
																idune : idune
															}, 
															function(resp) {
																$("#mcpagovim<?=$cuentasinv->cued_id;?>").html(resp);
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

							</tbody>
								<?php endforeach; ?>	
							<?php else: ?>
								<div class='nodata'>NO HAY DATOS</div>
							<?php endif;?>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>
<script type="text/javascript">	
	$(document).ready(function() {
		$("#ctainv").change(function() {
			$("#ctainv option:selected").each(function() {

				var s = document.getElementById("ctainv").value;
				var z = s.split('|');
				document.getElementById("saldoantinv").innerHTML = "$ " + z[1];
				document.getElementById("saldoantinv").value = "$ " + z[1];

			});
		})
	});
</script>	