
<?php 
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=datos-".date("/d/m/y").".xls");
?>
        <br><br>
        <table class="table table-bordered" border="1">
            <thead>
                <tr>
                    <th><?=$parte1;?></th>
                </tr>
            </thead>
        </table>
        <br><br>
        <table class="table table-bordered" border="1">
            <thead>
                <tr>
                    <th>Saldo Anterior</th>
                    <th>Pagos</th>
                    <th>Compras</th>
                    <th>Saldo Actual</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=!isset($saldoant) ? "0" : $saldoant;?></td>
                    <td><?=!isset($pagos) ? "0" : $pagos;?></td>
                    <td><?=!isset($compras) ? "0" : $compras;?></td>
                    <td><?=!isset($saldoact) ? "0" : $saldoact;?></td>
                </tr>
            </tbody>
        </table>
        <br><br>    
        <table class="table table-bordered" border="1">
            <thead>
                <tr>
                    <th>Facturas (USD)</th>
                    <th>Saldo (USD)</th>
                    <th>Facturas (MN)</th>
                    <th>Saldo (MN)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=!isset($facturasusd) ? "0" : $facturasusd;?></td>
                    <td><?=!isset($saldousd) ? "0" : $saldousd;?></td>
                    <td><?=!isset($facturasmn) ? "0" : $facturasmn;?></td>
                    <td><?=!isset($saldomn) ? "0" : $saldomn;?></td>
                </tr>
            </tbody>
        </table>
        <br><br>
        <table class="table table-hover" border="1">
        <caption>DESGLOSE DE FACTURAS EN PESOS</caption>
           <thead>
              <tr>
                 <th>Emisi&oacute;n</th>
                 <th>Factura</th>
                 <th>Vencimiento</th>
                 <th>D&iacute;as Emitidos</th>
                 <th>Saldos</th>
              </tr>
           </thead>
            <tbody>
                <?=$contenido;?>
           </tbody>                 
        </table>
        <br><br>
        <table class="table table-hover" border="1">
        <caption>DESGLOSE DE FACTURAS EN DOLARES</caption>
           <thead>
              <tr>
                 <th>Emisi&oacute;n</th>
                 <th>Factura</th>
                 <th>Vencimiento</th>
                 <th>D&iacute;as Emitidos</th>
                 <th>Saldos</th>
              </tr>
           </thead>
            <tbody>
                <?=$contenido2;?>
           </tbody>
        </table>
        <br>
        <br>
        <span align="justify">El presente estado de cuenta, es con el objeto de informarle de las operaciones realizadas al <?=$fecha_corte;?>  por su empresa .&nbsp;
            Para integrar su adeudo actual en moneda nacional, toma el tipo de cambio a la fecha de corte.&nbsp;
            Alguna duda o comentario relativo al presente estado de cuenta, favor de comunicarse con Servicios Financieros.&nbsp;
            Reciba nuestro agradecimiento por sus compras y  pagos oportunos.</span>