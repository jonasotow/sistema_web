var B62;
	var E6,B17,B18,valor_beccerras_criadas,
		B4,B7,numero_becerros_vendidos,
		B13,B12,B11,ingresos_por_becerros,
		numero_becerras_vendidos,
		B18,B17,B16,ingresos_por_becerras,
		B14,B19,ingresos_total_becerros_as,
		E4,numero_vientres_desecho,
		E12,E13,precio_cab_recuperado,
		E14,E11,precio_total_recuperado,
		B21,becerros_as_vendidas,
		contador_insumos=2,contador_mano_obra=2,contador_depreciacion=2,
		gCalculos,gCalculos2,gCalculos3,gCalculos4,gCalculos5,
		grafica2,grafica3,grafica4,grafica5;

$(document).ready(function(){

	//declaro la clase de los Calculos
	gCalculos = new GanaderiaInicializacion();
	leerDatos();
	alert(gCalculos2.B4);

	//calculations
	$("input").change(function(event) { leerDatos(); });

   //	insumos calculation
	var ins_suplemento_vientre_ano = []
	$("#insumos").delegate("input","change", function(event) {
		for (var i_insumos = 1; i_insumos < contador_insumos; i_insumos++) {
			B28 = $("#ins_precio_tonelada" + i_insumos).val()
			C28 = $("#ins_numero_dias" + i_insumos).val()
			D28 = $("#ins_kg_vientre_dia" + i_insumos).val()
			ins_calculo = D28*B28*C28/1000
			$("#ins_calculo" + i_insumos).val(ins_calculo)
			if ( $("#ins_calculo" + i_insumos).val() != 0 ) {
				ins_suplemento_vientre_ano[i_insumos] = $("#ins_calculo" + i_insumos).val()
			}
		}
		var	suplemento_vientre_ano = 0
		for (var i_ins = 1; i_ins < ins_suplemento_vientre_ano.length; i_ins++) {
			suplemento_vientre_ano = parseFloat(suplemento_vientre_ano) + parseFloat(ins_suplemento_vientre_ano[i_ins])
		}
		$("#ini_ins_suplemento_vientre_ano").val(suplemento_vientre_ano)
	})

	//	mano de obra calculation
	var man_total_precio_ano_hato = []
	var man_total_precio_ano_vientre = []
	$("#mano_obra").delegate("input","change", function(event) {
		for (var i_mano_obra = 1; i_mano_obra < contador_mano_obra; i_mano_obra++) {
			B44 = $("#man_precio_semana" + i_mano_obra).val()
			C44 = $("#man_numero" + i_mano_obra).val()
			D44 = $("#man_numero_semanas_ano" + i_mano_obra).val()
			man_calculo1 = B44*C44*D44
			man_calculo2 = man_calculo1/B4
			$("#man_total_hato" + i_mano_obra).val(man_calculo1)
			$("#man_total_vientre" + i_mano_obra).val(man_calculo2)
			if ( $("#man_total_hato" + i_mano_obra).val() != 0) {
					man_total_precio_ano_hato[i_mano_obra] = $("#man_total_hato" + i_mano_obra).val()
			}
			if ( $("#man_total_vientre" + i_mano_obra).val() != 0) {
					man_total_precio_ano_vientre[i_mano_obra] = $("#man_total_vientre" + i_mano_obra).val()
			}
		}
		var	total_precio_ano_hato_man = 0
		var	total_precio_ano_vientre_man = 0
		for (var i_man = 1; i_man < man_total_precio_ano_vientre.length; i_man++) {
			total_precio_ano_hato_man = parseFloat(total_precio_ano_hato_man) + parseFloat(man_total_precio_ano_hato[i_man])
			total_precio_ano_vientre_man = parseFloat(total_precio_ano_vientre_man) + parseFloat(man_total_precio_ano_vientre[i_man])
		}
		$("#ini_man_total_precio_ano_hato").val(total_precio_ano_hato_man)
		$("#ini_man_total_precio_ano_vientre").val(total_precio_ano_vientre_man)
	})
	//	depreciacion calculation
	var dep_total_precio_ano_hato = []
	var dep_total_precio_ano_vientre = []
	$("#depreciacion").delegate("input","change", function(event) {
		for (var i_depreciacion = 1; i_depreciacion < contador_depreciacion; i_depreciacion++) {
			B50 = $("#dep_precio_unitario" + i_depreciacion).val()
			C50 = $("#dep_anos" + i_depreciacion).val()
			dep_calculo1 = B50/C50
			dep_calculo2 = dep_calculo1/B4
			$("#dep_total_hato" + i_depreciacion).val(dep_calculo1)
			$("#dep_total_vinentre" + i_depreciacion).val(dep_calculo2)
			if ($("#dep_total_hato" + i_depreciacion).val() != 0) {
					dep_total_precio_ano_hato[i_depreciacion] = $("#dep_total_hato" + i_depreciacion).val()
			}
			if ($("#dep_total_vinentre" + i_depreciacion).val() != 0) {
					dep_total_precio_ano_vientre[i_depreciacion] = $("#dep_total_vinentre" + i_depreciacion).val()
			}
		}
		var	total_precio_ano_hato_dep = 0
		var	total_precio_ano_vientre_dep = 0
		for (var i_dep = 1; i_dep < dep_total_precio_ano_vientre.length; i_dep++) {
			total_precio_ano_hato_dep = parseFloat(total_precio_ano_hato_dep) + parseFloat(dep_total_precio_ano_hato[i_dep])
			total_precio_ano_vientre_dep = parseFloat(total_precio_ano_vientre_dep) + parseFloat(dep_total_precio_ano_vientre[i_dep])
		}
		$("#ini_dep_total_precio_ano_hato").val(total_precio_ano_hato_dep)
		$("#ini_dep_total_precio_ano_vientre").val(total_precio_ano_vientre_dep)
	})
	//End calculations
	//valores Escenarios:
		$(".valores_escenarios").change(function(event) {
			$( "#" + $(this).attr('name')).text($(this).val());
		});
	//End 
	
	//graficas
		grafica2 = copyObj(grafica);
		grafica3 = copyObj(grafica);
		grafica4 = copyObj(grafica);
		grafica5 = copyObj(grafica);

	$("#btn_mostrar_escenario").click(function(event) {
		grafica.series[1].data = [1, 1.9, 1.5, 1.5, 1.2, 1];
		$('#grafica_1').highcharts(grafica);	
		grafica2.series[1].data = [2.0, 2.9, 2.5, 2.5, 2.2, 2];
		$('#grafica_2').highcharts(grafica2);
		grafica3.series[1].data = [3.0, 3.9, 3.5, 3.5, 3.2, 3];
		$('#grafica_3').highcharts(grafica3);
		grafica4.series[1].data = [4.0, 4.9, 4.5, 4.5, 4.2, 4];
		$('#grafica_4').highcharts(grafica4);
		grafica5.series[1].data = [5.0, 5.9, 5.5, 5.5, 5.2, 5];
		$('#grafica_5').highcharts(grafica5);
	});

		gCalculos2.B4 = 50;
		gCalculos2.CalculosInicializacion();
		gCalculos3.B4 = 60;
		gCalculos3.CalculosInicializacion();
		gCalculos4.B4 = 70;
		gCalculos4.CalculosInicializacion();
		gCalculos5.B4 = 80;
		gCalculos5.CalculosInicializacion();
		gCalculos6.B4 = 90;
		gCalculos6.CalculosInicializacion();

		grafica.series[0].data = [gCalculos6.B4, 1.9, 1.5, 1.5, 1.2, 1];
		$('#grafica_1').highcharts(grafica);	
		grafica2.series[0].data = [2.0, 2.9, 2.5, 2.5, 2.2, 2];
		$('#grafica_2').highcharts(grafica2);
		grafica3.series[0].data = [3.0, 3.9, 3.5, 3.5, 3.2, 3];
		$('#grafica_3').highcharts(grafica3);
		grafica4.series[0].data = [4.0, 4.9, 4.5, 4.5, 4.2, 4];
		$('#grafica_4').highcharts(grafica4);
		grafica5.series[0].data = [5.0, 5.9, 5.5, 5.5, 5.2, 5];
		$('#grafica_5').highcharts(grafica5);

});

