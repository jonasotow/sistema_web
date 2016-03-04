$( document ).ready(function() {
  $("input[type='date']").datepicker();
  /* slider */
  $('#RPesoVivoIni').on("change", function() {
    $('.output').val(this.value +" KG" );
  }).trigger("change");
  $('#RPesoVivoOri').on("change", function() {
    $('.output2').val(this.value +" KG" );
  }).trigger("change");
  $('#RPesoVivoSal').on("change", function() {
    $('.output3').val(this.value +" KG" );
  }).trigger("change");
  $('#RCompraKg').on("change", function() {
    $('.output4').val("$ " + this.value);
  }).trigger("change");
  $('#RVentaKg').on("change", function() {
    $('.output5').val("$ " + this.value);
  }).trigger("change");
  $('#RRentaPradera').on("change", function() {
    $('.output6').val("$ " + this.value);
  }).trigger("change");
  
  /* slider */
  $("#Muertes").append("<div id='referencia0'><div class='form-group'><label for='FechaMuerte'>Fecha Muerte 1:</label><input id='FechaMuerte' class='form-control hasDatepicker' type='date' onchange='muertes()' size='10' maxlength='10' value='' name='FechaMuerte[]'></div><div class='form-group'>&nbsp;&nbsp;<label for='NumeroMuerte'>Numero de Muertes:</label>&nbsp;<input id='NumeroMuerte' class='form-control' type='number' onchange='calculos()' size='5' maxlength='5' value='' name='NumeroMuerte[]'></div><div class='form-group'>&nbsp;&nbsp;<label for='MuertosPradera'>Dias en Pradera:</label><input id='MuertosPradera0' class='form-control' type='text' readonly required='' size='5' maxlength='5' value='' name='MuertosPradera[]'></div><div class='form-group'>&nbsp;&nbsp;<label for='DiasInvertidos'>Dias Invertidos:</label><input id='DiasInvertidos0' class='form-control' type='text' required='' size='5' maxlength='5' value='' name='DiasInvertidos[]' readonly></div><div class='form-group'><button name='Guardar' onclick='CamposMuertes()' type='button' id='guardar_especie' class='btn btn-primary'>+</button></div></div>");
  $("#Suplementos").append("<div class='form-group'>&nbsp;<label for='Suplemento'>Suplemento:</label><select class='form-control' name='Suplemento[]'><option selected='selected' value=''>Seleccione un suplemento</option><option value='mineral'>Mineral</option><option value='concentrado'>Concentrado</option><option value='forraje'>Forraje</option><option value='otro'>Otro</option></select></div><div class='form-group'>&nbsp;<label for='PrecioKg'>$/kg:</label><input onKeyUp='calculos()' id='PrecioKg' class='form-control' type='text' size='5' maxlength='5' value='' name='PrecioKg[]'></div><div class='form-group'>&nbsp;&nbsp;<label for='ConsumoKgCabDia'>Consumo kg/cab/día:</label><input id='ConsumoKgCabDia' class='form-control' type='text' size='5' maxlength='5' value='' name='ConsumoKgCabDia[]' onKeyUp='calculos()'></div><div class='form-group'>&nbsp;&nbsp;<label for='Nodias'>No días:</label><input id='Nodias' class='form-control' type='number' onchange='calculos()' size='5' maxlength='5' value='' name='Nodias[]'></div>&nbsp;&nbsp;<div class='form-group'><label for='PLote'>$/lote:</label><input id='PLote0' readonly class='form-control' type='text' size='5' maxlength='5' value='' name='PLote[]'><div class='form-group'><button name='Guardar' onclick='CamposSuplementos()' type='button' id='guardar_especie' class='btn btn-primary'>+</button></div></div>");
  var href = $(location).attr('href');
  var hrefinverso = href.split('').reverse().join('');
  var res = hrefinverso.split("/",1); 
  $("#botones").append("<div class='form-group'><a href='../grafica/" + res + "'><button name='graficar' type='button' id='boton1' class='btn btn-primary'>Graficar</button></a></div>");
  $("#btn_grafica").append("<button type='button' class='btn btn-primary' onclick='crear_escenario()'>Crear escenario</button>");
  for (var i = 1; i <= 10; i++) {
    $( "#slider-range-min" + i ).slider({
        animate: "fast",
        range: "min",
        value: 350,
        min: 1,
        max: 700,
        slide: function( event, ui ) {
          $( "#amount" + i ).val( ui.value )
        }
      })
      $( "#amount" + i).val( $( "#slider-range-min" + i).slider( "value" ) )
    }
});

