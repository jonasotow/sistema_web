<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-section box">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$title;?>
		</div>
		<div class="pagob">
			<div class="col-md-12 shadow">
				<div class="form-group">
					<?=form_open("/flujo/pagob") ?>
						<div class="col-md-4">
							<label for="tra_divisa">Divisa:</label>
							<select name="tra_divisa" id="tra_divisa" class="form-control" tabindex="1" required="">
								<option value> -- Seleccione Divisa -- </option>
								<option value="USD">USD</option>
								<option value="EUR">EUR</option>
							</select>
							<label class="control-label">Beneficiario:</label>
							<select name="ben" class="form-control left" tabindex="4" required="" >
								<option value> -- Seleccione Beneficiario -- </option>
							<?php
								foreach ($obtben as $b) { ?>
								<option value="<?=$b->ben_id;?>"><?=$b->ben_nombre;?></option>
							<?php } ?>
							</select>				

						</div>
						<div class="col-md-4">
							<label for="unenego">Unidad de Negocio:</label>
							<select name="unenego" id="unenego" class="form-control" tabindex="2" required="">
								<option value> -- Seleccione una unidad -- </option>
									<?php
									if ($une) {
										foreach ($une->result() as $u) { 
									?>
								<option value="<?=$u->une_id;?>"><?=$u->une_nombre;?></option>
									<?php }	
									}else{
										echo "<option>NO HAY DATOS</option>";
									}?>
							</select>
							<label for="tra_monto">Monto:</label>
							<div class="input-group">
								<div class="input-group-addon">$</div>
								<input name="tra_monto" class="form-control" tabindex="5" required="">
							</div>
							
						</div>

						<div class="col-md-4">
							<label for="cuentapago">Selecciones Cuenta Origen:</label>
							<select name="cuentapago" class="form-control" id="cuentapago" tabindex="3" required=""></select>

						
						</div>
						<div class="mdl-card__actions mdl-card--border">
							<button type="submit" class="btn btn-success">Guardar</button>
							<a href="<?=base_url().'tesoreria/home' ?>" type="button" class="btn btn-default">Cancelar</a>
						</div>
					<?=form_close();?>
				</div>
			</div>	
		</div>			    
	</div>
</section>
<script type="text/javascript">	
	var path = '<?=base_url()?>';
	$(document).ready(function() {
		$("#unenego").change(function() {
			$("#unenego option:selected" ).each(function() {
														
				var div = $('#tra_divisa').val();
				var une = $('#unenego').val();
												    	
				$.post(path + 'flujo/obtcta', { 
					divisa : div,
					une : une
				}, 
				function(resp) {
					$("#cuentapago").html(resp);
						});
					});
				})
	});
</script>