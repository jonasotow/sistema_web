<nav class="navbar" role="navigation">
        <a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
         <ul class="navbar-right breadcrumb">
            <li><a href="<?=site_url('estadoscta/home');?>">Estados de cuenta</a></li>
            <li class="active"><?=!isset($new) ? "" : $new;?></li>
        </ul>   
</nav>
<section>
    <div class="panel panel-primary">
        <div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
        <div class="panel-body">
        <span><b>BIENVENIDO:&nbsp;<?=$usuario;?></b></span>
        <p>&nbsp;</p>
        <a href="<?=base_url()?>index.php/estados/generar_pdf/" target="_blank" class="td"><i class="fa fa-file-pdf-o fa-3x"></i></a>&nbsp;<span>Exportar a PDF</span>&nbsp;
        <a href="<?=base_url()?>index.php/estados/generar_excel/" target="_blank" class="td"><i class="fa fa-file-excel-o fa-3x"></i></a>&nbsp;<span>Exportar a EXCEL</span>
        <p>&nbsp;</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Saldo Anterior</th>
                    <th>Pagos</th>
                    <th>Compras</th>
                    <th>Saldo Actual</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#</td>
                    <td><?=!isset($saldoant) ? "0" : $saldoant;?></td>
                    <td><?=!isset($pagos) ? "0" : $pagos;?></td>
                    <td><?=!isset($compras) ? "0" : $compras;?></td>
                    <td><?=!isset($saldoact) ? "0" : $saldoact;?></td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Facturas (USD)</th>
                    <th>Saldo (USD)</th>
                    <th>Facturas (MN)</th>
                    <th>Saldo (MN)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#</td>
                    <td><?=!isset($facturasusd) ? "0" : $facturasusd;?></td>
                    <td><?=!isset($saldousd) ? "0" : $saldousd;?></td>
                    <td><?=!isset($facturasmn) ? "0" : $facturasmn;?></td>
                    <td><?=!isset($saldomn) ? "0" : $saldomn;?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table table-hover">
        <caption>DESGLOSE DE FACTURAS EN PESOS</caption>
           <thead>
              <tr>
                 <th>#</th>
                 <th>Emisi&oacute;n</th>
                 <th>Factura</th>
                 <th>Vencimiento</th>
                 <th>D&iacute;as Emitidos</th>
                 <th>Saldos</th>
              </tr>
           </thead>
            <tbody>
                <?=$contenido;?>
                <?php if($pag_pesos != "") echo "<tr><td>#</td><td align='center' colspan='6'>".$pag_pesos."</td></tr>"; ?>
           </tbody>                 
        </table>
        <br>
        <table class="table table-hover">
        <caption>DESGLOSE DE FACTURAS EN DOLARES</caption>
           <thead>
              <tr>
                 <th>#</th>
                 <th>Emisi&oacute;n</th>
                 <th>Factura</th>
                 <th>Vencimiento</th>
                 <th>D&iacute;as Emitidos</th>
                 <th>Saldos</th>
              </tr>
           </thead>
            <tbody>
                <?=$contenido2;?>
                <?php if($pag_usd != "") echo "<tr><td>#</td><td align='center' colspan='6'>".$pag_usd."</td></tr>"; ?>
           </tbody>
        </table>
        </div>
    </div>
</div>
</section>