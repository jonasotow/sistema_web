<section class="vimifos-content mdl-layout__content">
	<div class="vimifos-section box">
		<div class="vimifos-section-title mdl-typography--display-1-color-contrast">
			<?=$titles;?>
		</div>

		<?php
			$cids = $contarcuentas->cid;
		?>

		<div class="box-catalogo">
			<div class="col-md-6 row1 shadow">
				<div class="form-group">
					<h4>Nueva <?=$title;?></h4>
							<?=form_open("/catalogos/addCuenta") ?>
								<?php
									$cue_numero = array(
										'name'	=>	'cue_numero',
										'placeholder' => 'Ejemplo: 2141483596 ',
										'class' => 'form-control',
										'type'=>'text',
										'pattern'=>'[0-9]{3,11}',
										'required title' => 'SOLO NÚMEROS DE 4 A 11 CARACTERES',
									);
								?>
								<?php
									$cue_nombre = array(
										'name'	=>	'cue_nombre',
										'placeholder' => 'Ejemplo: Chequera',
										'class' => 'form-control',
									);
								?>

						<div class="form">
							<div class="col-md-6">
								<label for="cue_banco_id">Selecciones el Banco</label>
								<select name="cue_banco_id" class="form-control" required="">
										<option value> -- Seleccione uno Banco -- </option>
								<?php
									if ($ban) {
									foreach ($ban->result() as $ban) { 
								?>
										<option value="<?= $ban->ban_id ?>" ><?= $ban->ban_nombre ?></option>
								<?php }	
									}else{
										echo "<div class='nodata'>NO HAY DATOS</div>";
									}
									?>
								</select>

								<?= form_label('Número de Cuenta:','cue_numero')?>
								<?= form_input($cue_numero) ?>

								<label for="cue_descripcion">Seleccione la Ciudad</label>
								<select name="cue_descripcion" class="form-control">
									<option value>-- Seleccione una Opción	--</option>
									<option value="GDL">GDL</option>
									<option value="OBR">OBR</option>
								</select>

								<label for="cue_es_inversion">¿Es Cuenta de Inversión?</label>
								<select name="cue_es_inversion" class="form-control" required="">
									<option value>-- Seleccione una Opción	--</option>
									<option value="<?= $cue_es_inversion='1'?>">SI</option>
									<option value="<?= $cue_es_inversion='0'?>">NO</option>
								</select>
							</div>

							<div class="col-md-6">
								<label for="cue_uninegocio_id">Seleccione la Unidad</label>
								<select name="cue_uninegocio_id" class="form-control" required="">
										<option value> -- Seleccione una Unidad -- </option>
								<?php
									if ($une) {
									foreach ($une->result() as $une) { ?>
										<option value="<?= $une->une_id ?>" ><?= $une->une_nombre ?></option>
								<?php }	
									}else{
										echo "<div class='nodata'>NO HAY DATOS</div>";
									}
									?>
								</select>
									<?= form_label('Nombre de Cuenta:','cue_nombre')?>		
									<?= form_input($cue_nombre) ?>

								<label for="cue_divisa">Selecciones la Divisa</label>
								<select name="cue_divisa" class="form-control" required="">
									<option value> -- Seleccione Divisa -- </option>
									<option value="USD">USD</option>
									<option value="MXN">MXN</option>
									<option value="EUR">EUR</option>

								</select>
							</div>
							<input type="hidden" name="cids" value="<?=$cids;?>">

						</div>
						<div class="mdl-card__actions mdl-card--border">
							<button type="submit" class="btn btn-success">Enviar</button>
						</div>
					<?= form_close() ?>
				</div>
			</div>


			<div class="col-md-5 row2 shadow">
				<div class="box-group">
					<h4><?=$titles;?> Registrados</h4>
					<ul class="crop">
					<?php
						if ($ctabanune){
						foreach ($ctabanune->result() as $ctabanune) { ?>
						<li>
							<article>
								<div class="ctabanune center-text "><span><?= $ctabanune->une_nombre; ?></span> - <?= $ctabanune->ban_nombre; ?> - 
								<span><?=$ctabanune->cue_nombre;?> </span><span><?= $ctabanune->cue_numero; ?></span> - <?= $ctabanune->cue_divisa; ?> </div>
								<div class="button-block center-text">
									<a href="editarCuenta/<?=$ctabanune->cue_id;?>" class="btn btn-default"><i class="fa fa-pencil"></i> Editar</a>
									<a href="" class="btn btn-danger" data-toggle="modal" data-target="#deletemodal<?= $ctabanune->cue_id;?>"><i class="fa fa-times"></i> Eliminar</a>
								</div>

								<div class="modal fade" id="deletemodal<?= $ctabanune->cue_id;?>" role="dialog">
									<div class="modal-dialog">								    
									    <div class="modal-content">
									    	<div class="modal-header danger">
									        	<h4 class="modal-title">ELIMINAR <?=$title;?></h4>
									    	</div>
									    	<div class="modal-body">
									    		<p class="text-upper">¿DESEA ELIMINAR <?=$title;?> <span><?= $ctabanune->ban_nombre; ?> - <?= $ctabanune->une_nombre; ?></span> ?</p>
									    	</div>
									    	<div class="modal-footer">
									    		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									    		<a href="deleteCuenta/<?= $ctabanune->cue_id; ?>" type="submit" class="btn btn-danger">Eliminar</a>
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
	</div>	
</section>
<script>
      window.onload = function () {
        [].forEach.call(document.querySelectorAll('.crop'), function (el) {
          Ps.initialize(el);
        });
      };
</script>