function crear_escenario(){
  var Pvikg = $("#RPesoVivoIni").val();
  var Pvokg = $("#RPesoVivoOri").val();
  var Pvskg = $("#RPesoVivoSal").val();
  var Ckg = $("#RCompraKg").val();
  var Vkg = $("#RVentaKg").val();
  var Rpcd = $("#RRentaPradera").val();
  $('#grafica_1').highcharts({
    chart: {
            type: 'spline',
        },
        title: {
            text: 'Utilidad o pérdida en los kgs hechos, $/cab'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
           categories: ['2', '4', '6', '8', '10']
        },
        yAxis: {
            title: {
                text: '$'
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true,
     //            valueSuffix: 'R'
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 3,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Utilidad/perdida',
            marker: {
                symbol: 'square'
            },
            data: [1000,3000,6000,9000,12000,15000, {
            y: parseInt(Ckg),
            marker: {
              symbol: 'url(' + base_url + '/assets/img/bioeconomico/punto_verde.png)'
            }
          }]
        }]
    });
}

$(function () {
  var GUtilidadPerdidaKgHechosCab = parseInt($("#UtilidadPerdidaKgHechosCab").val());
  var GUtilidadPerdidaKgHecho = parseFloat($("#UtilidadPerdidaKgHecho").val());
  var GPesoVivoIni = $("#PesoVivoIni").val();
  var GPesoVidaSalidaReal = $("#PesoVidaSalidaReal").val();
  var GNoDiasFechas = $("#NoDiasFechas").val();
  var GInversionTotalOperativoCabDia = $("#InversionTotalOperativoCabDia").val();
  var GVentaKg = $("#VentaKg").val();
  $('#grafica_1').highcharts({
    chart: {
            type: 'spline',
        },
        title: {
            text: 'Utilidad o pérdida en los kgs hechos, $/cab'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
           categories: ['2', '4', '6', '8', '10','12']
        },
        yAxis: {
            title: {
                text: 'Utilidad por KG / Cab'
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true,
     //            valueSuffix: 'R'
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 3,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Utilidad/perdida $',
            marker: {
                symbol: 'square'
            },
            data: [1000,3000,6000,9000,12000, {
             y: GUtilidadPerdidaKgHechosCab,
            marker: {
              symbol: 'url(' + base_url + '/assets/img/bioeconomico/punto_verde.png)'
            }
          }]
        }]
    });
  ////////////////////////////////////////////////////////////////////////////////
  /* CALCULO PESO VIVO INICIAL 160 */
  var GTCKGV = GPesoVidaSalidaReal - 160;
  var GDP = GTCKGV / GNoDiasFechas;
  var KGP = GInversionTotalOperativoCabDia / GDP;
  var UPKGH160 = GVentaKg - KGP;
  /* CALCULO PESO VIVO INICIAL 200 */
  var GTCKGV2 = GPesoVidaSalidaReal - 200;
  var GDP2 = GTCKGV2 / GNoDiasFechas;
  var KGP2 = GInversionTotalOperativoCabDia / GDP2;
  var UPKGH200 = GVentaKg - KGP2;
  /* CALCULO PESO VIVO INICIAL 240 */
  var GTCKGV3 = GPesoVidaSalidaReal - 240;
  var GDP3 = GTCKGV3 / GNoDiasFechas;
  var KGP3 = GInversionTotalOperativoCabDia / GDP3;
  var UPKGH240 = GVentaKg - KGP3;
  /* CALCULO PESO VIVO INICIAL 280 */
  var GTCKGV4 = GPesoVidaSalidaReal - 280;
  var GDP4 = GTCKGV4 / GNoDiasFechas;
  var KGP4 = GInversionTotalOperativoCabDia / GDP4;
  var UPKGH280 = GVentaKg - KGP4;
  /* CALCULO PESO VIVO INICIAL 320 */
  var GTCKGV5 = GPesoVidaSalidaReal - 320;
  var GDP5 = GTCKGV5 / GNoDiasFechas;
  var KGP5 = GInversionTotalOperativoCabDia / GDP5;
  var UPKGH320 = GVentaKg - KGP5;
  /* CALCULO PESO VIVO INICIAL 320 */
  var GTCKGV6 = GPesoVidaSalidaReal - 360;
  var GDP6 = GTCKGV6 / GNoDiasFechas;
  var KGP6 = GInversionTotalOperativoCabDia / GDP6;
  var UPKGH360 = GVentaKg - KGP6;
  UPKGH160 = Math.round(UPKGH200 * 100) / 100;
  UPKGH200 = Math.round(UPKGH200 * 100) / 100;
  UPKGH240 = Math.round(UPKGH240 * 100) / 100;
  UPKGH280 = Math.round(UPKGH280 * 100) / 100;
  UPKGH320 = Math.round(UPKGH320 * 100) / 100;
  UPKGH360 = Math.round(UPKGH360 * 100) / 100;
  /* OPERACIONES PARA GRAFICA */
  var RangoKg;
  var RangoPrecio;
  if (GPesoVivoIni > 160 && GPesoVivoIni < 200){
    RangoKg = ["160", GPesoVivoIni, "200", "240", "280", "320", "360 KG"];
    RangoPrecio = [UPKGH160, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            }, UPKGH200,UPKGH240,UPKGH280,UPKGH320,UPKGH360];
  } else if (GPesoVivoIni > 200 && GPesoVivoIni < 240){
    RangoKg = ["160 KG", "200 KG", GPesoVivoIni + " KG" , "240 KG", "280 KG", "320 KG", "360 KG"];
    RangoPrecio = [UPKGH160,UPKGH200, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            }, UPKGH240,UPKGH280,UPKGH320,UPKGH360];
  } else if (GPesoVivoIni > 240 && GPesoVivoIni < 280){
    RangoKg = ["160", "200", "240", GPesoVivoIni , "280", "320", "360"];
    RangoPrecio = [UPKGH160,UPKGH200,UPKGH240, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            } ,UPKGH280,UPKGH320,UPKGH360];
  } else if (GPesoVivoIni > 280 && GPesoVivoIni < 320){
    RangoKg = ["160", "200", "240", "280", GPesoVivoIni , "320", "360"];
    RangoPrecio = [UPKGH160,UPKGH200,UPKGH240,UPKGH280, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            } ,UPKGH320,UPKGH360];
  } else if (GPesoVivoIni > 320 && GPesoVivoIni < 360){
    RangoKg = ["160", "200", "240", "280", "320", GPesoVivoIni , "360"]; 
    RangoPrecio = [UPKGH160,UPKGH200,UPKGH240,UPKGH280,UPKGH320, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            } ,UPKGH360];
  } else if (GPesoVivoIni > 360){
    RangoKg = ["160", "200", "240", "280", "320", "360", GPesoVivoIni]; 
    RangoPrecio = [UPKGH160,UPKGH200,UPKGH240,UPKGH280,UPKGH320,UPKGH360, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            }];
  }

  /* OPERACIONES PARA GRAFICA */
  $('#grafica_2').highcharts({
        chart: {
            type: 'line',
        },
        title: {
            text: 'Utilidad o pérdida / kg hecho'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
          categories: RangoKg
        },
        yAxis: {
            title: {
                text: 'Utilidad por KG'
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true,
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            },
            line: {
              dataLabels: {
                enabled: true
              }
            }
        },
        series: [{
            name: 'Utilidad/perdida $',
            marker: {
                symbol: 'square'
            },
            data: RangoPrecio,

        }]
    });
    ////////////////////////////////////////////////////////////////////////////////
    var RangoKg3;
    var RangoPrecio3;
    var GUtilidadPerdidaCabDifComVenKgHechos = parseInt($("#UtilidadPerdidaCabDifComVenKgHechos").val());
    if (GPesoVivoIni > 160 && GPesoVivoIni < 200){
    RangoKg3 = ["160", GPesoVivoIni, "200", "240", "280", "320", "360 KG"];
    RangoPrecio3 = [UPKGH160, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            }, UPKGH200,UPKGH240,UPKGH280,UPKGH320,UPKGH360];
  } else if (GPesoVivoIni > 200 && GPesoVivoIni < 240){
    RangoKg3 = ["160 KG", "200 KG", GPesoVivoIni + " KG" , "240 KG", "280 KG", "320 KG", "360 KG"];
    RangoPrecio3 = [UPKGH160,UPKGH200, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            }, UPKGH240,UPKGH280,UPKGH320,UPKGH360];
  } else if (GPesoVivoIni > 240 && GPesoVivoIni < 280){
    RangoKg3 = ["160", "200", "240", GPesoVivoIni , "280", "320", "360"];
    RangoPrecio3 = [UPKGH160,UPKGH200,UPKGH240, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            } ,UPKGH280,UPKGH320,UPKGH360];
  } else if (GPesoVivoIni > 280 && GPesoVivoIni < 320){
    RangoKg3 = ["160", "200", "240", "280", GPesoVivoIni , "320", "360"];
    RangoPrecio3 = [UPKGH160,UPKGH200,UPKGH240,UPKGH280, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            } ,UPKGH320,UPKGH360];
  } else if (GPesoVivoIni > 320 && GPesoVivoIni < 360){
    RangoKg3 = ["160", "200", "240", "280", "320", GPesoVivoIni , "360"]; 
    RangoPrecio3 = [UPKGH160,UPKGH200,UPKGH240,UPKGH280,UPKGH320, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            } ,UPKGH360];
  } else if (GPesoVivoIni > 360){
    RangoKg3 = ["160", "200", "240", "280", "320", "360", GPesoVivoIni]; 
    RangoPrecio3 = [UPKGH160,UPKGH200,UPKGH240,UPKGH280,UPKGH320,UPKGH360, {
                y: GUtilidadPerdidaKgHecho,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/moneda.png)'
                }
            }];
  }
    $('#grafica_3').highcharts({
        chart: {
            type: 'spline',
      //            marginRight: 130,    
      //            marginBottom: 25
        },
        title: {
            text: 'Utilidad o pérdida / cab, dif com-ven + kg hechos'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
           RangoKg3
        },
        yAxis: {
            title: {
                text: ''
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true,
     //            valueSuffix: 'R'
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 3,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Utilidad/perdida',
            marker: {
                symbol: 'square'
            },
            data: RangoPrecio3,

        }]
    });
    ///////////////////////////////////////////////////////////////////////////7
    var GUtilidadPerdidaCab = parseInt($("#UtilidadPerdidaCab").val());
    $('#grafica_4').highcharts({
        chart: {
            type: 'spline',
      //            marginRight: 130,    
      //            marginBottom: 25
        },
        title: {
            text: 'Utilidad o pérdida $ / cab'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
           categories: ['2', '4', '6', '8', '10']
        },
        yAxis: {
            title: {
                text: ''
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true,
     //            valueSuffix: 'R'
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 3,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        series: [{
            name: 'Utilidad/perdida',
            marker: {
                symbol: 'square'
            },
            data: [7.0, 6.9, 9.5, 18.2, 21.5, 25.2, {
                y: GUtilidadPerdidaCab,
                marker: {
                    symbol: 'url(' + base_url + '/assets/img/bioeconomico/punto_verde.png)'
                }
            }]

        }]
    });
});

