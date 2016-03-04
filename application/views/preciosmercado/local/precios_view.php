<nav class="navbar" role="navigation">
        <a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
         <ul class="navbar-right breadcrumb">
            <li><a href="<?=site_url('preciosmercado/home');?>">Precios de mercado</a></li>
            <li class="active"><?=!isset($new) ? "" : $new;?></li>
        </ul>   
</nav>
<section>
    <div class="panel panel-primary">
        <div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
        <div class="panel-body">
        <form class="form-horizontal" role="form" id="catalogo" name="catalogo" method="post" >
        <div class="form-group">
            <label for="Tipo" class="col-lg-2 control-label">Tipo:</label>
            <div class="col-lg-6">
            	<?=$tipos;?>
            </div>
        </div>
        <div class="form-group">
            <label for="Clase" class="col-lg-2 control-label">Clase:</label>
            <div class="col-lg-6">
                <select class="form-control" name="clase" id="clase">
                    <option value="">Selecciona una clase</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="Region" class="col-lg-2 control-label">Region:</label>
            <div class="col-lg-6">
                <select class="form-control" name="region" id="region">
                    <option value="">Selecciona una Region</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="Fuente" class="col-lg-2 control-label">Fuente:</label>
            <div class="col-lg-6">
                <select class="form-control" name="fuente" id="fuente">
                    <option value="">Selecciona una Fuente</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="Fuente" class="col-lg-2 control-label">Año:</label>
            <div class="col-lg-6">
                <input class="form-control" id="anio" type="text" value="<?php echo date("Y"); ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-default">Aceptar</button>
            </div>
        </div>
    </form>

    <br>
    <span id="cadena" name="cadena">&nbsp;</span>

    <span class="form-horizontal" role="form">
        <div class="form-group">
            <label for="tipo_copiar" class="col-lg-2 control-label">Precio a copiar:</label>
            <div class="col-lg-6">
                <input type="text" class="form-control" id="precio_copiar">
            </div>
        </div>
        <div class="form-group">
            <label for="tipo_copiar" class="col-lg-2 control-label">Tipo cambio a copiar:</label>
            <div class="col-lg-6">
                <input type="text" class="form-control" id="tipo_copiar">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button onclick="verifica('seleccion[]');" class="btn btn-default">Copiar Datos</button><br />
            </div>
        </div>
    </span>
    <form class="form-inline" role="form" id="datos" name="datos" method="post">
       <div class="table-responsive"> 
            <table class="table table-striped table-hover table-condensed" id="compras">
            </tbody>
            </table>
        </div>
    </form> 
</div>
</div>
</div>
</section>
