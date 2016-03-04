<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('fletes/home');?>">Cotizador Fletes</a></li>

			<li class="active"><?=!isset($new) ? "" : $new;?></li>
	 	</ul>	
</nav>
<section>
  <div class="panel panel-primary">
    <div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
    <div class="panel-body">
    <div>REGISTROS CARGADOS: <b><?=$r_alta+$r_modificacion?></b></div><br/>
    <div>NUEVOS: <b><?=$r_alta?></b></div>
    <div>MODIFICACIONES: <b><?=$r_modificacion?></b></div>
    <div>ERRORES: <b><?=$r_error?></b></div><br/>
    <table class='table table-striped table-hover table-condensed'>
      <thead>
        <tr>
          <th>Id</th>
          <th>Fila</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Ciudad</th>
          <th>Km's</th>
          <th>Costo</th>
          <th>Unidad</th>
          <th>Proveedor</th>
          <th>Status</th>
          <th>Accion</th>
        </tr>
      </thead>
      <tbody>
        <?php for($i = 0; $i <= count($descripcion)-1; $i++){ 
          if($descripcion[$i]){ 
          if($accion[$i] == "ERROR" ){ 
        ?>
          <tr style="color: red;">
        <?php } else { ?>
            <tr>
        <?php } ?>
          <td><?=$i?></td>
          <td><?=$i+1?></td>
          <td><?=$descripcion[$i]?></td>
          <td><?=$estado[$i]?></td>
          <td><?=$ciudad[$i]?></td>
          <td><?=$kms[$i]?></td>
          <td>$<?=number_format(($costo[$i] ? $costo[$i] : 0),2)?></td>
          <td><?=$unidad[$i]?></td>
          <td><?=$proveedor[$i]?></td>
          <td><?=$status[$i]?></td>
          <td><b><?=$accion[$i]?></b></td>
        </tr>
        <?php } } ?>
      </tbody>
    </table>
    </div>
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