/*
grafica2.series[0].data = [0, 0, 0, 0, 0, {
					                      y: 0,
					                      marker: {
					                          symbol: 'url(' + base_url + '/assets/img/bioeconomico/punto_verde.png)'
					                      }
					                  }];
 */
var leerDatos = function(){

		gCalculos.CalculosInicializacion();
		gCalculos.E6  = $("#ini_ree_numero_criadas").val();
		gCalculos.B17 = $("#ini_des_peso_vivo_venta_a").val();
		gCalculos.B18 = $("#ini_des_precio_kg_vendido_a").val();
		gCalculos.B4  = $("#ini_vie_numero_vientres").val();
		gCalculos.B7  = $("#ini_vie_porcentaje_destete").val();
		gCalculos.B13 = $("#ini_des_precio_kg_vendido").val();
		gCalculos.B12 = $("#ini_des_peso_vivo_venta").val();
		gCalculos.E4  = $("#ini_ree_numero_compradas").val();
		gCalculos.E12 = $("#ini_dese_peso_vivo_venta_kg").val();
		gCalculos.E13 = $("#ini_dese_precio_kg_desecho").val();
		gCalculos.B36 = $("#ins_precio_dia_agostadero").val();
		gCalculos.C36 = $("#ins_numero_dias_agostadero").val();
		gCalculos.B57 = $("#ini_inv_numero_sementales").val();
		gCalculos.B58 = $("#ini_inv_precio_semental").val();
		gCalculos.B60 = $("#ini_inv_numero_ano_servicio").val();
		gCalculos.B61 = $("#ini_inv_precio_recuperacion_cap").val();
		gCalculos.B6  = $("#ini_vie_precio_vientre").val();
		gCalculos.B67 = $("#ini_inv_tasa_interes_anual").val();
		gCalculos.E34 = $("#ini_ins_suplemento_vientre_ano").val();
		gCalculos.F47 = $("#ini_man_total_precio_ano_vientre").val();
		gCalculos.F54 = $("#ini_dep_total_precio_ano_vientre").val();
		gCalculos.B64 = $("#ini_inv_precio_cab_ano_ensiminacion").val();
		gCalculos.B65 = $("#ini_inv_meds-trats_precio_vientre_ano").val();
		gCalculos.E47 = $("#ini_man_total_precio_ano_hato").val();
		gCalculos.E54 = $("#ini_dep_total_precio_ano_hato").val();

		$("#ini_ree_valor_becerras_criadas_precio_cab").val(gCalculos.valor_becerras_criadas);
    $("#ini_des_numero_becerros_vendidos").val(gCalculos.numero_becerros_vendidos);
    $("#ini_des_ingresos_por_becerros").val(gCalculos.ingresos_por_becerros);
    $("#ini_des_numero_becerras_vendidos_a").val(gCalculos.numero_becerras_vendidos);
    $("#ini_des_ingresos_por_becerras").val(gCalculos.ingresos_por_becerras);
    $("#ini_des_ingreso_total_becerros_as").val(gCalculos.ingresos_total_becerros_as);
    $("#ini_dese_numero_vintres_desecho").val(gCalculos.numero_vientres_desecho);
    $("#ini_dese_precio_cab_recuperado").val(gCalculos.precio_cab_recuperado);
    $("#ini_dese_precio_total_recuperacion").val(gCalculos.precio_total_recuperado);
    $("#ini_dese_recuperacion_sementales_ano").val(gCalculos.recuperacion_sementales_ano);
    $("#ini_dese_total_ingreso_ano").val(gCalculos.total_ingreso_ano);
    $("#ini_ing_vi_becerros_as_vendido").val(gCalculos.vi_becerros_as_vendidas);
    $("#ini_ing_vi_recuperado_ano_precio").val(gCalculos.vi_recuperacion_vientre_precio);
    $("#ini_ing_vi_recuperado_vientre_precio").val(gCalculos.vi_ini_ing_recuperado_vie_sem_precio);
    $("#ini_ing_vi_recuperado_vie_sem_precio").val(gCalculos.ha_becerros_as_vendidas);
    $("#ini_ing_ha_becerros_as_vendido").val(gCalculos.ha_vientre_recuperacion_ano_precio);
    $("#ini_ing_ha_recuperado_ano_precio").val(gCalculos.ha_recuperacion_vientre_precio);
    $("#ini_ing_ha_recuperado_vientre_precio").val(gCalculos.ha_ini_ing_recuperado_vie_sem_precio);
    $("#ini_ing_ha_recuperado_vie_sem_precio").val(gCalculos.ha_ini_ing_recuperado_vie_sem_precio);
    $("#ins_calculo_agostadero").val(gCalculos.calculo_agostadero);
    $("#ini_inv_precio_sementales").val(gCalculos.inv_precio_sementales);
    $("#ini_inv_precio_recuperacion_total_ano").val(gCalculos.inv_precio_recuperacion_total_ano);
    $("#ini_inv_precio_empadre_vaca_ano").val(gCalculos.inv_precio_empadre_vaca_ano);
    $("#ini_inv_interes_animales_precio_cab").val(gCalculos.inv_interes_animales_precio_cab);
    $("#ini_inv_interes_operativo_precio_cab").val(gCalculos.inv_interes_operativo_precio_cab);
    $("#ini_ch_vi_precio_alimento_suplementario").val(gCalculos.ch_vi_precio_alimento_suplementario);
    $("#ini_ch_vi_precio_agostadero").val(gCalculos.ch_vi_precio_agostadero);
    $("#ini_ch_vi_precio_mano_obra").val(gCalculos.ch_vi_precio_mano_obra);
    $("#ini_ch_vi_precio_depreciacion").val(gCalculos.ch_vi_precio_depreciacion);
    $("#ini_ch_vi_precio_empadre_vaca_ano").val(gCalculos.ch_vi_precio_empadre_vaca_ano);
    $("#ini_ch_vi_precio_cab_ano_enseminacion").val(gCalculos.ch_vi_precio_cab_ano_enseminacion);
    $("#ini_ch_vi_meds-trats_precio_vientre_ano").val(gCalculos.ch_vi_meds_trats_precio_vientre_ano);
    $("#ini_ch_vi_interes_animales_precio_cab").val(gCalculos.ch_vi_interes_animales_precio_cab);
    $("#ini_ch_vi_interes_operativo_precio_cab").val(gCalculos.ch_vi_interes_operativo_precio_cab);
    $("#ini_ch_vi_precio_total_vientre").val(gCalculos.ch_vi_precio_total_vientre);
    $("#ini_ch_ha_precio_alimento_suplementario").val(gCalculos.ch_ha_precio_alimento_suplementario);
    $("#ini_ch_ha_precio_agostadero").val(gCalculos.ch_ha_precio_agostadero);
    $("#ini_ch_ha_precio_mano_obra").val(gCalculos.ch_ha_precio_mano_obra);
    $("#ini_ch_ha_precio_depreciacion").val(gCalculos.ch_ha_precio_depreciacion);
    $("#ini_ch_ha_precio_empadre_vaca_ano").val(gCalculos.ch_ha_precio_empadre_vaca_ano);
    $("#ini_ch_ha_precio_cab_ano_enseminacion").val('2');
    $("#ini_ch_ha_meds-trats_precio_vientre_ano").val(gCalculos.ch_ha_meds_trats_precio_vientre_ano);
    $("#ini_ch_ha_interes_animales_precio_cab").val(gCalculos.ch_ha_interes_animales_precio_cab);
    $("#ini_ch_ha_interes_operativo_precio_cab").val(gCalculos.ch_ha_interes_operativo_precio_cab);
    $("#ini_ch_ha_precio_total_vientre").val(gCalculos.ch_ha_precio_total_vientre);
    $("#ini_up_na_ingreso_kg_destetado").val(gCalculos.up_na_ingreso_kg_destetado);
    $("#ini_up_na_costo_produccion_kg_becerro").val(gCalculos.up_na_costo_produccion_kg_becerro);
    $("#ini_up_na_vientre").val(gCalculos.up_na_vientre);
    $("#ini_up_na_hato").val(gCalculos.up_na_hato);
    $("#ini_up_na_kg_destetado").val(gCalculos.up_na_kg_destetado);
    $("#ini_up_ve_ingreso_kg_destetado").val(gCalculos.up_ve_ingreso_kg_destetado);
    $("#ini_up_ve_costo_produccion_kg_becerro").val(gCalculos.up_ve_costo_produccion_kg_becerro);
    $("#ini_up_ve_vientre").val(gCalculos.up_ve_vientre);
    $("#ini_up_ve_hato").val(gCalculos.up_ve_hato);
    $("#ini_up_ve_kg_destetado").val(gCalculos.up_ve_kg_destetado);

    gCalculos2 = copyObj(gCalculos);
		gCalculos3 = copyObj(gCalculos);
		gCalculos4 = copyObj(gCalculos);
		gCalculos5 = copyObj(gCalculos);
		gCalculos6 = copyObj(gCalculos);

};