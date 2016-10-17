<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-section box">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$title;?>
		</div>
		<div class="cambiotipo">
			<div class="col-md-12 shadow">
				<div class="form-group">
					<?=form_open("/divisas/add") ?>
						<div class="col-md-4">
							<label for="tra_divisa">Divisa:</label>
							<select name="tra_divisa" id="tra_divisa" class="form-control" tabindex="1" required="">
								<option value> -- Seleccione Divisa -- </option>
								<option value="USD">USD</option>
								<option value="EUR">EUR</option>
							</select>
							<label for="cuentapago">Selecciones Cuenta Origen:</label>
							<select name="cuentapago" class="form-control" id="cuentapago" tabindex="4" required="">
							</select>
							<label for="tra_monto">Monto:</label>
							<div class="input-group">
								<div class="input-group-addon">$</div>
								<input name="tra_monto" class="form-control" tabindex="7" id="valor1" onkeyup="mult()" required="">
							</div>

						</div>

						<div class="col-md-4">
							<label for="unenego">Unidad de Negocio:</label>
							<select name="unenego" id="unenego" class="form-control" tabindex="2" required="">
								<option value> -- Seleccione una unidad -- </option>
									<?php
									if ($obtune) {
										foreach ($obtune->result() as $u) { 
									?>
								<option value="<?=$u->une_id;?>"><?=$u->une_nombre;?></option>
									<?php }	
									}else{
										echo "<option>NO HAY DATOS</option>";
									}?>
							</select>

							<label for="cuentadepo">Selecciones Cuenta Destino:</label>
							<select name="cuentadepo" class="form-control" id="cuentadepo" tabindex="5" required="">
							</select>
							<label for="tra_tc">Tipo de Cambio:</label>
							<div class="input-group col-md-9">
								<div class="input-group-addon">$</div>
								<input name="tra_tc" class="form-control" tabindex="9" id="valor2" onkeyup="mult()" required="">
							</div>
						</div>

						<div class="col-md-4">
							<label for="tra_banco">Selecciones Institución:</label>
							<select name="tra_banco" class="form-control" tabindex="3" required="">
								<option value> -- Seleccione Institución -- </option>
									<?php
									if ($obtbanc) {
										foreach ($obtbanc->result() as $b) { 
									?>
								<option value="<?=$b->ban_id;?>"><?=$b->ban_nombre;?></option>
									<?php }	
									}else{
										echo "<option>NO HAY DATOS</option>";
									}?>
							</select>
							<label for="tra_tipomov">Tipo de Operación:</label>
							<select name="tra_tipomov" class="form-control" tabindex="6" required="">
								<option value> -- Seleccione Operación -- </option>
								<option value="C">COMPRA</option>
								<option value="V" disabled="">VENTA</option>
							</select>
							<label>Conversion Total:</label>
							<div class="input-group col-md-9">
								<div class="input-group-addon">$</div>
								<input class="form-control" tabindex="9" id="total" disabled="">
							</div>
						</div>
						
						<div class="mdl-card__actions mdl-card--border">
							<button type="submit" class="btn btn-success">Guardar</button>
							<a href="<?=base_url().'tesoreria/home' ?>" type="button" class="btn btn-default">Cancelar</a>
						</div>
					<?=form_close();?>
				</div>
			</div>
		</div>
		<div class="detalles">
			
			<div class="mdl-card__actions mdl-card--border">
				<a href="<?=base_url();?>divisas/transdivisas" class="btn btn-primary">Ver compras y ventas</a>
			</div>
		</div>

	</div>
</section>

<script src="<?=base_url().'assets/js/tesoreria/multiplica.js'?>"></script>

<script type="text/javascript">	
	var path = '<?=base_url()?>';
	$(document).ready(function() {
		$("#unenego").change(function() {
			$("#unenego option:selected" ).each(function() {
														
				var div = $('#tra_divisa').val();
				var une = $('#unenego').val();
												    	
				$.post(path + 'divisas/obtcuentorig', { 
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
<script type="text/javascript">
	$('form').attr('autocomplete', 'off');
</script>
<script type="text/javascript">	
	var path = '<?=base_url()?>';
	$(document).ready(function() {
		$("#unenego").change(function() {
			$("#unenego option:selected" ).each(function() {
														
				var div = $('#tra_divisa').val();
				var une = $('#unenego').val();
												    	
				$.post(path + 'divisas/obtcuentdest', { 
					divisa : div,
					une : une
				}, 
				function(resp) {
					$("#cuentadepo").html(resp);
						});
					});
				})
	});
</script>
