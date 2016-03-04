<nav class="navbar hidden-xs" role="navigation">
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
		<form action="<?=base_url()?>index.php/solicitud/generar_pdf/" target="_blank" method="post" accept-charset="utf-8" class="form-horizontal" id="form-inline" enctype="multipart/form-data" role="form">
    		<div class="form-group">
      			<label for="fecha" class="col-md-8 control-label">Fecha de Cotizaci&oacute;n</label>
      			<div class="col-md-1">
          			<input type="date" name ="fecha2" class="form-control input-sm" id="fecha2" disabled value="<?php echo date("d/m/Y"); ?>">
                    <input type="hidden" name="fecha" value="<?php echo date("Y/m/d"); ?>">
      			</div>
    		</div>
    		<div class="form-group">
				<label for="nombre_solicitante" class="col-md-2 control-label">Nombre del solicitante</label>
                <div class="col-md-4">
                    <input type="text" class="form-control input-sm" id="nombre_solicitante" name="nombre_solicitante" required>
                </div>
                <label for="division" class="col-md-2 control-label">Divisi&oacute;n</label>
                <div class="col-md-4">
					<input type="text" class="form-control input-sm" id="division" name="division">
        		</div>
    		</div>
    		<legend>Datos Del Cliente</legend>
    		<div class="form-group">
				<label for="nombre_cliente" class="col-md-2 control-label">Nombre del Cliente</label>
                <div class="col-md-10">
                    <input type="textarea" class="form-control input-sm" id="nombre_cliente" name="nombre_cliente" required>
                </div>
    		</div>
    		<div class="form-group">
				<label for="nombre_contacto_1" class="col-md-2 control-label">Nombre del Contacto (1)</label>
                <div class="col-md-2">
                    <input type="text" class="form-control input-sm" id="nombre_contacto_1" name="nombre_contacto_1" required>
                </div>
                <label for="telefono_1" class="col-md-1 control-label">Telefono</label>
                <div class="col-md-2">
                    <input type="text" class="form-control input-sm" id="telefono_1" name="telefono_1" required>
                </div>
                <label for="celular_1" class="col-md-1 control-label">Celular</label>
                <div class="col-md-2">
                    <input type="text" class="form-control input-sm" id="celular_1" name="celular_1" required>
                </div>
    		</div>
    		<div class="form-group">
				<label for="nombre_contacto_2" class="col-md-2 control-label">Nombre del Contacto (2)</label>
                <div class="col-md-2">
                    <input type="text" class="form-control input-sm" id="nombre_contacto_2" name="nombre_contacto_2">
                </div>
                <label for="telefono_2" class="col-md-1 control-label">Telefono</label>
                <div class="col-md-2">
                    <input type="text" class="form-control input-sm" id="telefono_2" name="telefono_2">
                </div>
                <label for="celular_2" class="col-md-1 control-label">Celular</label>
                <div class="col-md-2">
                    <input type="text" class="form-control input-sm" id="celular_2" name="celular_2">
                </div>
    		</div>
    		<legend>Tipo De Unidad A Cotizar</legend>
    		<div class="form-group">
				<label for="embalaje" class="col-md-2 control-label label label-default">Tipo de Embalaje</label>
                <div class="col-md-10">
                    <label><span class="label label-primary">A pie</span><input type="radio" name="embalaje" class="form-control input-sm" value="A Pie" required></label>&nbsp;&nbsp;
                    <label><span class="label label-primary">Entarimado</span><input type="radio" name="embalaje" class="form-control input-sm" value="Entarimado"></label>&nbsp;&nbsp;
                    <label><span class="label label-primary">A Granel</span><input type="radio" name="embalaje" class="form-control input-sm" value="A Granel"></label>
                </div>
    		</div>
    		<div class="form-group">
				<label for="idunidad" class="col-md-1 control-label">Cotizacion (1)</label>
                <div class="col-md-4">
                    <select name="idunidad[]" id="idunidad" class="form-control input-sm">
                        <?=$idunidad?>
                    </select>
                </div>
                <label for="viajes" class="col-md-2 control-label">Viajes por Mes</label>
                <div class="col-md-2">
                    <input type="number" name="viajes[]" class="form-control input-sm" id="viajes" value="0">
                </div>
				<label for="kgviaje" class="col-md-1 control-label">Ton. x Viaje</label>
                <div class="col-md-2">
                    <input type="number" name="tnviaje[]" class="form-control input-sm" id="tnviaje" value="0">
                </div>
    		</div>
            <div class="form-group">
                <label for="idunidad" class="col-md-1 control-label">Cotizacion (2)</label>
                <div class="col-md-4">
                    <select name="idunidad[]" id="idunidad" class="form-control input-sm">
                        <?=$idunidad?>
                    </select>
                </div>
                <label for="viajes" class="col-md-2 control-label">Viajes por Mes</label>
                <div class="col-md-2">
                    <input type="number" name="viajes[]" class="form-control input-sm" id="viajes" value="0">
                </div>
                <label for="kgviaje" class="col-md-1 control-label">Ton. x Viaje</label>
                <div class="col-md-2">
                    <input type="number" name="tnviaje[]" class="form-control input-sm" id="tnviaje" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="idunidad" class="col-md-1 control-label">Cotizacion (3)</label>
                <div class="col-md-4">
                    <select name="idunidad[]" id="idunidad" class="form-control input-sm">
                        <?=$idunidad?>
                    </select>
                </div>
                <label for="viajes" class="col-md-2 control-label">Viajes por Mes</label>
                <div class="col-md-2">
                    <input type="number" name="viajes[]" class="form-control input-sm" id="viajes" value="0">
                </div>
                <label for="kgviaje" class="col-md-1 control-label">Ton. x Viaje</label>
                <div class="col-md-2">
                    <input type="number" name="tnviaje[]" class="form-control input-sm" id="tnviaje" value="0">
                </div>
            </div>
            <br><br>
            <div id="seccion_dinamica">
            </div>
    		<legend>Datos De Entrega</legend>
    		<div class="form-group">
				<label for="origen" class="col-md-2 control-label">Origen</label>
                <div class="col-md-10">
                    <select name="origen" id="origen" class="form-control input-sm">
                    	<?=$origen?>
                    </select>
                </div>
    		</div>
			<legend>&nbsp;</legend>
    		<div class="form-group">
				<label for="direccion_1" class="col-md-2 control-label">Direcci&oacute;n de Entrega</label>
                <div class="col-md-4">
                    <input type="text" name="direccion_1" class="form-control input-sm" id="direccion_1" required>
                </div>
                <label for="cp_1" class="col-md-2 control-label">Cod. Postal</label>
                <div class="col-md-4">
                    <input type="text" name="cp_1" maxlength="5" class="form-control input-sm" id="cp_1" required>
                </div>
            </div>
            <div class="form-group">
				<label for="idestado" class="col-md-2 control-label">Estado</label>
                <div class="col-md-4">
                    <select name="idestado" class="form-control input-sm">
                    	<?=$idestado?>
                    </select>
                </div>
                <label for="idciudadorigen" class="col-md-2 control-label">Ciudad</label>
                <div class="col-md-4">
                    <select name="idciudadorigen" class="form-control input-sm">
                    	<option >Seleccione una Ciudad</option>
                    </select>
                </div>
    		</div>
            <div class="form-group">
				<label for="referencia_1" class="col-md-2 control-label">Coordenadas</label>
                <div class="col-md-10">
                    <input type="textarea" cols="100" rows="4" class="form-control input-sm" id="referencia_1" name="referencia_1">
                </div>
            </div>
            <legend>Requerimientos Especiales</legend>
            <?php foreach($requerimiento as $row){ ?>
                <div class="form-group">
                    <label for="requerimiento" class="col-md-2 control-label"><?=$row->descripcion?></label>
                    <div class="col-md-1">
                        <input type="checkbox" name="active[]" class="form-control input-sm" id="active" value="<?=$row->idrequerimiento?>">
                    </div>
                    <label for="observaciones" class="col-md-2 control-label">Observaciones</label>
                    <div class="col-md-7">
                        <input type="textarea" name="observaciones[]" class="form-control input-sm" id="observaciones">
                    </div>
                </div>
            <?php } ?>

            <legend>Requisitos del Cliente</legend>
            <div class="form-group">
                <label for="requisitos" class="col-md-4 control-label">(INDICAR SI SE REQUIERE UNA HERRAMIENTA, DOCUMENTO, O UNA INSTRUCCIÓN A CUMPLIR PREVIA AL SERVICIO)</label>
                <div class="col-md-8">
                    <input type="textarea" cols="100" rows="4" class="form-control input-sm" id="requisitos" name="requisitos">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12" align="center">
                    <button name="Borrar" type="reset" id="borrar" class="btn btn-primary" >Borrar</button>&nbsp;
                    <button name="Guardar" type="submit" id="guardar_especie" class="btn btn-primary" >Enviar</button>
                </div>
            </div>
		</form>
	  </div>
	  <div class="panel-footer"></div>
	</div>
</section>