var counter = 0;
var counter2 = 0;
function CamposMuertes(){
  $("#Muertes").append("<div id='referencia" + (counter + 1) + "'><div class='form-group'><label for='FechaMuerte'>Fecha Muerte " + (counter + 2) + ":</label><input id='FechaMuerte' class='form-control hasDatepicker' type='date' onchange='muertes()' required='' size='10' maxlength='10' value='' name='FechaMuerte[]'></div><div class='form-group'>&nbsp;&nbsp;<label for='NumeroMuerte'>Numero de Muertes:</label>&nbsp;<input id='NumeroMuerte' class='form-control' type='number' onchange='calculos()' required='' size='5' maxlength='5' value='' name='NumeroMuerte[]'></div><div class='form-group'>&nbsp;&nbsp;<label for='MuertosPradera'>Dias en Pradera:</label><input readonly id='MuertosPradera" + (counter + 1) + "' class='form-control' type='text' required='' size='5' maxlength='5' value='' name='MuertosPradera[]'></div><div class='form-group'>&nbsp;&nbsp;<label for='DiasInvertidos'>Dias Invertidos:</label><input readonly id='DiasInvertidos" + (counter + 1) + "' class='form-control' type='text' required='' size='5' maxlength='5' value='' name='DiasInvertidos[]'></div><div class='form-group'><button name='Guardar' onclick='EliminarCampoMuertes(" + (counter + 1) +")' type='button' id='eliminar_div' class='btn btn-primary'>-</button></div></div>");
  counter++;
}
function EliminarCampoMuertes(contador){
  var r = confirm("Deseas eliminar la linea #" + (contador + 1) + "?");
  if (r == true) {
    if(contador < counter){
      alert("No es posible eliminar esta linea, elimine la ultima agregada!");
    }else{
      $('div').remove('#referencia'+contador);
      counter--;
    }
  }
}
function EliminarCampoSuplementos(contador){
  var r = confirm("Deseas eliminar la linea #" + (contador + 1) + "?");
  if (r == true) {
    if(contador < counter2){
      alert("No es posible eliminar esta linea, elimine la ultima agregada!");
    }else{
      $('div').remove('#referencia2'+contador);
      counter2--;
    }
  }
}
function CamposSuplementos(){
  $("#Suplementos").append("<div id='referencia2" + (counter2 + 1) + "'><div class='form-group'>&nbsp;<label for='Suplemento'>Suplemento:</label><select class='form-control' required='' name='Suplemento[]'><option selected='selected' value=''>Seleccione un suplemento</option><option value='mineral'>Mineral</option><option value='concentrado'>Concentrado</option><option value='forraje'>Forraje</option><option value='otro'>Otro</option></select></div><div class='form-group'>&nbsp;<label for='PrecioKg'>$/kg:</label><input onKeyUp='calculos()' id='PrecioKg' class='form-control' type='text' required='' size='5' maxlength='5' value='' name='PrecioKg[]'></div><div class='form-group'>&nbsp;&nbsp;<label for='ConsumoKgCabDia'>Consumo kg/cab/día:</label><input id='ConsumoKgCabDia' class='form-control' type='text' required='' size='5' maxlength='5' value='' name='ConsumoKgCabDia[]' onKeyUp='calculos()'></div><div class='form-group'>&nbsp;&nbsp;<label for='Nodias'>No días:</label><input id='Nodias' class='form-control' type='number' onchange='calculos()' required='' size='5' maxlength='5' value='' name='Nodias[]'></div>&nbsp;&nbsp;<div class='form-group'><label for='PLote'>$/lote:</label><input id='PLote" + (counter2 + 1) + "' readonly class='form-control' type='text' required='' size='5' maxlength='5' value='' name='PLote[]'><div class='form-group'><button name='Guardar' onclick='EliminarCampoSuplementos(" + (counter2 + 1) +")' type='button' id='eliminar_div' class='btn btn-primary'>-</button></div></div>");
  counter2++;
}

