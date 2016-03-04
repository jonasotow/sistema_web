<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('censos/home');?>">Censos</a></li>
			
			<li class="active"><?=!isset($new) ? "" : $new;?></li>
	 	</ul>	
</nav>
<section>
	<!-- <?= $formulario; ?> -->
	<input type="text" value="" id="search"></input>
	<button type="button" value="" id="buscar">Buscar</button>
	<div id="tabla">
	</div>
	<form action="http://localhost/sistema_web/index.php/granjas_mon/crear" method="post" accept-charset="utf-8" class="custform" id="formulario">
		<fieldset>
			<legend>Granjas</legend>
			<input type="hidden" name="idgranjas_mstr" value="" />
			<label for="granjas_desc">Nombre:</label>
			<input type="text" name="granjas_desc" value="" id="granjas_desc" maxlength="100" size="100" required />
			<label for="granjas_mfg_addr">Gerente:</label>
			<input type="text" name="granjas_mfg_addr" value="" id="granjas_mfg_addr" maxlength="18" size="18" required />
			<label for="granjas_dir">Direccion:</label>
			<textarea name="granjas_dir" cols="50" rows="4" type="textarea" id="granjas_dir" value="" required></textarea>
			<label for="granjas_tel">Telefono:</label>
			<input type="text" name="granjas_tel" value="" id="granjas_tel" maxlength="14" size="14" required />	
			<input type="hidden" name="granjas_status" value="" />	
			<input type="hidden" name="granjas_clave" value="" />	
		</fieldset>
		<fieldset class="botones" id="botones">
			<button name="" type="submit" id="enviar">Guardar</button>
			<button name="" type="button" id="borrar">Regresar</button>
			<button name="" type="button" id="eliminar" disabled >Eliminar</button>
		</fieldset>
	</form>
	<?=validation_errors('<div id="msgError">', '</div>'); ?>
	<!-- <?=$table;?> -->
	
	<script type="text/javascript">Tabla(<?=$detalle;?>,<?=$columnas;?>,"<?=$titulo;?>","Existentes en la dB","tabla",'','tabla');</script>
</section>
<!-- <script>
 	$( document ).ready(function() {
     	$('table tbody').delegate("tr", "click", function(){
        	location.href = '<?=$action;?>' + "/" + this.cells[0].innerHTML;
    	});
 	});
</script> -->
<script>
	$('borrar').observe('click',function(){
		$('formulario').reset();		
	});
	
	$('buscar').observe('click',function(){
		
	});
</script>
 