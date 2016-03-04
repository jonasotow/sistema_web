<nav class="navbar" role="navigation">
  <a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
  <a class="navbar-brand" href="<?=$action;?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
	<form class="navbar-form navbar-left" role="search">
    <div class="form-group">
      <input type="text" class="form-control input-sm" placeholder="Buscar">
    </div>
    <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
	</form>
	<ul class="navbar-right breadcrumb">
		  <li><a href="<?=site_url('usuarios/home');?>">Usuarios</a></li>
      <li>otro</li>
      <li>otro</li>
      <li>otro</li>
      <li>otro</li>
      <li>otro</li>
      <li>otro</li>
 	</ul>
</nav>
<section>
  <div class="panel panel-primary">
    <div class="panel-heading"><?=$titulo;?></div>
    <div class="panel-body"><?=$table;?></div>
    <div class="panel-footer"></div>
  </div>
  <br/>
</section>
<script>
 	$( document ).ready(function() {
     	$('table tbody').delegate("tr", "click", function(){
        	location.href = '<?=$action;?>' + "/" + this.cells[0].innerHTML;
    	});
 	});
</script>