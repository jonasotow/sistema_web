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
        <!--<img src="assets/img/logo_vim.png"  width="80px">-->
      </td>
      <td width="75%" align="right"><h2>SOLICITUD DE FORMULACION GANADO <?=$formato?></h2></td>
    </tr>
    <tr>
      <td colspan="2" align="right"><h2>DEPARTAMENTO DE FORMULACION</h2></td>
    </tr>
  </table>
  <table class="table table-botext.rdered" border="1">
    <tr>
      <td align="right"><b>Folio:</b></td>
      <td align="left">&nbsp;<b><?=$idsolicitud?></b></td>
      <td align="right">Fecha de solicitud:</td>
      <td align="left">&nbsp;<?=$fecha?></td>
    </tr>
    <tr>
      <td align="right">Nombre del solicitante:</td>
      <td align="left">&nbsp;<?=$solicitante?></td>
      <td align="right">Tipo Cliente:</td>
      <td align="left">&nbsp;<?=$tipo_cliente?></td>
    </tr>
  </table>
  <table class="table table-botext.rdered" border="1">
    <tr>
      <td class="titulo" colspan="4" align="center"><b>Datos Del Cliente</b></td>
    </tr>
    <tr>
      <td align="right">Nombre del cliente:</td>
      <td align="left">&nbsp;<?=$nombre_cliente?></td>
      <td align="right">Telefono:</td>
      <td align="left">&nbsp;<?=$telefono?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table class="table table-botext.rdered" border="1">
    <tr>
      <td class="titulo" colspan="8" align="center"><b>Datos para Formular</b></td>
    </tr>
    <tr>
      <td align="right">No. Cabezas:</td>
      <td align="left">&nbsp;<?=$cabezas?></td>
      <td align="right">Produccion</td>
      <td align="left">&nbsp;<?=$produccion?></td>
      <td align="right">Secas</td>
      <td align="left">&nbsp;<?=$secas?></td>
      <td align="right">Reemplazos</td>
      <td align="left">&nbsp;<?=$reemplazos?></td>
    </tr>
    <tr>
      <td align="right">Alimentarcion:</td>
      <td align="left">&nbsp;<?=$alimentacion?></td>
      <td align="right">Produccion Leche Promedio:</td>
      <td align="left" colspan="3">&nbsp;<?=$produccionleche?></td>
      <td align="right">% de Grasa:</td>
      <td align="left" colspan="3">&nbsp;<?=$porcentajegrasa?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table class="table table-botext.rdered" border="1">
  <tr>
    <td class="titulo" colspan="5" align="center"><b>Micro</b></td>
  </tr>
  <tr>
      <td align="rigth">Micro:</td>
      <td align="left">Precio:</td>
      <td align="rigth">Vacas Adultas:</td>
      <td align="left" colspan="2">Reemplazos:</td>
    </tr>
    <tr>
      <td align="rigth"><?=$idProducto?></td>
      <td align="left"><?=number_format($precioproducto,2)?></td>
      <td align="rigth"><?=$vacas?></td>
      <td align="left">$<?=$ReemplazosMicro?><td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table class="table table-botext.rdered" border="1">
  <tr>
    <td class="titulo" colspan="4" align="center"><b>Ingredientes</b></td>
  </tr>
  <tr>
      <td align="rigth">Ingrediente:</td>
      <td align="left">Precio:</td>
      <td align="rigth">Especificacion:</td>
    </tr>
    <?php foreach($ingredientes as $row2){ 
          if($row2->Tipo == "IGR") { ?> 
    <tr>
      <td align="rigth"><?=$row2->Ingrediente?></td>
      <td align="left">$<?=number_format($row2->Precio,2)?><td>
      <td align="left"><?=$row2->Especificacion?>%</td>
    </tr>
    <?php } } ?>
  </table>
  <p>&nbsp;</p>
  <table class="table table-botext.rdered" border="1">
  <tr>
    <td class="titulo" colspan="4" align="center"><b>Forrajes</b></td>
  </tr>
  <tr>
      <td align="rigth">Ingrediente:</td>
      <td align="left">Precio:</td>
      <td align="rigth">Especificacion:</td>
    </tr>
    <?php foreach($ingredientes as $row2){ 
          if($row2->Tipo == "FOR") { ?> 
    <tr>
      <td align="rigth"><?=$row2->Ingrediente?></td>
      <td align="left">$<?=number_format($row2->Precio,2)?><td>
      <td align="left"><?=$row2->Especificacion?>%</td>
    </tr>
    <?php } } ?>
  </table>
  <p>&nbsp;</p>
  <table class="table table-botext.rdered" border="1">
  <tr>
    <td class="titulo" align="center"><b>Comentarios</b></td>
  </tr>
  <tr>
      <td align="left"><?=$comentarios?></td>
  </tr>
  </table>
  </footer>
</body>
</html>