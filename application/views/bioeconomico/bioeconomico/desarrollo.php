<section>
<div class="panel panel-primary">
	<div class="panel-body">
		<?php foreach($lote as $row){ ?>
			<input type="hidden" name="nocabezas" id="nocabezas" value=<?=$row->nocabezas?>>
			<input type="hidden" name="fechaentrada" id="fechaentrada" value=<?=$row->fechaentrada?>>
			<input type="hidden" name="fechasalida" id="fechasalida" value=<?=$row->fechasalida?>>
			<input type="hidden" name="PesoVivoIni" id="PesoVivoIni" value=<?=$row->PesoVivoIni?>>
			<input type="hidden" name="PesoVivoOri" id="PesoVivoOri" value=<?=$row->PesoVivoOri?>>
			<input type="hidden" name="PesoVivoSal" id="PesoVivoSal" value=<?=$row->PesoVivoSal?>>
			<input type="hidden" name="DesctoPv" id="DesctoPv" value=<?=$row->DesctoPv?>>
			<input type="hidden" name="VentaKg" id="VentaKg" value=<?=$row->VentaKg?>>
			<input type="hidden" name="CompraKg" id="CompraKg" value=<?=$row->CompraKg?>>
			<input type="hidden" name="RentaPradera" id="RentaPradera" value=<?=$row->RentaPradera?>>
			<input type="hidden" name="AlimentacionTotal" id="AlimentacionTotal" value=<?=$row->AlimentacionTotal?>>
			<input type="hidden" name="NoDiasFechas" id="NoDiasFechas" value=<?=$row->NoDiasFechas?>>
			<input type="hidden" name="Merma" id="Merma" value=<?=$row->Merma?>>
			<input type="hidden" name="PesoVidaSalidaReal" id="PesoVidaSalidaReal" value=<?=$row->PesoVidaSalidaReal?>>
			<input type="hidden" name="InvFinal" id="InvFinal" value=<?=$row->InvFinal?>>
			<input type="hidden" name="DiasCabCiclo" id="DiasCabCiclo" value=<?=$row->DiasCabCiclo?>>
			<input type="hidden" name="GanciaTotalCabKilos" id="GanciaTotalCabKilos" value=<?=$row->GanciaTotalCabKilos?>>
			<input type="hidden" name="GananciaTotalLote" id="GananciaTotalLote" value=<?=$row->GananciaTotalLote?>>
			<input type="hidden" name="Gdp" id="Gdp" value=<?=$row->Gdp?>>
			<input type="hidden" name="IngresoLote" id="IngresoLote" value=<?=$row->IngresoLote?>>
			<input type="hidden" name="IngresoCab" id="IngresoCab" value=<?=$row->IngresoCab?>>
			<input type="hidden" name="EgresoLote" id="EgresoLote" value=<?=$row->EgresoLote?>>
			<input type="hidden" name="EgresoCab" id="EgresoCab" value=<?=$row->EgresoCab?>>
			<input type="hidden" name="RentaPraderaLote" id="RentaPraderaLote" value=<?=$row->RentaPraderaLote?>>
			<input type="hidden" name="TotalPastoreoAlimentoLote" id="TotalPastoreoAlimentoLote" value=<?=$row->TotalPastoreoAlimentoLote?>>
			<input type="hidden" name="InvTotalOperativaLote" id="InvTotalOperativaLote" value=<?=$row->InvTotalOperativaLote?>>
			<input type="hidden" name="InvGanadoOperativoMuerteLote" id="InvGanadoOperativoMuerteLote" value=<?=$row->InvGanadoOperativoMuerteLote?>>
			<input type="hidden" name="UtilidadPerdidaLote" id="UtilidadPerdidaLote" value=<?=$row->UtilidadPerdidaLote?>>
			<input type="hidden" name="RentabilidadAnual" id="RentabilidadAnual" value=<?=$row->RentabilidadAnual?>>
			<input type="hidden" name="UtilidadPerdidaKgHechosCab" id="UtilidadPerdidaKgHechosCab" value=<?=$row->UtilidadPerdidaKgHechosCab?>>
			<input type="hidden" name="UtilidadPerdidaKgHecho" id="UtilidadPerdidaKgHecho" value=<?=$row->UtilidadPerdidaKgHecho?>>
			<input type="hidden" name="UtilidadPerdidaCabDifComVenKgHechos" id="UtilidadPerdidaCabDifComVenKgHechos" value=<?=$row->UtilidadPerdidaCabDifComVenKgHechos?>>
			<input type="hidden" name="UtilidadPerdidaCab" id="UtilidadPerdidaCab" value=<?=$row->UtilidadPerdidaCab?>>
			<input type="hidden" name="DiferenciaCompraVentaCab" id="DiferenciaCompraVentaCab" value=<?=$row->DiferenciaCompraVentaCab?>>
			<input type="hidden" name="InversionTotalOperativoCabDia" id="InversionTotalOperativoCabDia" value=<?=$row->InversionTotalOperativoCabDia?>>
			<input type="hidden" name="KgProducido" id="KgProducido" value=<?=$row->KgProducido?>>
			<input type="hidden" name="ValorEconomicoMermaInicialKg" id="ValorEconomicoMermaInicialKg" value=<?=$row->ValorEconomicoMermaInicialKg?>>
			<input type="hidden" name="UtilidadPerdidaCabT" id="UtilidadPerdidaCabT" value=<?=$row->UtilidadPerdidaCabT?>>
			<input type="hidden" name="PerdidaKgHechosNoVendidos" id="PerdidaKgHechosNoVendidos" value=<?=$row->PerdidaKgHechosNoVendidos?>>
		<?php } ?>
		<div id="btn_grafica">
			<table class="table">
		    <thead>
		        <tr>
		            <th>#</th>
		            <th>Variables</th>
		            <th>Rango</th>
		            <th>Valores</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
		            <td>1</td>
		            <td width="20%">Peso vivo inicial, kg:</td>
		        	<td width="60%"><label for="range">
						<input type="range" name="RPesoVivoIni" id="RPesoVivoIni" min="60" max="600" step="20" value=<?=$row->PesoVivoIni?>>
		        		</label>
		        	</td>
		        	<td width="20%"><output for="range" class="output"></output></td>
		        </tr>
		        <tr>
		            <td>2</td>
		            <td>Peso vivo orígen,kg:</td>
					<td><label for="range2">
						<input type="range" name="RPesoVivoOri" id="RPesoVivoOri" min="60" max="600" step="20" value=<?=$row->PesoVivoOri?>></label>
					</td>
					<td><output for="range2" class="output2"></output></td>
		        </tr>
		        <tr>
		            <td>3</td>
		            <td>Peso vivo salida, kg:</td>
		            <td><label for="range3">
						<input type="range" name="RPesoVivoSal" id="RPesoVivoSal" min="60" max="600" step="20" value=<?=$row->PesoVivoSal?>></label>
					</td>
					<td><output for="range3" class="output3"></output></td>
		        </tr>
		        <tr>
		            <td>4</td>
		            <td>Compra, $/kg:</td>
		            <td><label for="range4">
						<input type="range" name="RCompraKg" id="RCompraKg" min="0" max="100" step="1" value=<?=$row->CompraKg?>></label>
					</td>
					<td><output for="range4" class="output4"></output></td>
		        </tr>
		        <tr>
		            <td>5</td>
		            <td>Venta, $/kg:</td>
		            <td><label for="range5">
						<input type="range" name="RVentaKg" id="RVentaKg" min="0" max="100" step="1" value=<?=$row->VentaKg?>></label>
					</td>
					<td><output for="range5" class="output5"></output></td>
		        </tr>
		        <tr>
		            <td>6</td>
		            <td>Renta pradera, $/cab/día:</td>
					<td><label for="range6">
						<input type="range" name="RRentaPradera" id="RRentaPradera" min="0" max="10" step="1" value=<?=$row->RentaPradera?>></label>
					</td>
					<td><output for="range6" class="output6"></output></td>
				</tr>
		    </tbody>
			</table>
		</div>
		<div id="contenedor_graficas">
			<div id="grafica_1"></div>
			<div id="grafica_2"></div>
			<div id="grafica_3"></div>
			<div id="grafica_4"></div>
		</div>
	</div>
</div>
</section>