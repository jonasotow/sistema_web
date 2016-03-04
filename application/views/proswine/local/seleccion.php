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
	    <div class="panel-heading">Seleccione una Granja para captura</div>
	    <div class="panel-body"><?=$table;?></div>
	    <div class="panel-footer"></div>
  	</div>
</section>
<script>
 	$( document ).ready(function() {
     	$('table tbody').delegate("tr", "click", function(){
        	location.href = '<?=$table_action;?>' + "/" + this.cells[0].innerHTML + "/" + this.cells[3].innerHTML;
    	});
 	});
</script>