
<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-more-section shadow">
		<div class="form-fc">
			<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
				<?=$title;?>
			</div>

			<div class="reporte_d">
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="form-group">
							<label for="fecha_d">TRASPASO DEL DÍA</label>
							<div class="buttonaction">
								<a class="btn btn-success" href="<?=site_url('reportes/rtraspasoactual');?>">REPORTE</a>
							</div>						
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="form-group">
							<label for="fecha_d">SALDOS DEL DIA</label>
							<div class="buttonaction">
								<a class="btn btn-success" href="<?=site_url('reportes/saldosunes');?>">REPORTE</a>
							</div>						
						</div>
					</div>
				</div>
			</div>

			<div class="reporte_f">
				<div class="col-md-6">
					<div class="col-md-12">
						<?=form_open("/reportes/reportetrapasos_f/")?>
							<div class="form-group">
								<label for="fecha">TRASPASO AL DÍA:</label>
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
						<?=form_close() ?> 
					</div>
				</div>
				<div class="col-md-6">
					<div class="col-md-12">
						<?=form_open("/reportes/saldosunes_f/")?>
							<div class="form-group">
								<label for="fecha">SALDOS AL DÍA:</label>
							    <div class='input-group date' id='datetimepicker'>
							        <input type="text" name="fecha" class="form-control" required="" placeholder="1995/09/06" />
							        <span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<div class="buttonaction">
									<button type="submit" class="btn btn-success">REPORTE</button>
								</div>
							</div>
						<?=form_close() ?> 
					</div>
				</div>
			</div>

			<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
				<?=$title2;?>
			</div>

			<div class="notific">
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="form-group">
							<label for="fecha_d">CAPTURA DE SALDOS</label>
							
							<?=form_open("/reportes/notif_saldos")?>

							<input value="<?=$usuario;?>" name="usuario" type="hidden">
							<div class="buttonaction">
								<button type="submit" class="btn btn-success">ENVIAR</button>
							</div>						
							<?=form_close() ?> 
						</div>
					</div>
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
		$('#datetimepicker').datetimepicker({
		    viewMode: 'days',
		    format: 'YYYY/MM/DD'
		});
	});
</script>
