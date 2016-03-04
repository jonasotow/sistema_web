<div class="container">
    <h3>Editar Valor de la tabla generica</h3>
    <div class="jumbotron">
        <form action="<?php echo site_url('tablas_genericas_valores/recibe_datos_editar/' . $id); ?>" method="post" >
            <input name="tblgval_id_tabla_generica_valor" type="text" class="form-control" readonly="readonly" value="<?php echo $tablas_genericas_valores->result()[0]->tblgval_id_tabla_generica_valor; ?>" />
            <select name="tblgval_id_tabla_generica" class="form-control">
                <option value="">Tabla generica</option>
                <?php foreach ($tablas_genericas as $i => $tabla_generica) { ?>
                    <?php if ($tablas_genericas_valores->result()[0]->tblgval_id_tabla_generica == $tabla_generica->tblg_id_tabla_generica) { ?>
                        <option value="<?php echo $tabla_generica->tblg_id_tabla_generica; ?>" selected="selected"><?php echo $tabla_generica->tblg_tabla; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $tabla_generica->tblg_id_tabla_generica; ?>"><?php echo $tabla_generica->tblg_tabla; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            <input name="tblgval_valor" type="text" class="form-control" value="<?php echo $tablas_genericas_valores->result()[0]->tblgval_valor; ?>" placeholder="Valor de la tabla Generica"/>
            <input name="tblgval_tabla_relacionar" type="text" class="form-control" value="<?php echo $tablas_genericas_valores->result()[0]->tblgval_tabla_relacionar; ?>" placeholder="Tabla a relacionar"/>
            <button type="submit" class="btn btn-primary" >Guardar</button>
            <button type="reset" class="btn btn-danger regresar" >Regresar</button>
        </form>     
    </div>
</div>
