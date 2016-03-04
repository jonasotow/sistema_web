<div class="container">
    <h3>Editar Tabla generica</h3>
    <div class="jumbotron">	
        <form action="<?php echo site_url('tablas_genericas/recibe_datos_editar/' . $id_tabla_generica); ?>" method="post" >
            <input name="tblg_id_tabla_generica" type="text" class="form-control" readonly="readonly" value="<?php echo $tablas_genericas->result()[0]->tblg_id_tabla_generica; ?>" />
            <input name="tblg_tabla" type="text" class="form-control" value="<?php echo $tablas_genericas->result()[0]->tblg_tabla; ?>" placeholder="Nombre de la tabla"/>
            <input name="tblg_descripcion" type="text" class="form-control" value="<?php echo $tablas_genericas->result()[0]->tblg_descripcion; ?>" placeholder="Descripcion de la tabla"/>
            <input name="tblg_comentarios" type="text" class="form-control" value="<?php echo $tablas_genericas->result()[0]->tblg_comentarios; ?>" placeholder="Comentarios"/>
            <button type="submit" class="btn btn-primary" >Guardar</button>
            <button type="reset" class="btn btn-danger regresar" >Regresar</button>
        </form>     
    </div>
</div>
