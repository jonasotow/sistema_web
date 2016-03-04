<div class="container">
    <h3>Nuevo valor de la tabla generica</h3>
    <div class="jumbotron">
        <form action="<?php echo site_url('tablas_genericas_valores/recibe_datos_nuevo'); ?>" method="post" >
            <select name="tblgval_id_tabla_generica" class="form-control">
                <option value="">Tabla generica</option>
                <?php foreach ($tablas_genericas as $i => $tabla_generica) { ?>
                    <option value="<?php echo $tabla_generica->tblg_id_tabla_generica; ?>"><?php echo $tabla_generica->tblg_tabla; ?></option>
                <?php } ?>
            </select>
            <input name="tblgval_valor" type="text" class="form-control" placeholder="Valor" />
            <input name="tblgval_tabla_relacionar" type="text" class="form-control" placeholder="Nombre de la tabla generica a la que pudiera relacionarse" />
            <button type="submit" class="btn btn-primary" >Enviar</button>
            <button type="reset" class="btn btn-danger regresar" >Regresar</button></a>
        </form>
    </div>
</div>
