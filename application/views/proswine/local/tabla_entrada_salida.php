<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('proswine/home');?>">Proswine</a></li>
			<li class="active"><?=!isset($new) ? "" : $new;?></li>
	 	</ul>	
</nav>
<section>

 <div class="panel panel-primary">
    <div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
    <div class="panel-body">
    	<?=$table;?>
    	<div id="grafica" style="width:100%; height:400px;"></div>
    </div>
    <div class="panel-footer"></div>
  </div>
	
</section>
<script>
	var opciones = {
	            title: {
	                text: 'Monitor Montas',
	                x: -20 //center
	            },
	            xAxis: {
		             title: {
	                    text: 'Semanas'
	                },
	                categories: []
	            },
	            yAxis: {
	                title: {
	                    text: 'Animales'
	                },
	                plotLines: [{
	                    value: 0,
	                    width: 1,
	                    color: '#808080'
	                }]
	            },
	            tooltip: {
	                valueSuffix: ' Animales'
	            },
	              plotOptions: {
		            series: {
		                cursor: 'pointer',
		                point: {
		                    events: {
		                        click: function() {
		                            serieName = this.series.data[this.x].series.name;
		                            serieVal = this.y;
		                            alert(serieName + ";" + this.y);
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
	            series: []
	        };
 	$( document ).ready(function() {
     	$('table tbody').delegate("tr", "click", function(){
        	var datos = new Array();
        	for(i = 2; i < this.cells.length; i++){
	        	datos[i - 2] = parseInt(this.cells[i].innerHTML);
        	}
        	var chart = $('#grafica').highcharts();
        	chart.destroy();
        	opciones.categories = <?=$categorias;?>;
        	opciones.series = [{ name: this.cells[0].innerHTML, data: datos }];
        	$('#grafica').highcharts(opciones);
    	});
 	});
 	
 	$(function () {
	 	opciones.categories = <?=$categorias;?>;
	 	opciones.series = <?=$series;?>;
        $('#grafica').highcharts(opciones);
    });
    
</script>