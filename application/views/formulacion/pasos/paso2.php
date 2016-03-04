<nav class="navbar" role="navigation">
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
        <form action="<?=base_url()?>index.php/ganaderia/formular3/" target="_blank" method="post" accept-charset="utf-8" class="form-horizontal" id="form-inline" enctype="multipart/form-data" role="form">
        <legend>Micros</legend>
        <div class="form-group">
            <?php foreach($producto as $row){ ?>
            <div class="col-md-2">
                <label><span class="label label-primary"><?=$row->Producto;?></span></label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox">
                    </span>
                    <input type="text" class="form-control" id="precio_micro" name="precio_micro[]" placeholder="$ Precio">
                </div><br/>
            </div>
            <?php } ?>
        </div><br/><br/>
        <legend>Micros Especiales</legend>
        <div class="form-group">
        <?php for($i = 0; $i<= 10; $i++){ ?>
                <div class="col-md-2">
                    <input type="text" class="form-control input-sm" id="nombre_micro_especial" name="nombre_micro_especial[]" placeholder="Micro Especial">
                    <input type="text" class="form-control input-sm" id="precio_micro_especial" name="precio_micro_especial[]" placeholder="$ Precio">
                </div>
            <?php } ?>
        </div><br/><br/>
        <legend>Ingredientes</legend>
        <div class="form-group">
            <?php 
                $id = "";
                $Especificacion = "";
                foreach($ingrediente as $row){ 
                ?>
                        <label for="tipo" class="col-md-2 control-label label label-default"><?=$row->Ingrediente?>
                        <input type="checkbox" id="precio" name="precio"></label>
                        <div class="col-md-2">
                            <input type="text" class="form-control input-sm" id="precio" name="precio" placeholder="$ Precio">
                            <select name="idEspecificacion[]" id="idEspecificacion" class="form-control input-sm">
                            <option value="0">&nbsp;</option>
                        <?php
                            foreach($especificacion as $row2){ 
                            if($row->idIngrediente == $row2->idIngrediente){
                        ?>
                            <option value="<?=$row2->Especificacion?>"><?=$row2->Especificacion?>%</option>
                        <?php
                            } 
                        } ?>
                        </select>
                        <input type="text" class="form-control input-sm" id="precio" name="precio" placeholder="Kg / Ton"><br/>
                <? } ?>
                    </div>
                    <?php         
                }
            ?>
                
        </div>
        <div class="form-group">
                    <div class="col-md-12" align="center">
                        <button name="Borrar" type="reset" id="borrar" class="btn btn-primary" >Borrar</button>&nbsp;
                        <button name="siguiente" type="submit" id="paso2" class="btn btn-primary" >Siguiente</button>
                    </div>
	    </div>
        </div>
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