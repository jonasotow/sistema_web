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
    	<?=!isset($tabs) ? "" : $tabs;?>
    	<br />
    	<div id="tabs" class="tab-content">
    		<?=$table;?>
    	</div>
    </div>
    <!-- <table class='table table-striped table-hover table-condensed'>
    	<thead>
    		<tr>
    			<th rowspan=2>id<th>
    			<th rowspan=2>Grupo</th>
    			<th colspan=2>Fechas</th>
    			<th rowspan=2>No. de Montas</th>
    			<th colspan=16>Semanas</th>
    			<th rowspan=2>Partos</th>
    			<th rowspan=2>% Fert</th>
    			<th colspan=2>Fechas Partos</th>
    			<th rowspan=2>Semana Parto</th>
    			<th colspan=5>Lactancia</th>
    		</tr>
    		<tr>
    			<th><th>
    			<th>Del</th>
    			<th>Al</th>
    			<th>1</th>
    			<th>2</th>
    			<th>3</th>
    			<th>4</th>
    			<th>5</th>
    			<th>6</th>
    			<th>7</th>
    			<th>8</th>
    			<th>9</th>
    			<th>10</th>
    			<th>11</th>
    			<th>12</th>
    			<th>13</th>
    			<th>14</th>
    			<th>15</th>
    			<th>16</th>
    			<th>Del</th>
    			<th>Al</th>
    			<th>1</th>
    			<th>2</th>
    			<th>3</th>
    			<th>4</th>
    			<th>5</th>
    		</tr>
    	</thead>
    	<tbody>
    	</tbody>
    		<tr>
    			<td>6</td>
    			<td></td>
    			<td>6</td>
    			<td>06/02/2014</td>
    			<td>12/02/2014</td>
    			<td>72</td>
    			<td>72</td>
    			<td>72</td>
    			<td>72</td>
    			<td>68</td>
    			<td>68</td>
    			<td>68</td>
    			<td>68</td>
    			<td>68</td>
    			<td>64</td>
    			<td>64</td>
    			<td>63</td>
    			<td>63</td>
    			<td>63</td>
    			<td>63</td>
    			<td>63</td>
    			<td>63</td>
    			<td>63</td>
    			<td>87.5%</td>
    			<td>01/06/2014</td>
    			<td>07/06/2014</td>
    			<td>22</td>
    			<td>63</td>
    			<td>63</td>
    			<td>63</td>
    			<td></td>
    			<td></td>
    		<tr>
    </table> -->
    <div class="panel-footer"></div>
  </div>
	
</section>
<script>
// 	var opciones = {
// 	            title: {
// 	                text: 'Monitor Montas',
// 	                x: -20 //center
// 	            },
// 	            xAxis: {
// 		             title: {
// 	                    text: 'Semanas'
// 	                },
// 	                categories: []
// 	            },
// 	            yAxis: {
// 	                title: {
// 	                    text: 'Animales'
// 	                },
// 	                plotLines: [{
// 	                    value: 0,
// 	                    width: 1,
// 	                    color: '#808080'
// 	                }]
// 	            },
// 	            tooltip: {
// 	                valueSuffix: ' Animales'
// 	            },
// 	              plotOptions: {
// 		            series: {
// 		                cursor: 'pointer',
// 		                point: {
// 		                    events: {
// 		                        click: function() {
// 		                            serieName = this.series.data[this.x].series.name;
// 		                            serieVal = this.y;
// 		                            alert(serieName + ";" + this.y);
// 		                        }
// 		                    }
// 		                }
// 		            }
// 		        },
// 	            legend: {
// 	                layout: 'vertical',
// 	                align: 'right',
// 	                verticalAlign: 'middle',
// 	                borderWidth: 0
// 	            },
// 	            series: []
// 	        };
//  	$( document ).ready(function() {
//      	$('table tbody').delegate("tr", "click", function(){
//         	var datos = new Array();
//         	for(i = 2; i < this.cells.length; i++){
// 	        	datos[i - 2] = parseInt(this.cells[i].innerHTML);
//         	}
//         	var chart = $('#grafica').highcharts();
//         	chart.destroy();
//         	opciones.categories = 
//         	opciones.series = [{ name: this.cells[0].innerHTML, data: datos }];
//         	$('#grafica').highcharts(opciones);
//     	});
//  	});
//  	
//  	$(function () {
// 	 	opciones.categories = 
// 	 	opciones.series = 
//         $('#grafica').highcharts(opciones);
//     });
    
</script>