<html>
  <head>
    <style>
      body {
        font-family: Helvetica, sans-serif;
        font-size: 12px;
      }
      table {
        border-collapse: separate;
        border-spacing: 0px;
        border-bottom: 2px solid;
        border-color: #000000;
      }
      table > thead > tr > th  { 
        background-color: #000000;
        color: #ffffff;
      } 
      .unidades{
        background-color: #0066CC;
      }
    </style>
  </head>
  <body>
  <section>
    <table boder="0">
      <thead>
        <tr>
          <td width="100%" align="left">
            <img src="./assets/img/logo_vim.png"  width="80px">
          </td>
        </tr>
        <tr>
          <td width="100%" align="center"><h2>TARIFARIO</h2></td>
        </tr>
      </thead>
    </table>
    <table border='1'>
      <thead>
        <tr>
          <th>Lugar de Origen</th>
          <!--<th>Descripcion</th>-->
          <th>Ciudad Destino</th>
          <th>Estados Destino</th>
          <th>Km's</th>
          <?php foreach($unidades as $rows){ ?>
            <th class="unidades"><?=$rows->descripcion?></th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach($contenido as $row){ ?>
          <tr>
            <td><?=$row->ciudadorigen?></td>
            <!--<td><?=$row->trayecto?></td>-->
            <td><?=$row->ciudad_destino?></td>
            <td><?=$row->estado_destino?></td>
            <td><?=$row->Kms?></td>
            <?php foreach($unidades as $row2){
              if($row2->idunidad == $row->idunidad){ ?>
                <td><b>$<?=number_format($row->costoviaje,2)?></b></td>
              <?php } else { ?>
                <td>$<?=number_format("0",2)?></td>
              <?php } } ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    </div>
    <div class="panel-footer"></div>
  </div>
  </section>
</body>