<nav class="navbar hidden-xs" role="navigation">
		<a class="navbar-brand regresar" href="<?=site_url('ganaderia');?>"><i class="fa fa-arrow-circle-left"></i></a>
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
	       <div class="panel-body">
            <form action="<?=base_url()?>index.php/ganaderia/formular2/" target="_blank" method="post" accept-charset="utf-8" class="form-horizontal" id="form-inline" enctype="multipart/form-data" role="form">
                <div class="form-group">
                    <label for="subespecie" class="col-md-1 control-label">Formato:</label>
                    <!--<div class="col-md-4">
                        <select name="subespecie" id="subespecie" class="form-control input-sm">
                            <?=$subespecie?>
                        </select>
                    </div>-->
                     <div class="col-md-4">
                        <label><span class="label label-primary">OVINO</span><input type="radio" onChange="MostrarOcultar()" class="form-control input-sm" id="formato" name="formato"/></label>
                        <label><span class="label label-primary">FINALIZACION</span><input type="radio" onChange="MostrarOcultar()" class="form-control input-sm" id="formato" name="formato"/></label>
                        <label><span class="label label-primary">LECHERO</span><input type="radio" onChange="MostrarOcultar()" class="form-control input-sm" id="formato" name="formato"/></label>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="solicitante" class="col-md-1 control-label">Solicitante:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-sm" id="solicitante" name="solicitante">
                    </div>
                    <label for="fecha" class="col-md-1 control-label">Fecha:</label>
                    <div class="col-md-2">
                        <input type="date" class="form-control input-sm" id="fecha" name="fecha">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tipo" class="col-md-2 control-label label label-default">Tipo de solicitante:</label>
                    <div class="col-md-10">
                        <label><span class="label label-primary">Cliente</span><input type="radio" class="form-control input-sm" id="solicitante" name="solicitante"/></label>
                        <label><span class="label label-primary">Prospecto</span><input type="radio" class="form-control input-sm" id="solicitante" name="solicitante"/></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nombre" class="col-md-1 control-label">Nombre Cliente:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control input-sm" id="nombre" name="nombre">
                    </div>
                    <label for="telefono" class="col-md-1 control-label">Telefono / Fax:</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control input-sm" id="nombre" name="nombre">
                    </div>
                    <label for="email" class="col-md-1 control-label">Email:</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control input-sm" id="email" name="email">
                    </div>
                </div>
                <div class="form-group" id="Tipo_Ganado">
                    <label for="tipo_ganado" class="col-md-2 control-label label label-default">Tipo de Ganado:</label>
                    <div class="col-md-10">
                    <?php foreach($tipo_ganado as $row){ ?>
                        <label><span class="label label-primary"><?=$row->TipoGanado?></span><input type="radio" class="form-control input-sm" id="tipo_ganado" name="tipo_ganado"/></label>
                    <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cabezas" class="col-md-1 control-label">No. Cabezas:</label>
                    <div class="col-md-1">
                        <input type="number" class="form-control input-sm" id="cabezas" name="cabezas">
                    </div>
                    <label for="impleante" class="col-md-1 control-label">Implante:</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control input-sm" id="impleante" name="impleante">
                    </div>
                    <label for="desparacitante" class="col-md-2 control-label">Desparacitante:</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control input-sm" id="desparasitante" name="desparacitante">
                    </div>
                    <label for="vacuna" class="col-md-1 control-label">Vacuna:</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control input-sm" id="vacuna" name="vacuna">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tipo_mezclado" class="col-md-2 control-label label label-default">Tipo de Mezclado:</label>
                    <div class="col-md-10">
                    <?php foreach($tipo_mezclado as $row){ ?>
                        <label><span class="label label-primary"><?=$row->TipoMezclado?></span><input type="radio" class="form-control input-sm" id="tipo_mezclado" name="tipo_mezclado"/></label>
                    <?php } ?>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="tipo_mezclado" class="col-md-2 control-label label label-default">Fases a formular:</label>
                    <?php foreach($fases as $row){ ?>
                    <div class="col-md-2">
                        <label><span class="label label-primary"><?=$row->Fase?></span><input type="radio" class="form-control input-sm" id="fases[]" name="fases"/></label>
                        <input type="text" class="form-control input-sm" id="rango" name="rango" placeholder="<?=$row->Rango?>">
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group">
                <div class="col-md-12" align="center">
                    <button name="Borrar" type="reset" id="borrar" class="btn btn-primary" >Borrar</button>&nbsp;
                    <button name="siguiente" type="submit" id="paso2" class="btn btn-primary" >Siguiente</button>
                </div>
	       </div>
           </form>
        <div class="panel-footer"></div>
	</div>
</section>
<script>
	$(document).ready(function() {
	//Inicializacion
        $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;;', 'Juv', 'Vie', 'S&aacute;b'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        //Navegadores que no soportan input type=date
        (navigator.userAgent.indexOf('MSIE') != -1 || navigator.userAgent.indexOf('Firefox') != -1 || navigator.userAgent.indexOf('Media Center PC') != -1) && $('input[type=date]').datepicker();
        //Cambiar el nombre del legend del form
        $('legend').html($(".tab-pane.active").data('name'));
                
        //variables globales
        var sitio = 1;
    });
</script>