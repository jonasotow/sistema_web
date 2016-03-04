<div class="container">
    <h3>Nueva Granja</h3>
    <div class="jumbotron">
        <!-- <form action="<?php echo site_url('granjas/recibirDatos'); ?>" method="post" >
            <input name="gran_nombre" type="text" class="form-control"  placeholder="Nombre de la granja" />
            <input name="gran_gerente_atiende" type="text" class="form-control" placeholder="Gerente que atiende la granja" />
            <input name="gran_direccion" type="text" class="form-control" placeholder="Direccion de la granja" />
            <select name="gran_estado" class="form-control">
                <option value="">Estado</option>
                <?php foreach ($estados as $i => $estado) { ?>
                    <option value="<?php echo $estado->est_estado; ?>"><?php echo $estado->est_estado; ?></option>
                <?php } ?>
            </select>
            <input name="gran_ciudad" type="text" class="form-control" placeholder="Ciudad donde se encuentra la granja" />
            <input name="gran_municipio" type="text" class="form-control" placeholder="Municipio donde se encuentra la granja" />
            <input name="gran_zona" type="text" class="form-control" placeholder="Zona de la granja" />
            <select name="gran_especie" class="form-control" >
                <option value="">Selecciona una especie</option>
                <?php
                foreach ($especies as $key => $especie) {
                    ?>
                    <option value="<?php echo $especie->tblgval_valor; ?>"><?php echo $especie->tblgval_valor; ?></option>
                <?php } ?>
            </select>
            <p>Activado</p>	
            <select name="gran_estatus" class="form-control" >
                <option value="1">Si</option>
                <option value="0">No</option>
            </select>
            <button type="submit" class="btn btn-primary" >Enviar</button>
            <button type="reset" class="btn btn-danger regresar" >Regresar</button>
        </form> -->
        <?=$formulario;?>
    </div>
</div>
