<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <title>Vimifos</title>
   <link rel="shortcut icon" href="./assets/img/favicon.ico" />
   <link rel="stylesheet" href="./assets/css/pedidos/pdf.css" >
</head>
<body>
	<header>
		<div id="head"><img src="./assets/img/fondo_head_pdf.jpg" height="100%" width="100%"></div>
	</header>
	<section>
	<br><br><br><br><br><br>
		<code>
			<h2><strong>Orden de compra</strong><span> Folio : <?=$prod[0]['soldet_id_solicitud']; ?></span></h2>
		</code>
		<table>
			<tbody>
				<tr>
					<td align="right"><strong>Empresa: </strong></td>
					<td><?=$sol_cve_cliente ?></td>
					<td align="right"><strong>Fecha solicitud: </strong></td>
					<td><?=$sol_fecha_creacion ?></td>
				</tr>
				<tr>
					<td align="right"><strong>Persona que solicita: </strong></td>
					<td><?=$sol_persona_solicita ?></td>
					<td align="right"><strong>Fecha deseada: </strong></td>
					<td><?=$sol_fecha_deseada ?></td>
				</tr>
				<tr>
					<td align="right"><strong>Cliente: </strong></td>
					<td colspan="3"><?=$sol_empresa ?></td>
					
				</tr>
			</tbody>
		</table>
		<br><br>
		<h3>Especificaciones Especiales</h3	>
		<hr>
		<table id="general">
			<thead>
				<tr>
					<th colspan="3">Cantidad Solicitada</th>
					<th rowspan="2">Producto</th>
					<th rowspan="2">Aditivos</th>
					<th rowspan="2">Envasado</th>
					<th rowspan="2">Proteina</th>
					<th rowspan="2">Tipo de Producto</th>
				</tr>
				<tr>
					<th>Sacos</th>
					<th>Presentac&iacute;on</th>
					<th>Cantidad TM</th>
				</tr>
			</thead>
			<tbody>
			<?php  foreach ($prod as $key_productos => $productos) { ?>
				<tr>
					<td><?=$productos['soldet_sacos']; ?></td>
					<td><?=$productos['soldet_presentacion']; ?></td>
					<td><?=$productos['soldet_cantidad']; ?></td>
					<td><?=$productos['soldet_nombre']; ?></td>
					<?php $soldet_aditivos =  str_replace('|', ',', $productos['soldet_aditivos']); ?>
					<td><?=$soldet_aditivos; ?></td>
					<td><?=$productos['soldet_envasado']; ?></td>
					<td><?=$productos['soldet_proteina']; ?></td>
					<td><?=$productos['soldet_tipo']; ?></td>
				</tr>
			<?php  } ?>
			</tbody>
		</table>
		<br><br>
		<h3>Exclusivo Cliente</h3>
		<hr>
		<table>
			<tbody>
				<tr>
					<td align="right"><strong>Requerimientos especiales : </strong></td>
					<td colspan="3"><?=$sol_requerimientos_especiales ?></td>
				</tr>
				<tr>
					<td align="right"><strong>Orden de compra interno: </td>
					<td colspan="3"><?=$sol_num_orden ?></td>
				</tr>
				<tr>
					<td align="right"><strong>Ubicaci&oacute;n: </td>
					<td colspan="3"><?=$sol_ubicacion ?></td>
				</tr>
				<tr>
					<td align="right"><strong>Ejecutivo: </td>
					<td><?=$sol_ejecutivo ?></td>
					<td align="right"><strong>Extensi&oacute;n: </td>
					<td><?=$sol_extension_ejecutivo ?></td>
				</tr>
			</tbody>
		</table>
	</section>
	<footer>	
		<div id="foot"><img src="./assets/img/fondo_foot_pdf.jpg" height="100%" width="100%"></div>
	</footer>
</body>
</html>