function bd(v1,v2,v3,v4){
  /*  No. Cabezas -> v1 
      No. Dias    -> v2
      Peso Vivo Inicial -> v3
      Peso Vivo Origen  -> v4
  */ 
  var bdMerma = ((v4 - v3) / v4) * 100;
  alert(bdMerma);
}

/* Calcular Formulario */
function calculos(){
  var nocabezas = $("#nocabezas").val();
  var InvFinal = nocabezas;
  var fechaentrada = $("#fechaentrada").val();
  var fechasalida = $("#fechasalida").val();
  var PesoVivoIni = $("#PesoVivoIni").val();
  var PesoVivoOri = $("#PesoVivoOri").val();
  var PesoVivoSal = $("#PesoVivoSal").val();
  var DesctoPv = $("#DesctoPv").val();
  var FechaMuerte = $("input[id='FechaMuerte']").map(function(){ return $(this).val(); }).get();
  var NumeroMuerte = $("input[id='NumeroMuerte']").map(function(){ return $(this).val(); }).get();
  var PrecioKg = $("input[id='PrecioKg']").map(function(){ return $(this).val(); }).get();
  var ConsumoKgCabDia = $("input[id='ConsumoKgCabDia']").map(function(){ return $(this).val(); }).get();
  var Nodias = $("input[id='Nodias']").map(function(){ return $(this).val(); }).get();
  var Pastoreo = 0;
  var TotalPastoreoAlimentoLote = $("#TotalPastoreoAlimentoLote").val();
  var RentaPradera = $("#RentaPradera").val();
  var AlimentacionTotal = $("#AlimentacionTotal").val();
  alert(FechaMuerte);
  try{
    //alert(new Date(new Date(fechaentrada) - new Date(fechasalida)).getDay());
    /*Calculo campo No. Dias Lote -----------------------------------*/
    fechaentrada = fechaentrada.split('/');
    fechasalida = fechasalida.split('/');
    var dat2 = new Date(fechasalida[2], parseFloat(fechasalida[1])-1, parseFloat(fechasalida[0]));
    var dat1 = new Date(fechaentrada[2], parseFloat(fechaentrada[1])-1, parseFloat(fechaentrada[0]));
    var fin = dat2.getTime() - dat1.getTime();
    var dias = Math.floor(fin / (1000 * 60 * 60 * 24)) 
    var ventakg = $("#VentaKg").val();
    var CompraKg = $("#CompraKg").val();
    $("#NoDiasFechas").val(isNaN(parseInt(dias)) ? 0 : parseInt(dias));
    /*Calculo campo No. Dias Lote -----------------------------------*/
    /*Calculo % Merma -----------------------------------------------*/
    var merma = ((PesoVivoOri - PesoVivoIni) / PesoVivoOri) * 100;
    $("#Merma").val(isNaN(parseFloat(merma)) ? 0 : parseFloat(merma));
    /*Calculo % Merma -----------------------------------------------*/
    /*Calculo Peso Vivo Sal. Real -----------------------------------*/
    var PesoVidaSalReal = PesoVivoSal-(PesoVivoSal*(DesctoPv/100));
    $("#PesoVidaSalidaReal").val(isNaN(parseFloat(PesoVidaSalReal)) ? 0 : parseFloat(PesoVidaSalReal));
    /*Calculo Peso Vivo Sal. Real -----------------------------------*/
    /*Calculo Ganancias Total Cab. Kg -------------------------------*/
    var GananciaTotalCabKg = PesoVidaSalReal - PesoVivoIni;
    $("#GanciaTotalCabKilos").val(isNaN(parseFloat(GananciaTotalCabKg)) ? 0 : parseFloat(GananciaTotalCabKg));
    /*Calculo Ganancias Total Cab. Kg -------------------------------*/
    /*Calcula el bloque de muertes ----------------------------------*/
    $.each(FechaMuerte, function(index, value) {
      var fecha = value.split('/');
      var dat4 = new Date(fecha[2], parseFloat(fecha[1])-1, parseFloat(fecha[0]));
      var dat3 = new Date(fechaentrada[2], parseFloat(fechaentrada[1])-1, parseFloat(fechaentrada[0]));
      var fin2 = dat4.getTime() - dat3.getTime();
      var diasM = Math.floor(fin2 / (1000 * 60 * 60 * 24))
      var DiasInvertidos = diasM * NumeroMuerte[index];  
      InvFinal = InvFinal - NumeroMuerte[index];
      var DiasCabCiclo = (nocabezas * dias) - DiasInvertidos;
      $("#MuertosPradera" + index).val(isNaN(parseInt(diasM)) ? 0 : parseInt(diasM));
      $("#DiasInvertidos" + index).val(isNaN(parseInt(DiasInvertidos)) ? 0 : parseInt(DiasInvertidos));
      $("#InvFinal").val(isNaN(parseInt(InvFinal)) ? 0 : parseInt(InvFinal));
      $("#DiasCabCiclo").val(isNaN(parseFloat(DiasCabCiclo)) ? 0 : parseFloat(DiasCabCiclo));
    });
    /*Calcula el bloque de muertes ----------------------------------*/
    /*Calcula Ganancia Lote -----------------------------------------*/
    var GananciaTotalLoteKg = GananciaTotalCabKg * InvFinal;
    $("#GananciaTotalLote").val(isNaN(parseFloat(GananciaTotalLoteKg)) ? 0 : parseFloat(GananciaTotalLoteKg));
    /*Calcula Ganancia Lote -----------------------------------------*/
    /*Calcula Gdp ---------------------------------------------------*/
    var Gdp = GananciaTotalCabKg / dias; 
    $("#Gdp").val(isNaN(parseFloat(Gdp)) ? 0 : parseFloat(Gdp));
    /*Calcula Gdp ---------------------------------------------------*/
    /*Calcula Ingreso Lote ------------------------------------------*/
    var IngresoLote = (ventakg * PesoVidaSalReal * InvFinal);
    $("#IngresoLote").val(isNaN(parseFloat(IngresoLote)) ? 0 : parseFloat(IngresoLote));
    /*Calcula Ingreso Lote ------------------------------------------*/
    /*Calcula Ingreso Cabeza ----------------------------------------*/
    var IngresoCab = IngresoLote / InvFinal;
    $("#IngresoCab").val(IngresoCab);
    /*Calcula Ingreso Cabeza ----------------------------------------*/
    /*Calcula Egreso Cabeza -----------------------------------------*/
    var Cab = CompraKg * PesoVivoOri;
    $("#EgresoCab").val(Cab);
    /*Calcula Egreso Cabeza -----------------------------------------*/
    /*Calcula Egreso Lote -------------------------------------------*/
    var Lote = Cab * nocabezas;
    $("#EgresoLote").val(Lote);
    /*Calcula Egreso Lote -------------------------------------------*/
    /*Calculo bloque rentabilidad------------------------------------*/
    var RentaPraderaLote = RentaPradera * InvFinal * dias;
    $("#RentaPraderaLote").val(RentaPraderaLote);
    /*Calculo bloque rentabilidad------------------------------------*/
    /*Calcula el bloque de suplementos ------------------------------*/
    $.each(PrecioKg, function(i, val) {
      var PLote = ConsumoKgCabDia[i] * val * Nodias[i] * InvFinal;
      $("#PLote" + i).val(isNaN(parseInt(PLote)) ? 0 : parseInt(PLote));
      Pastoreo = Pastoreo + PLote;
    });
    /*Calcula el bloque de suplementos ------------------------------*/
    Pastoreo = Pastoreo + RentaPraderaLote;
    $("#TotalPastoreoAlimentoLote").val(isNaN(parseInt(Pastoreo)) ? 0 : parseInt(Pastoreo));
    /*Calcula La inversion total operativa x lote -------------------*/
    var InvTotalOperativaLote = (Pastoreo / (AlimentacionTotal / 100));
    $("#InvTotalOperativaLote").val(isNaN(parseInt(InvTotalOperativaLote)) ? 0 : parseInt(InvTotalOperativaLote));
    /*Calcula La inversion total operativa x lote -------------------*/
    /*Calcula La inversion total operativa x lote -------------------*/
    var InvGanadoOperativoMuerteLote = (InvTotalOperativaLote + Lote);
    $("#InvGanadoOperativoMuerteLote").val(isNaN(parseInt(InvGanadoOperativoMuerteLote)) ? 0 : parseInt(InvGanadoOperativoMuerteLote));
    /*Calcula La inversion total operativa x lote -------------------*/
    /*Calcula La inversion total operativa x lote -------------------*/
    var UtilidadPerdidaLote = (IngresoLote - InvGanadoOperativoMuerteLote);
    $("#UtilidadPerdidaLote").val(isNaN(parseInt(UtilidadPerdidaLote)) ? 0 : parseInt(UtilidadPerdidaLote));
    /*Calcula La inversion total operativa x lote -------------------*/
    /*Calcula La inversion total operativa x lote -------------------*/
    var UtilidadPerdidaCab = (UtilidadPerdidaLote / InvFinal);
    $("#UtilidadPerdidaCab").val(isNaN(parseInt(UtilidadPerdidaCab)) ? 0 : parseInt(UtilidadPerdidaCab));
    /*Calcula La inversion total operativa x lote -------------------*/
    /*Calcula La inversion total operativa x lote -------------------*/
    var RentabilidadAnual = ((UtilidadPerdidaLote / InvGanadoOperativoMuerteLote * 100) / dias) * 365;
    $("#RentabilidadAnual").val(isNaN(parseInt(RentabilidadAnual)) ? 0 : parseInt(RentabilidadAnual));
    /*Calcula La inversion total operativa x lote -------------------*/
    var DiferenciaCompraVentaCab = (ventakg * PesoVivoIni) - (CompraKg * PesoVivoIni);
     $("#DiferenciaCompraVentaCab").val(isNaN(parseFloat(DiferenciaCompraVentaCab)) ? 0 : parseFloat(DiferenciaCompraVentaCab));
    
    var UtilidadPerdidaKgHecho2 = $("#UtilidadPerdidaKgHecho").val();
    var UtilidadPerdidaKgHechosCab = (GananciaTotalCabKg * UtilidadPerdidaKgHecho2);
    $("#UtilidadPerdidaKgHechosCab").val(isNaN(parseFloat(UtilidadPerdidaKgHechosCab)) ? 0 : parseFloat(UtilidadPerdidaKgHechosCab));

    var DiasCabCiclo2 = $("#DiasCabCiclo").val();
    var InversionTotalOperativoCabDia = InvTotalOperativaLote / DiasCabCiclo2;
    $("#InversionTotalOperativoCabDia").val(isNaN(parseFloat(InversionTotalOperativoCabDia)) ? 0 : parseFloat(InversionTotalOperativoCabDia));

    var KgProducido = InversionTotalOperativoCabDia / Gdp;
    $("#KgProducido").val(isNaN(parseFloat(KgProducido)) ? 0 : parseFloat(KgProducido));

    var UtilidadPerdidaKgHecho = ventakg * KgProducido;
    $("#UtilidadPerdidaKgHecho").val(isNaN(parseFloat(UtilidadPerdidaKgHecho)) ? 0 : parseFloat(UtilidadPerdidaKgHecho));

    var UtilidadPerdidaCabDifComVenKgHechos = UtilidadPerdidaKgHechosCab + DiferenciaCompraVentaCab;
    $("#UtilidadPerdidaCabDifComVenKgHechos").val(isNaN(parseFloat(UtilidadPerdidaCabDifComVenKgHechos)) ? 0 : parseFloat(UtilidadPerdidaCabDifComVenKgHechos));

    var ValorEconomicoMermaInicialKg = (PesoVivoOri - PesoVivoIni) * CompraKg;
    $("#ValorEconomicoMermaInicialKg").val(isNaN(parseFloat(ValorEconomicoMermaInicialKg)) ? 0 : parseFloat(ValorEconomicoMermaInicialKg));

    var UtilidadPerdidaCabT = UtilidadPerdidaCabDifComVenKgHechos - ValorEconomicoMermaInicialKg;
    $("#UtilidadPerdidaCabT").val(isNaN(parseFloat(UtilidadPerdidaCabT)) ? 0 : parseFloat(UtilidadPerdidaCabT));

    var PerdidaKgHechosNoVendidos = (PesoVivoSal - PesoVidaSalReal) * KgProducido;
    $("#PerdidaKgHechosNoVendidos").val(isNaN(parseFloat(PerdidaKgHechosNoVendidos)) ? 0 : parseFloat(PerdidaKgHechosNoVendidos));

  } catch(e){
    alert("Error al realizar las operaciones del modelo");
  }
}
/* Calcular Formulario */


