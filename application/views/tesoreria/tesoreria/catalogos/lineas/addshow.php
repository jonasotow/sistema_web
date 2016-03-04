<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-section box">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$titles;?>
		</div>
		<div class="box-catalogo">
			<div class="col-md-6 row1 shadow">
				<div class="form-group">
					<h4>Nueva <?=$title;?></h4>
					<?= form_open("/catalogos/addLinea") ?>
						<?php
							$linea_descripcion = array(
								'name'	=>	'linea_descripcion',
								'placeholder' => 'Ejemplo: Linea',
								'class' => 'form-control',
								'style' => 'width: 100%',
								'required' => ''
							);
						?>
						<?php
							$lin_autorizado = array(
								'name'	=>	'lin_autorizado',
								'placeholder' => 'Ejemplo: $100',
								'class' => 'form-control',
								'style' => 'width: 100%',
								'type'=>'text','pattern'=>'[0-9]{1,}',
								'required title' => 'INGRESE SOLO NÚMEROS'
							);
						?>
						<?php
							$lin_disponible = array(
								'name'	=>	'lin_disponible',
								'placeholder' => 'Ejemplo: $100',
								'class' => 'form-control',
								'style' => 'width: 100%',
								'type'=>'text','pattern'=>'[0-9]{1,}',
								'required title' => 'INGRESE SOLO NÚMEROS'
							);
						?>
						<div class="form">
							<div class="col-md-6">
								<label for="lin_banco_id">Selecciones el Banco</label>
								<select name="lin_banco_id" class="form-control" required="">
										<option value> -- Seleccione uno Banco -- </option>
								<?php
									if ($ban){
									foreach ($ban->result() as $ban) { ?>
										<option value="<?= $ban->ban_id ?>" ><?= $ban->ban_nombre ?></option>
												<?php }	
										}else{
											echo "<div class='nodata'>NO HAY DATOS</div>";
										}
								?>
								</select>

								<?= form_label('Cantidad de Linea Autorizada:','lin_autorizado')?>		
								<?= form_input($lin_autorizado) ?>
								<label for="lin_es_largo_plazo">¿La Linea es a Largo Plazo?</label>
								<select name="lin_es_largo_plazo" class="form-control" required="">
									<option value>-- Seleccione una Opción	--</option>
									<option value="<?= $lin_es_largo_plazo='1'?>">SI</option>
									<option value="<?= $lin_es_largo_plazo='0'?>">NO</option>
								</select>
								<div class="mdl-card__actions mdl-card--border">
									<button type="submit" class="btn btn-success">Enviar</button>	
								</div>
							</div>
							<div class="col-md-6">
								<?= form_label('Descripción de la Linea:','linea_descripcion')?>
								<?= form_input($linea_descripcion) ?>
								<?= form_label('Saldo de Linea Disponible:','lin_disponible')?>		
								<?= form_input($lin_disponible) ?>
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
						if ($linban) {
						foreach ($linban->result() as $linban) { ?>
						<li>
							<article>
								<div class="data"><span><?= $linban->ban_nombre; ?></span> - <?= $linban->lin_descripcion; ?> </div>
								<div class="button-block">
									<a href="editarLinea/<?= $linban->lin_id;?>" class="btn btn-default"><i class="fa fa-pencil"></i> Editar</a>
									<a href="" class="btn btn-danger" data-toggle="modal" data-target="#deletemodal<?= $linban->lin_id;?>"><i class="fa fa-times"></i> Eliminar</a>
									<div class="modal fade" id="deletemodal<?= $linban->lin_id;?>" role="dialog">
										<div class="modal-dialog">
										    <div class="modal-content">
										    	<div class="modal-header danger">
										        	<h4 class="modal-title">ELIMINAR <?=$title;?></h4>
										    	</div>
									    		<div class="modal-body">
									    			<p>¿DESEA ELIMINAR <?=$title;?> <span><?= $linban->ban_nombre; ?> - <?= $linban->lin_descripcion; ?></span> ?</p>
									    		</div>
											    <div class="modal-footer">
											    	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
											    	<a href="deleteLinea/<?= $linban->lin_id; ?>" type="submit" class="btn btn-danger">Eliminar</a>
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