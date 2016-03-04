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
    .titulo{
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
  <table class="table table-botext.rdered" boder="1">
    <tr>
      <td width="25%" align="left">
        <img src="../../../assets/img/logo_vim.png"  width="80px">
      </td>
      <td width="75%" align="left"><h1>SOLICITUD DE COTIZACION</h1></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><h2>DEPARTAMENTO DE TRAFICO Y LOGISTICA</h2></td>
    </tr>
  </table>
  <table class="table table-botext.rdered" border="1">
    <tr>
      <td align="right"><b>Folio Cotizaci&oacute;n</b></td>
      <td align="left">&nbsp;<b><?=$idsolicitud?></b></td>
      <td align="right">Fecha de solicitud:</td>
      <td align="left">&nbsp;<?=$fecha?></td>
    </tr>
    <tr>
      <td align="right">Nombre del solicitante:</td>
      <td align="left">&nbsp;<?=$nombre_solicitante?></td>
      <td align="right">Division:</td>
      <td align="left">&nbsp;<?=$division?></td>
    </tr>
  </table>
  <table class="table table-botext.rdered" border="1">
    <tr>
      <td class="titulo" colspan="6" align="center"><b>Datos Del Cliente</b></td>
    </tr>
    <tr>
      <td align="right">Nombre del cliente:</td>
      <td colspan="5" align="left">&nbsp;<?=$nombre_cliente?></td>
    </tr>
    <tr>
      <td align="right">Nombre del contacto (1):</td>
      <td align="left">&nbsp;<?=$nombre_contacto_1?></td>
      <td align="right">Telefono:</td>
      <td align="left">&nbsp;<?=$telefono_1?></td>
      <td align="right">Celular:</td>
      <td align="left">&nbsp;<?=$celular_1?></td>
    </tr>
    <tr>
      <td align="right">Nombre del contacto (2):</td>
      <td align="left">&nbsp;<?=$nombre_contacto_2?></td>
      <td align="right">Telefono:</td>
      <td align="left">&nbsp;<?=$telefono_2?></td>
      <td align="right">Celular:</td>
      <td align="left">&nbsp;<?=$celular_2?></td>
    </tr>
    <tr>
      <td align="right">Tipo de embalaje:</td>
      <td colspan="5" align="left">&nbsp;<?=$embalaje?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table class="table table-botext.rdered" border="1">
    <tr>
      <td class="titulo" colspan="6" align="center"><b>Cotizaciones</b></td>
    </tr>
    <tr style="background: #00CCFF;">
      <td align="left" width="20%"><b>Unidad</b></td>
      <td align="left"><b>Viajes Mens.</b></td>
      <td align="left"><b>Ton. por Viaje</b></td>
      <td align="left"><b>Costo por Ton.</b></td>
      <td align="left"><b>Costo por Viaje</b></td>
      <td align="left"><b>Costo total</b></td>
    </tr>
    <?php foreach($detalle as $row) {?>
    <tr>
      <td align="left" width="20%">&nbsp;<?=$row->descripcion?></td>
      <td align="left">&nbsp;<?=$row->viajes_mensuales?></td>
      <td align="left">&nbsp;<?=$row->tn_x_viaje?></td>
      <td align="left">&nbsp;$<?=number_format($row->costo_tn,2)?></td>
      <td align="left">&nbsp;$<?=number_format($row->costo_viaje,2)?></td>
      <td align="left">&nbsp;$<?=number_format($row->costo_total,2)?></td>
    </tr>
    <?php } ?>
  </table>
  <p>&nbsp;</p>
  <table class="table table-botext.rdered" border="1">
  <tr>
    <td class="titulo" colspan="6" align="center"><b>Datos de Entrega</b></td>
  </tr>
  <tr>
      <td align="rigth">Direccion de entrega:</td>
      <td colspan="5" align="left">&nbsp;<?=$direccion_1?></td>
    </tr>
    <tr>
      <td align="rigth">Ciudad:</td>
      <td align="left">&nbsp;<?=$ciudad?></td>
      <td align="rigth">Estado:</td>
      <td align="left">&nbsp;<?=$estado?></td>
      <td align="rigth">C.p.:</td>
      <td align="left">&nbsp;<?=$cp_1?></td>
    </tr>
    <tr>
      <td align="rigth">Coordenadas:</td>
      <td colspan="5" align="left">&nbsp;<?=$referencia_1?></td>
    </tr>
  </table>
  <table class="table table-botext.rdered" border="1">
    <tr>
      <td class="titulo" colspan="3" align="center"><b>Requerimientos Especiales</b></td>
    </tr>
    <tr>
      <td align="rigth" width="25%">Fumigacion de la unidad:</td>
      <td align="left" width="5%">&nbsp;<?=$fumigacion?></td>
      <td align="left" width="70%">&nbsp;<?=$obs_fumigacion?></td>
    </tr>
    <tr>
      <td align="rigth" width="25%">Lavado de la unidad:</td>
      <td align="left" width="5%">&nbsp;<?=$lavado?></td>
      <td align="left" width="70%">&nbsp;<?=$obs_lavado?></td>
    </tr>
    <tr>
      <td align="rigth" width="25%">Requisitos del cliente:</td>
      <td colspan="2" align="left" width="75%">&nbsp;<?=$requisitos?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table>
    <tr>
      <td>** La cotizaci&oacute;n no considera el Impuesto al Valor Agregado.</td>
    </tr>
    <tr>
      <td>** La cotizaci&oacute;n no considera demoras, ni maniobras de descarga, ni autopistas.</td>
    </tr>
    <tr>
      <td>** Despu&eacute;s de 4 hrs en cada reparto, se har&aacute; un cargo por demoras adicional al precio de la tarifa.</td>
    </tr>
    <tr>
      <td>** El precio puede incrementar en caso de una urgencia o situaci&oacute;n extemporanea.</td>
    </tr>
  </footer>
</body>
</html>