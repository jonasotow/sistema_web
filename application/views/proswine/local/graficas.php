<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('censos/home');?>">Censos</a></li>
			<li class="active"><?=!isset($new) ? "" : $new;?></li>
	 	</ul>	
</nav>
<section>
	<div class="panel panel-primary">
    	<div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
	    <div class="panel-body">
			<?=!isset($tabs) ? "" : $tabs;?>
			<div id="tabs" class="tab-content">
				<div class="tab-pane active" id="por_fertilidad" data-name="por_fertilidad" style="width:100%; height:500px;"></div>
				<div class="tab-pane" id="inventario" data-name="inventario" style="width:100%; height:500px;"></div>
				<div class="tab-pane" id="perdida" data-name="perdida" style="width:100%; height:500px;"></div>
			</div>
    	</div>
    	<div class="panel-footer"></div>
  	</div>
</section>
<script>
 	 	var opciones_por_fertilidad = {
	            title: {
	                text: '% Fertilidad por Semana',
	                x: -20 //center
	            },
	            xAxis: {
		             title: {
	                    text: 'Semanas'
	                },
	                categories: <?=$cat_fer;?>
	            },
	            yAxis: {
	                title: {
	                    text: '%'
	                },
	                plotLines: [{
	                    value: 0,
	                    width: 1,
	                    color: '#808080'
	                }]
	            },
	            tooltip: {
	                valueSuffix: ' %'
	            },
	              plotOptions: {
		            series: {
		                cursor: 'pointer',
		                point: {
		                    events: {
		                        click: function() {
		                            serieName = this.series.data[this.x].series.name;
		                            serieVal = this.y;
		                        }
		                    }
		                }
		            }
		        },
	            legend: {
	                layout: 'vertical',
	                align: 'right',
	                verticalAlign: 'middle',
	                borderWidth: 0
	            },
	            series: <?=$ser_fer;?>
	        };
	        
	  var opciones_inventario = {
		  		chart: {
		            type: 'column'
		        },
	            title: {
	                text: 'Inventario por Semana',
	            },
	            xAxis: {
	                categories: <?=$cat_inv;?>
	            },
	            yAxis: {
		            min: 0,
		            title: {
		                text: 'Inventario'
		            }
		        },
	            tooltip: {
	                valueSuffix: 'Inventario'
	            },
	            tooltip: {
		            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
		                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
		            footerFormat: '</table>',
		            shared: true,
		            useHTML: true
		        },
                plotOptions: {
		            column: {
		                pointPadding: 0.2,
		                borderWidth: 0
		            }
		        },
	            series: <?=$ser_inv;?>
	        };
	   var opciones_perdida = {
		  		chart: {
		            type: 'column'
		        },
	            title: {
	                text: '% Perdida por Semana de Gestacion',
	            },
	            xAxis: {
	                categories: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]
	            },
	            yAxis: {
		            min: 0,
		            title: {
		                text: '% Perdida'
		            }
		        },
	            tooltip: {
	                valueSuffix: 'Perdida'
	            },
	            tooltip: {
		            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
		                '<td style="padding:0"><b>{point.y:.1f} % </b></td></tr>',
		            footerFormat: '</table>',
		            shared: true,
		            useHTML: true
		        },
                plotOptions: {
		            column: {
		                pointPadding: 0.2,
		                borderWidth: 0
		            }
		        },
	            series: <?=$ser_per;?>
	        };
 	$(function () {
        $('#por_fertilidad').highcharts(opciones_por_fertilidad);
    });
    
    $( document ).ready(function() {
    	//Tabuladores
		$('#menuTabs a').click(function (e) {
			e.preventDefault();
			if(this.toString().split('#')[1] == 'inventario')
				$('#'+ this.toString().split('#')[1]).highcharts(opciones_inventario);
			if(this.toString().split('#')[1] == 'por_fertilidad')
				$('#'+ this.toString().split('#')[1]).highcharts(opciones_por_fertilidad);
			if(this.toString().split('#')[1] == 'perdida')
				$('#'+ this.toString().split('#')[1]).highcharts(opciones_perdida);
			$(this).tab('show');
		});
	});
</script>