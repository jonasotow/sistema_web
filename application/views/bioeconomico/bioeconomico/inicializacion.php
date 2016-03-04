<section>
	<div class="panel">	
	  <div class="panel-body">
		<?=isset($utilida_perdida) ? $utilida_perdida : '';?>
		<article>
			<div id="grafica_1"></div>
			<div id="grafica_2"></div>
			<div id="grafica_3"></div>
			<div id="grafica_4"></div>
			<div id="grafica_5"></div>	
		</article>
	
		<!-- Trigger the modal with a button -->
			<button id="btn_crear_escenario" type="button" class="btn btn-primary" data-toggle="modal" data-target="#crear_escenario">Crear escenario</button>

			<!-- Modal -->
			<div id="crear_escenario" class="modal fade" role="dialog">
			  <div class="modal-dialog">
			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Datos para el escenario</h4>
			      </div>
			      <div class="modal-body">
							<div>Datos de los vientres:</div>
							  <label for="numero_vientres_escenario"># de vientres:</label>
								 <input type="range" name="numero_vientres_escenario" class="valores_escenarios">
								 <i id="numero_vientres_escenario">50</i>
							<p>
							  <label for="precio_vientre_escenario">$ vientre:</label>
							 <input type="range" name="precio_vientre_escenario" class="valores_escenarios">
								<i id="precio_vientre_escenario">50</i>
							</p>

							<p>
							  <label for="numero_destete_escenario">#  Destetes:</label>
							  <input type="range" name="numero_destete_escenario" class="valores_escenarios">
								<i id="numero_destete_escenario">50</i>
							</p>

							<div>Vaquillas de reemplazo al año:</div>
							  <label for="numero_criadas_escenario"># criadas:</label>
							  <input type="range" name="numero_criadas_escenario" class="valores_escenarios">
								<i id="numero_criadas_escenario">50</i>
							</p>
							<div>Datos becerros (as) destetados al año:</div>
							<p>
							  <label for="numero_becerros_vendidos_escenario">#  becerros vendidos:</label>
							  <input type="range" name="numero_becerros_vendidos_escenario" class="valores_escenarios">
								<i id="numero_becerros_vendidos_escenario">50</i>
							</p>
							<p>
							  <label for="peso_vivo_venta_escenario">Peso vivo a la venta,  kg:</label>
							 <input type="range" name="peso_vivo_venta_escenario" class="valores_escenarios">
								<i id="peso_vivo_venta_escenario">50</i>
							</p>
							<p>
							  <label for="precio_kg_vendido_escenario">$/kg vendido:</label>
							  <input type="range" name="precio_kg_vendido_escenario" class="valores_escenarios">
								<i id="precio_kg_vendido_escenario">50</i>
							</p>
							<p>
							  <label for="numero_becerras_vendidas_escenario"># becerras vendidas:</label>
							 <input type="range" name="numero_becerras_vendidas_escenario" class="valores_escenarios">
								<i id="numero_becerras_vendidas_escenario">50</i>
							</p>
							<p>
							  <label for="peso_vivo_venta_escenario">Peso vivo a la venta,  kg:</label>
							  <input type="range" name="peso_vivo_venta_escenario" class="valores_escenarios">
								<i id="peso_vivo_venta_escenario">50</i>
							</p>
							<p>
							  <label for="precio_kg_vendido_escenario">$/kg vendido:</label>
							  <input type="range" name="precio_kg_vendido_escenario" class="valores_escenarios">
								<i id="precio_kg_vendido_escenario">50</i>
							</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary" data-dismiss="modal" id="btn_mostrar_escenario" >Mostrar</button>
			      </div>
			    </div>
			  </div>
			</div> <!-- Modal termina-->	
	  </div>
	</div>
</section>