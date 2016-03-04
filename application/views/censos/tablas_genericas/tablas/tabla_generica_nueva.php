<div class="container">
    <h3>Nueva Tabla generica</h3>
    <div class="jumbotron">
        <form action="<?php echo site_url('tablas_genericas/recibe_datos_nuevo'); ?>" method="post" >
            <input name="tblg_tabla" type="text" class="form-control" placeholder="Nombre de la tabla" />
            <input name="tblg_descripcion" type="text" class="form-control" placeholder="Descripcion de la tabla" />
            <input name="tblg_comentarios" type="text" class="form-control" placeholder="Comentarios" />
            <button type="submit" class="btn btn-primary" >Enviar</button>
            <button type="reset" class="btn btn-danger regresar" >Regresar</button></a>
        </form>
    </div>
</div>
