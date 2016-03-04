
<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-more-section shadow">
		<div class="form-fc">
			<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
				<?=$title;?>
			</div>
			<div class="reporte_d">
				<div class="col-md-12">
					<div class="form-group col-md-6">
						<label for="fecha_d">REPORTE TRASPASO DEL DÍA</label>
						<div class="buttonaction">
							<a class="btn btn-success" href="<?=site_url('reportes/rtraspasoactual');?>">REPORTE</a>
						</div>						
					</div>
				</div>
			</div>

			<div class="reporte_f">
				<?=form_open("/reportes/reportetrapasos_f/")?>
					<div class="col-md-12">
						<div class="form-group col-md-6">
							<label for="fecha">REPORTE TRASPASO AL DÍA:</label>
						    <div class='input-group date' id='datetimepicker10'>
						        <input type="text" name="fecha" class="form-control" required="" placeholder="1995/09/06" />
						        <span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							<div class="buttonaction">
								<button type="submit" class="btn btn-success">REPORTE</button>
							</div>
						</div>
					</div>
				<?=form_close() ?>     
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
