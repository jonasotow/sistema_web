<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-section box">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$title;?>
		</div>
		<div class="cambiotipo">
			<div class="col-md-10 shadow">
				<div class="form-group">
					<?=form_open("/tipocambio/add") ?>
						<div class="col-md-4">
							<label for="tcd_insti_id">Selecciones una Institución</label>
							<select name="tcd_insti_id" class="form-control" required="">
								<option value> -- Seleccione uno Institución -- </option>
									<?php
									if ($insti) {
										foreach ($insti->result() as $i) { 
										
									?>
								<option value="<?=$i->tc_insti_id;?>"><?=$i->tc_institucion;?></option>
									<?php }	
									}else{
										echo "<option>NO HAY DATOS</option>";
									}?>
							</select>

							<label for="tcd_fecha">Fecha:</label>
							<div class='input-group date' id='datetimepicker10'>
								<input type="text" name="tcd_fecha" class="form-control " required="" placeholder="1995/09/06" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<label for="tcd_hora">Hora:</label>
							<div class='input-group date' id='datetimepicker11'>
							    <input type="text" name="tcd_hora" class="form-control " placeholder="14:35" />
							    <span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</div>

						<div class="col-md-4">
							<label for="tcd_tc_compra">Compra:</label>
							<div class="input-group col-xs-5">
								<div class="input-group-addon">$</div>
								<input name="tcd_tc_compra" class="form-control" required="">
							</div>
							<label for="tcd_tc_venta">Venta:</label>
							<div class="input-group col-xs-5">
								<div class="input-group-addon">$</div>
								<input name="tcd_tc_venta" class="form-control" required="">
							</div>

							<label for="tcd_descripcion">Descripción</label>
							<input name="tcd_descripcion" class="form-control">
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
	$(function () {
		$('#datetimepicker10').datetimepicker({
		    viewMode: 'days',
		    format: 'YYYY/MM/DD'
		});
	});
</script>
<script type="text/javascript">
	$(function () {
		$('#datetimepicker11').datetimepicker({
		    format: 'HH:mm'
		});
	});
</script>