/****** NUEVOS CALCULOS ******/
var Calculos  = function() {
        nocabezas = 0;
        InvFinal = 0;
        fechaentrada = 0;
        fechasalida = 0;
        PesoVivoIni = 0;
        PesoVivoOri = 0;
        PesoVivoSal = 0;
        DesctoPv = 0;
        FechaMuerte = [];
        NumeroMuerte = [];
        PrecioKg = 0;
        ConsumoKgCabDia = 0;
        Nodias = 0;
        Pastoreo = 0;
        TotalPastoreoAlimentoLote = 0;
        RentaPradera = 0;
        AlimentacionTotal =  0;
        PesoVidaSalReal = 0;
        GananciaTotalCabKg = 0;
};
Calculos.prototype.merma = function(PesoVivoIni, PesoVivoOri){
    this.PesoVivoOri = PesoVivoOri;
    this.PesoVivoIni = PesoVivoIni;
    return ((+this.PesoVivoOri - +this.PesoVivoIni) / +this.PesoVivoOri) * 100;
};
Calculos.prototype.calPesoVidaSalidaReal = function(PesoVivoSal, DesctoPv){
    this.DesctoPv = DesctoPv;
    this.PesoVivoSal = PesoVivoSal;
    this.PesoVidaSalReal = +PesoVivoSal-(+PesoVivoSal*(+DesctoPv/100));
    return this.PesoVidaSalReal;
};
Calculos.prototype.calGananciaTotalCabKg = function(){
    this.GananciaTotalCabKg = this.PesoVidaSalReal - this.PesoVivoIni;
    return this.GananciaTotalCabKg;
};
Calculos.prototype.calFechaMuerte = function(Fechas, fechaentrada, NumeroMuerte){
    this.FechaMuerte = Fechas;
    this.NumeroMuerte = NumeroMuerte;
    this.fechaentrada = fechaentrada;
    var InvFinal = 0;
    for(var i = 0, item; item = Fechas[i]; Fechas[i++]){
       var fecha = item.split('/');
       var dat4 = new Date(fecha[2], parseFloat(fecha[1])-1, parseFloat(fecha[0]));
       var dat3 = new Date(fechaentrada[2], parseFloat(fechaentrada[1])-1, parseFloat(fechaentrada[0]));
       var fin2 = dat4.getTime() - dat3.getTime();
       var diasM = Math.floor(fin2 / (1000 * 60 * 60 * 24))
       var DiasInvertidos = diasM * NumeroMuerte[i];  
       InvFinal = InvFinal - NumeroMuerte[i];
    }
    this.InvFinal = InvFinal;
    return {"dias": 10, "inv": this.InvFinal};
};
Calculos.prototype.calGananciaTotalLoteKg = function(){
    this.GananciaTotalLoteKg = this.GananciaTotalCabKg * this.InvFinal;
    return this.GananciaTotalLoteKg;
};
/****** NUEVOS CALCULOS ******/