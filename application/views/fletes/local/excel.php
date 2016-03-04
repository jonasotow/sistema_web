<?php 
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=machote_tarifario_".date("/d/m/y").".xls");
?>
<html>
<head>
</head>
<body>
  <table border="1">
    <tr>
      <td>descripcion</td>
      <td>idorigen</td>
      <td>estado</td>
      <td>ciudad</td>
      <td>km</td>
      <td>costo</td>
      <td>unidad</td>
      <td>idproveedor</td>
      <td>status</td>
    </tr>
    <?php foreach($contenido as $row){ ?>
    <tr>
      <td><?=$row->descripcion?></td>
      <td><?=$row->idorigen?></td>
      <td><?=$row->estado?></td>
      <td><?=$row->ciudad?></td>
      <td><?=$row->km?></td>
      <td><?=$row->costo?></td>
      <td><?=$row->unidad?></td>
      <td><?=$row->idproveedor?></td>
      <td><?=$row->status?></td>
    </tr>
    <?php } ?>
  </table>
</body>
</html>