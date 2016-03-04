<nav class="navbar" role="navigation">
    <a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
    <?=isset($nuevo) ? $nuevo : '' ?>
    <form class="navbar-form navbar-left" role="search" action="<?=$url?>" method="post">
        <div class="form-group">
          <input name="folio" id="folio" type="text" class="form-control input-sm" placeholder="Folio"><button type="submit" id="botons" class="btn btn-default btn-sm"><i class="fa fa-search"></i></button>
          &nbsp;De:&nbsp;<input name="fecha1" id="fecha1" type="date" class="form-control input-sm" placeholder="Fecha Desde">
          &nbsp;A:&nbsp;<input name="fecha2" id="fecha2" type="date" class="form-control input-sm" placeholder="Fecha Hasta"><button type="button" id="botond" class="btn btn-default btn-sm" onClick="this.form.reset()"><i class="fa fa-trash-o"></i></button>
        </div> 
    </form>
    <ul class="navbar-right breadcrumb">
          <li><a href="<?=site_url('estadoscta/home');?>">Estados de cuenta</a></li>
    </ul>   
</nav>
<section>
    <div class="panel panel-primary">
        <div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
        <div class="panel-body">
        <span><b>BIENVENIDO:&nbsp;<?=$usuario;?></b></span>
        <p>&nbsp;</p>
        <table class="table table-hover">
        <caption>FACTURAS</caption>
           <thead>
              <tr>
                 <th>#</th>
                 <th>Serie</th>
                 <th>Folio</th>
                 <th>Fecha</th>
                 <th>SubTotal</th>
                 <th>Total</th>
                 <th>PDF</th>
                 <th>ZIP</th>
              </tr>
           </thead>
            <tbody>
                <?=$contenido;?>
                <?php if($pag != "") echo "<tr><td>#</td><td align='center' colspan='7'>".$pag."</td></tr>"; ?>
           </tbody>                 
        </table>
        </div>
    </div>
</div>
</section>