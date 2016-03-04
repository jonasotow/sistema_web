<html>
<head>
  <style>
    body{
      font-family: Palatino,'Palatino Linotype',Georgia, sans-serif;
      text-align: justify;
      font-size: 12px;
    }
    table{
      border-collapse: collapse; 
      width: 100%;
    }
    thead{
      background: #000000;
      color: #ffffff; 
    }
    .borde_separador{
      border-bottom: 2px solid;
      border-color: #000000;
    }
</style>
</head>
<body>
  <table class="table table-botext.rdered">
    <tr>
      <td align="left" width="15%"><img src="http://aplicaciones.vimifos.com/assets/img/logo_vim.png" width="80px"></td>
      <td>
        <table class="table table-botext.rdered">
          <tr>
            <td class="borde_separador" align="center" align="left">Estado de cuenta en linea.</td>
            <td class="borde_separador" align="center" align="center">Fecha Actual:&nbsp;<?=$fecha?></td>
            <td colspan="2" class="borde_separador" align="center" align="right">Servicios Financieros - VIMIFOS.</td>
          </tr>
          <tr><td colspan="4">&nbsp;</td></tr>
          <tr>
            <td align="center"><b>EDO. CTA AL<p><?=date("d/m/Y", strtotime($fecha_corte))?></p></b></td>
            <td align="center"><b>CREDITO AUTORIZADO<p><?=$credito_autorizado?>&nbsp;M.N.</p></b></td>
            <td align="center"><b>DIAS DE CREDITO<p><?=$dias_credito?></p></b></td>
            <td align="center"><b>TIPO DE CAMBIO<p><?=$tipo_cambio?></p></b></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br><br>
  <table class="table table-bordered">
    <tr>
      <th><h3><p><?=$parte1;?></p></h3><p><?=$domicilio?></p><p><?=$domicilio2?></p></th>
    </tr>
  </table>
        <br><br>
        <table class="table table-bordered" align="center" border="1">
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
        <table class="table table-bordered" border="1" align="center">
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
        <table class="table table-hover" border="1" align="center">
           <thead>
              <tr><th colspan="5">DESGLOSE DE FACTURAS EN PESOS</th></tr>
              <tr>
                 <th>Emisi&oacute;n</th>
                 <th>Factura</th>
                 <!--<th>Tipo</th>-->
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
        <table class="table table-hover" border="1" align="center">
           <thead>
              <tr><th colspan="5">DESGLOSE DE FACTURAS EN DOLARES</th></tr>
              <tr>
                 <th>Emisi&oacute;n</th>
                 <th>Factura</th>
                 <!--<th>Tipo</th>-->
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
        <span>* El presente estado de cuenta es de uso informativo, sin efectos fiscales y/o legales.</span><br>
        <span>* Esta informaci&oacute;n no tiene validez oficial.</span><br>
        <span>* El presente estado de cuenta, queda a salvedad de acreditar pagos pendiente de identificar y/o aplicar a la fecha de corte.</span><br>
        <span>* El presente estado de cuenta, no considera movimientos posteriores a la fecha de corte.</span><br>
        <span>* El presente estado de cuenta no considera c&aacute;lculo de intereses.</span><br>
        <span>* El presente estado de cuanta est&aacute; calculado al tipo de cambio a la  fecha de corte.</span><br>
        <span>* Para pago de d&oacute;lares, deber&aacute; utilizar el tipo de cambio publicado en el D.O.F al d&iacute;a inmediato anterior a la fecha de pago.</span><br>
        <span>* Abonos y Cargos no recocidos al presente estado de cuenta, favor de comunicarse con su Ejecutivo de Servicios Financieros.</span>
</body>
</html>