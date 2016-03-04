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
      <td align="right">Implante</td>
      <td align="left">&nbsp;<?=$implante?></td>
      <td align="right">Desparasitante</td>
      <td align="left">&nbsp;<?=$desparasitante?></td>
      <td align="right">Vacuna</td>
      <td align="left">&nbsp;<?=$vacuna?></td>
    </tr>
    <tr>
      <td align="right">Tipo Ganado:</td>
      <td align="left">&nbsp;<?php foreach($tipo_ganado as $t){ echo $t->TipoGanado; } ?></td>
      <td align="right">Tipo Mezclado:</td>
      <td align="left" colspan="5">&nbsp;<?php foreach($tipo_mezclado as $tt){ echo $tt->TipoMezclado; } ?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table class="table table-botext.rdered" border="1">
  <tr>
    <td class="titulo" colspan="5" align="center"><b>Fases y Micros</b></td>
  </tr>
  <tr>
      <td align="rigth">Fase:</td>
      <td align="left">Rango:</td>
      <td align="rigth">Micro:</td>
      <td align="left" colspan="2">Precio:</td>
    </tr>
    <?php foreach($detalle_solicitud as $row){ ?> 
    <tr>
      <td align="rigth"><?=$row->Descripcion?></td>
      <td align="left"><?=$row->Rango?></td>
      <td align="rigth"><?=$row->Producto?></td>
      <td align="left">$<?=number_format($row->PrecioProducto,2)?><td>
    </tr>
    <?php } ?>
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