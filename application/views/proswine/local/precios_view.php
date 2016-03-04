<nav class="navbar" role="navigation">
        <a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
         <ul class="navbar-right breadcrumb">
            <li><a href="<?=site_url('proswine/home');?>">Proswine</a></li>
            <li class="active"><?=!isset($new) ? "" : $new;?></li>
        </ul>   
</nav>
<section>
    <div class="panel panel-primary">
        <div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
        <div class="panel-body">
        <form class="form-horizontal" role="form" id="catalogo" name="catalogo" method="post" >
        <div class="form-group">
            <label for="Tipo" class="col-lg-1 control-label">Tipo:</label>
            <div class="col-lg-6">
                <select class="form-control" name="tipo" type="select" id="tipo">
                    <?php 
                        foreach($tipo as $fila) {
                    ?>
                        <option value="<?=$fila -> idtipo ?>"><?=$fila -> tipo ?></option>
                    <?php
                        }
                    ?>        
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="Clase" class="col-lg-1 control-label">Clase:</label>
            <div class="col-lg-6">
                <select class="form-control" name="clase" id="clase">
                    <option value="">Selecciona una clase</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="Region" class="col-lg-1 control-label">Region:</label>
            <div class="col-lg-6">
                <select class="form-control" name="region" id="region">
                    <option value="">Selecciona una Region</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="Fuente" class="col-lg-1 control-label">Fuente:</label>
            <div class="col-lg-6">
                <select class="form-control" name="fuente" id="fuente">
                    <option value="">Selecciona una Fuente</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-10">
                <button type="submit" class="btn btn-default">Aceptar</button>
            </div>
        </div>
    </form>

    <br>
    <span id="cadena" name="cadena">&nbsp;</span>
    <form class="form-horizontal" role="form" id="datos" name="datos" method="post">
        <div class="table-responsive"> 
            <table class="table table-striped table-hover table-condensed">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Precio</th>
                    <th>Tipo de cambio</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody id="compras">
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
            </tbody>
            </table>
        </div>
    </form> 
</div>
</div>
</div>
</section>