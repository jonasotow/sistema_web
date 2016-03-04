<nav class="navbar" role="navigation">
		<!--<a class="navbar-brand regresar" href="<?=site_url('admin');?>"><i class="fa fa-arrow-circle-left"></i></a>-->
    <a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
    <?php
      if (is_array($sub_menu2)) {
        foreach ($sub_menu2 as $key => $value) {
    ?>
      <a class="navbar-brand" href="<?=site_url($value->subrec_controlador.'/'.$value->subrec_accion);?>"><i class="fa <?=$value->subrec_img?>"></i><span class="aside-text">&nbsp;<?=$value->subrec_etiqueta?></span></a>
    <?php 
      }
     }
    ?>
		<!--<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>-->
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('formulacion/home');?>">Formulaci&oacute;n</a></li>

			<li class="active"><?=!isset($new) ? "" : $new;?></li>
	 	</ul>	
</nav>
<section>
  <div class="panel panel-primary">
    <div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
    <?=!isset($errores) ? "" : strtoupper($errores); ?>
    <div class="panel-body" align="center"><?=$table;?></div>
    <div class="panel-body" align="center"><?= (isset($pagination) ? $pagination : NULL) ?></div>
    <div class="panel-footer"></div>
  </div>
</section>
<script>
 	$( document ).ready(function() {
     	$('table tbody').delegate("tr", "click", function(){
        	location.href = '<?=$action;?>' + "/" + this.cells[0].innerHTML;
    	});
 	});
</script>