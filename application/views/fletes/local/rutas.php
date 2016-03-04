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
		<form action="<?=base_url()?>index.php/rutas/crear_ruta/" method="post" accept-charset="utf-8" class="form-horizontal" id="form-inline" enctype="multipart/form-data" role="form">
            <div class="form-group">
                <label for="fecha" class="col-md-1 control-label">Descripci&oacute;n</label>
                <div class="col-md-6">
                    <input type="text" name="descripcion" class="form-control input-sm" id="descripcion">
                </div>
            </div>
            <div class="form-group">
                <label for="idunidad" class="col-md-1 control-label">Unidad</label>
                <div class="col-md-4">
                    <select name="idunidad" id="idunidad" class="form-control input-sm">
                        <?=$idunidad?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="idestado" class="col-md-1 control-label">Estado</label>
                <div class="col-md-3">
                    <select name="idestado[]" id="idestado" class="form-control input-sm">
                        <?=$idestado?>
                    </select>
                </div>
                <label for="idciudad" class="col-md-2 control-label">Ciudad</label>
                <div class="col-md-4">
                    <select name="idciudad[]" id="idciudad" class="form-control input-sm">
                        <option value="0">Seleccione una Ciudad</option>
                    </select>
                </div>
                <label for="posicion" class="col-md-2 control-label">Posicion</label>
                <div class="col-md-2">
                    <input type="number" name="posicion[]" id="posicion" class="form-control input-sm" value="1">
                </div>
            </div>
            <div class="form-group">
                <label for="monto" class="col-md-1 control-label">Monto</label>
                <div class="col-md-3">
                    <input type="text" name="monto[]" id="monto" class="form-control input-sm">
                </div>
                <label for="traslado" class="col-md-2 control-label">Reparto</label>
                <div class="col-md-1">
                    <input type="checkbox" name="traslado[]" id="traslado" class="form-control input-sm" value="1">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <input class="btn btn-primary" type="button" value="Añadir posición +" onClick="addInput('dynamicInput');">
                </div>
            </div>
            <div id="dynamicInput"></div>
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
<script>
    var estados = <?php echo json_encode($idestado) ?>;
    var ciudades = <?php echo json_encode($idciudad) ?>;
    
    var counter = 1;
    var limit = 10;

    function addInput(divName){
        if (counter == limit)  {
            alert("Haz llegado al limite de posiciones permitidas - " + counter + " max");
        } else {
            var newdiv = document.createElement('div');
            newdiv.innerHTML = "<div class='form-group'>" +
                            "<div class='col-md-10'>" +
                            "***************************************************************************************************************************************************************" +
                            "</div>"+
                            "</div>"+
                            "<div class='form-group'>"+
                            "<label for='idestado' class='col-md-1 control-label'>Estado</label>"+
                            "<div class='col-md-3'>"+
                            "<select name='idestado[]' id='idestado" + (counter + 1) + "' class='form-control input-sm'>" + 
                            estados + 
                            "</select>"+
                            "</div>"+
                            "<label for='idciudad' class='col-md-2 control-label'>Ciudad</label>"+
                            "<div class='col-md-4'>"+
                            "<select name='idciudad[]' id='idciudad" + (counter + 1) + "' class='form-control input-sm'>" +
                            ciudades +
                            "</select>"+
                            "</div>"+
                            "<label for='posicion' class='col-md-2 control-label'>Posicion</label>"+
                            "<div class='col-md-2'>"+
                            "<input type='number' name='posicion[]'' id='posicion' class='form-control input-sm' value=" + 
                            (counter + 1) +
                            "></div>"+
                            "</div>"+
                            "<div class='form-group'>"+
                            "<label for='monto' class='col-md-1 control-label'>Monto</label>"+
                            "<div class='col-md-3'>"+
                            "<input type='text' name='monto[]' id='monto' class='form-control input-sm'>"+
                            "</div>"+
                            "<label for='traslado' class='col-md-2 control-label'>Reparto</label>"+
                            "<div class='col-md-1'>"+
                            "<input type='checkbox' name='traslado[]' id='traslado' class='form-control input-sm' value='" + (counter + 1) + "'>"+
                            "</div>"+
                            "</div>";
            document.getElementById(divName).appendChild(newdiv);
            counter++;
        }
    }

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
                dateFormat: 'mm/dd/yy',
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