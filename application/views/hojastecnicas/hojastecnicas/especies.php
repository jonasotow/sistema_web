<nav class="navbar" role="navigation">
  <a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
</nav>
<section>
  <div class="panel panel-primary">
    <div class="panel-heading"><?=$titulo;?></div>
    <div class="panel-body">
		<table class="table table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>Id</th>
					<th>Imagen</th>
					<th>Descripcion</th>
					<th>Subdescripcion</th>
					<th>Descarga</th>
				</tr>
			</thead>
			<tbody>
				 <?php
				  foreach ($species as $key => $specie) { ?>
				<tr>
					<td><?=$specie->idhoja_tecnica ?></td>
					<td><img src="../../../assets/upload/hojastecnicas/img/<?=$specie->imagen ?>" alt="imagen" class="imagenes_pequenas"></td>
					<td><?=$specie->descripcion ?></td>
					<td><?=$specie->subdescripcion ?></td>
					<td><a target="_blank" href="<?=$specie->link ?>" title="descargar"><i class="fa fa-cloud-download fa-4x"></i></a></td>
				</tr>
				<?php } ?>
					
			</tbody>
			<tfoot>
				<tr></tr>
			</tfoot>
		</table>
    </div>
    <div class="panel-footer"></div>
  </div>
</section>
