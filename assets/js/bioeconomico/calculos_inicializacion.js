function GanaderiaInicializacion(){
  E6 = 0; B17 = 0; B18 = 0; B4 = 0; B7 = 0; B13 = 0; B12 = 0; B11 = 0; B11 = 0; E6 = 0; B18 = 0; B17 = 0; B16 = 0; B14 = 0; B19 = 0; E6 = 0; E4 = 0; E12 = 0; E13 = 0; E14 = 0; E11 = 0; E15 = 0; E16 = 0; B21 = 0; E21 = 0; E22 = 0; E23 = 0; F21 = 0; E18 = 0; B36 = 0; C36 = 0; B57 = 0; B58 = 0; B60 = 0; B61 = 0; B59 = 0; B62 = 0; B6 = 0; B67 = 0; E34 = 0; E36 = 0; F47 = 0; F54 = 0; B63 = 0; B64 = 0; B65 = 0; B68 = 0; B69 = 0; E57 = 0; E58 = 0; E47 = 0; E54 = 0; E63 = 0; E65 = 0; E68 = 0; E69 = 0; E70 = 0; F24 = 0; F70 = 0; E7 = 0; E24 = 0; E76 = 0; E77 = 0; F76 = 0; F77 = 0;
};  
GanaderiaInicializacion.prototype.CalculosInicializacion = function(){
  this.valor_becerras_criadas               = +this.E6*(+this.B17*+this.B18);
  this.E7                                   = this.valor_becerras_criadas;
  this.numero_becerros_vendidos             = +this.B4*(+this.B7/100)/2;
  this.B11                                  = this.numero_becerros_vendidos;
  this.ingresos_por_becerros                = +this.B13*+this.B12*+this.B11;
  this.B14                                  = this.ingresos_por_becerros;
  this.numero_becerras_vendidos             = +this.B11-+this.E6;
  this.B16                                  = this.numero_becerras_vendidos;
  this.ingresos_por_becerras                = +this.B18*+this.B17*+this.B16;
  this.B19                                  = this.ingresos_por_becerras;
  this.ingresos_total_becerros_as           = +this.B14+(+this.B19);
  this.B21                                  = this.ingresos_total_becerros_as;
  this.numero_vientres_desecho              = +this.E6+(+this.E4);
  this.E11                                  = this.numero_vientres_desecho;
  this.precio_cab_recuperado                = +this.E12*+this.E13;
  this.E14                                  = this.precio_cab_recuperado;
  this.precio_total_recuperado              = +this.E14*+this.E11;
  this.E15                                  = this.precio_total_recuperado;
  this.E18                                  = this.total_ingreso_ano;
  this.vi_becerros_as_vendidas              = +this.B21/+this.B4;
  this.E21                                  = this.vi_becerros_as_vendidas;
  this.vi_vientre_recuperacion_ano_precio   = +this.E14/8;
  this.E22                                  = this.vi_becerros_as_vendidas;
  this.vi_recuperacion_vientre_precio       = +this.E21+(+this.E22);
  this.E23                                  = this.vi_recuperacion_vientre_precio;
  this.E24                                  = this.vi_ini_ing_recuperado_vie_sem_precio;
  this.ha_becerros_as_vendidas              = +this.E21*+this.B4;
  this.F21                                  = this.ha_becerros_as_vendidas;
  this.ha_vientre_recuperacion_ano_precio   = +this.E22*+this.E11;
  this.ha_recuperacion_vientre_precio       = +this.F21+(+this.E15);
  this.ha_ini_ing_recuperado_vie_sem_precio = +this.F21+(+this.E18);
  this.F24                                  = this.ha_ini_ing_recuperado_vie_sem_precio;
  this.calculo_agostadero                   = +this.B36*+this.C36;
  this.E36                                  = this.calculo_agostadero;
  this.E58                                  = this.E36;
  this.inv_precio_sementales                = +this.B58*+this.B57;
  this.B59                                  = this.inv_precio_sementales;
  this.inv_precio_recuperacion_total_ano    = +this.B61*+this.B57/+this.B60;
  this.B62                                  = this.inv_precio_recuperacion_total_ano;
  this.recuperacion_sementales_ano          = +this.B62;
  this.E16                                  = +this.B62;
  this.total_ingreso_ano                    = +this.E15+(+this.E16);
  this.vi_ini_ing_recuperado_vie_sem_precio = +this.E23+(+this.E16/+this.B4);
  this.inv_precio_empadre_vaca_ano          = (+this.B59-+this.B62)/+this.B4/+this.B60;
  this.B63                                  = this.inv_precio_empadre_vaca_ano;
  this.E63                                  = this.B63;
  this.inv_interes_animales_precio_cab      = (+this.B6/8)*(+this.B67/100);
  this.B68                                  = this.inv_interes_animales_precio_cab;
  this.E68                                  = this.B68;
  this.inv_interes_operativo_precio_cab     = this.E34*(this.B67/100);
  this.B69                                  = this.inv_interes_operativo_precio_cab;
  this.E69                                  = this.B69;
  this.ch_vi_precio_alimento_suplementario  = +this.E34
  this.E57                                  = this.ch_vi_precio_alimento_suplementario;
  this.ch_vi_precio_agostadero              = +this.E36;
  this.ch_vi_precio_mano_obra               = +this.F47;
  this.ch_vi_precio_depreciacion            = +this.F54;
  this.ch_vi_precio_empadre_vaca_ano        = +this.B63;
  this.ch_vi_precio_cab_ano_enseminacion    = +this.B64;
  this.ch_vi_meds_trats_precio_vientre_ano  = +this.B65;
  this.E65                                  = this.ch_vi_meds_trats_precio_vientre_ano;
  this.ch_vi_interes_animales_precio_cab    = +this.B68;
  this.ch_vi_interes_operativo_precio_cab   = +this.B69;
  this.ch_vi_precio_total_vientre           = (+this.ch_vi_precio_alimento_suplementario)+(+this.ch_vi_precio_agostadero)+(+this.ch_vi_precio_mano_obra)+(+this.ch_vi_precio_depreciacion)+(+this.ch_vi_precio_empadre_vaca_ano)+(+this.ch_vi_meds_trats_precio_vientre_ano)+(+this.ch_vi_interes_animales_precio_cab)+(+this.ch_vi_interes_operativo_precio_cab);
  this.E70                                  = this.ch_vi_precio_total_vientre;
  this.ch_ha_precio_alimento_suplementario  = +this.E57*+this.B4;
  this.ch_ha_precio_agostadero              = +this.E58*+this.B4;
  this.ch_ha_precio_mano_obra               = +this.E47;
  this.ch_ha_precio_depreciacion            = +this.E54;
  this.ch_ha_precio_empadre_vaca_ano        = +this.E63*+this.B4;
  this.ch_ha_meds_trats_precio_vientre_ano  = +this.E65*+this.B4;
  this.ch_ha_interes_animales_precio_cab    = +this.E68*+this.B4;
  this.ch_ha_interes_operativo_precio_cab   = +this.E69*+this.B4;
  this.ch_ha_precio_total_vientre           = +this.E70*+this.B4;
  this.F70                                  = this.ch_ha_precio_total_vientre;
  this.up_na_ingreso_kg_destetado           = (+this.B11*+this.B12)+(+this.B16*+this.B17)+(+this.E6*+this.B17);
  this.E77                                  = this.up_na_ingreso_kg_destetado;
  this.up_na_costo_produccion_kg_becerro    = +this.F70/((+this.B11*+this.B12)+(+this.B16*+this.B17)+(+this.E6*+this.B17));
  this.E76                                  = this.up_na_costo_produccion_kg_becerro;
  this.up_na_vientre                        = ((+this.E24)+(+this.E7/+this.B4))-+this.E70;
  this.up_na_hato                           = (+this.F24+(+this.E7))-+this.F70;
  this.up_na_kg_destetado                   = +this.E77-+this.E76
  this.up_ve_ingreso_kg_destetado           = +this.F24/((+this.B11*+this.B12)+(+this.B16*+this.B17));
  this.F77                                  = this.up_ve_ingreso_kg_destetado;
  this.up_ve_costo_produccion_kg_becerro    = (+this.F70-+this.E7)/((+this.B11*+this.B12)+(+this.B16*+this.B17));
  this.F76                                  = this.up_ve_costo_produccion_kg_becerro;
  this.up_ve_vientre                        = +this.E24-(+this.E70-(+this.E7/+this.B4));
  this.up_ve_hato                           = +this.F24-(+this.F70-+this.E7);
  this.up_ve_kg_destetado                   = +this.F77-+this.F76;
};

var grafica = {
              chart: {
                  type: 'spline',
              },
              title: {
                  text: ''
              },
              subtitle: {
                  text: 'Por kg destetado'
              },
              xAxis: {
                  categories: ['50%', '60%', '70%', '80%','90%']
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
                  data: [0, 0, 0, 0, 0, 0]
                },
                {
                  name: 'Escenario',
                  data: [0, 0, 0, 0, 0, 0]
              }]
          };

function copyObj(obj){
    return $.extend( {}, obj);
};
