		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1" class=""></li>
				<li data-target="#myCarousel" data-slide-to="2" class=""></li>
			</ol>
			<div class="carousel-inner" role="listbox">
				<div class="item next left">
					
					<div class="container">
						<div class="carousel-caption">
							<h1 class="mdl-typography--text-uppercase">SISTEMA INTEGRAL DE TESORERIA - SIT</h1>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="container">
						<div class="carousel-caption">
							<h1 class="mdl-typography--text-uppercase">Tipo de cambio</h1>
							<div class="tipocambiocarousel">
								<table class="table tipocam"> 
									<thead>
										<tr> 
											<th><img src="<?=base_url('assets/img/tesoreria/ico-monedas.png');?>" alt="Moneda"></th>
											<th>COMPRA</th> 
											<th>VENTA</th> 
										</tr> 
									</thead> 
									<tbody>
									<?php
										if ($displaytipo) {
										foreach ($displaytipo as $displaytipo) { ?> 
										<tr> 
											<td><?=$displaytipo->tc_institucion;?></td>
											<td class="moneda"><?=($displaytipo->tcd_tc_compra);?></th> 
											<td class="moneda"><?=($displaytipo->tcd_tc_venta);?></th> 
										</tr> 
									<?php } 
									}else{
										echo "<div class='nodata'>Aún no se captura el tipo de cambio.</div>";
									}?>
									</tbody> 
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="item active left">
			<img src="<?=base_url('assets/img/tesoreria/financiero.jpg');?>" alt="Chania">
					<div class="container">
						<div class="carousel-caption">
							<h1></h1>
							<p></p>
						</div>
					</div>
				</div>
			</div>
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>


