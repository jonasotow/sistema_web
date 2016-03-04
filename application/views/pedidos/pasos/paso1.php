<!--
<nav class="navbar" role="navigation">
	<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
  	<ul class="navbar-right breadcrumb">
		  <li><a href="<?=site_url('pedidos/home');?>">Pedidos</a></li>
		  <li  class="active">1er Paso</li>
 	</ul>	
</nav>
<section>
	
	<div class="panel panel-primary">
	  <div class="panel-heading">Seleccionar una planta</div>
	  <div class="panel-body">
		<table class="table">
		 <thead>
		 </thead>
		 <tbody>
<?php foreach ($plantas as $key => $planta) {?>
			<tr>
				<td><?php echo $planta->pla_id_planta;?></td>
				<td>
					<a href="<?=site_url('pasos/paso2/'.$planta->pla_id_planta);?>">
						<img src="<?=base_url().'assets/upload/'.$planta->pla_imagen;?>" class="imagenes_pequenas">
					</a>
				</td>
				<td><?=$planta->pla_nombre;?></td>
				<td><?=$planta->pla_descripcion;?></td>
				<td><?=$planta->pla_direccion;?></td>
			</tr>
	<?php }?>
		 </tbody>
	</table>

	  </div>
	</div>
</section>