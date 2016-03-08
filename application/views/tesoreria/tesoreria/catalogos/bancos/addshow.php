<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-section box">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$titles;?>
		</div>
		<div class="box-catalogo">
			<div class="col-md-6 row1 shadow">
				<div class="form-group">
					<h4>Nueva <?=$title;?></h4>
					<?=form_open("/catalogos/addbank") ?>
					<?php
						$nombre_bancos = array(
							'name'	=>	'nombre_bancos',
							'placeholder' => 'Ejemplo: Banamex',
							'class' => 'form-control',
							'required' => ''
						);
					?>
					<div class="form">
						<?=form_label('Nombre del Banco:','nombre_bancos')?>
						<?=form_input($nombre_bancos) ?>
						<div class="mdl-card__actions mdl-card--border">
							<button type="submit" class="btn btn-success">Enviar</button>
						</div>
					</div>
					<?= form_close() ?>
				</div>
			</div>
			<div class="col-md-5 row2 shadow" >
				<div class="box-group">
					<h4><?=$titles;?> Registrados</h4>
					<ul class="crop">
					<?php
						if ($ban) {
						foreach ($ban->result() as $ban) { ?>
						<li>
							<article>
								<div class="data"><?= $ban->ban_nombre; ?></div>
								<div class="button-block">
									<a href="editarBanco/<?=$ban->ban_id;?>" class="btn btn-default"><i class="fa fa-pencil"></i> Editar</a>
									<a href="" class="btn btn-danger" data-toggle="modal" data-target="#deletemodal<?= $ban->ban_id;?>"><i class="fa fa-times"></i> Eliminar</a>
									<div class="modal fade" id="deletemodal<?= $ban->ban_id;?>" role="dialog"><!-- Modal -->
										<div class="modal-dialog"><!-- Modal -->
											<div class="modal-content">
												<div class="modal-header danger">
													<h4 class="modal-title">ELIMINAR <?=$title;?></h4>
												</div>
												<div class="modal-body">
												   	<p>¿DESEA ELIMINAR EL <?=$title;?> <span><?= $ban->ban_nombre; ?></span> ?</p>
											    </div>
											    <div class="modal-footer">
											    	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
											    	<a href="deletebank/<?= $ban->ban_id; ?>" type="submit" class="btn btn-danger">Eliminar</a>
											    </div>
											</div>
										</div>
									</div>
								</div>
							</article>
						</li>
						<?php }	
						}else{
						echo "<div class='nodata'>NO HAY DATOS</div>";
						}?>
					</ul>
				</div>
			</div>
		</div>	
	</div>
</section>
<script>
      window.onload = function () {
        [].forEach.call(document.querySelectorAll('.crop'), function (el) {
          Ps.initialize(el);
        });
      };
</script>