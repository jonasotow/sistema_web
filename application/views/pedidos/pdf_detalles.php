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
			<h2><strong>Orden de compra</strong><span> Folio : <?=$solicitud['sol_id_solicitud']; ?></span></h2>
		</code>
		<h5>
			Este mensaje de correo electronico es un Acuse de Recibo para su orden de 
	 		compra  <?=$orden ?>, en el contenido se comunican los detalles de la operacion,
	 		si existe alguna diferencia con lo solicitado, no dude en contactar a su
	 		ejecutiva de servicio.
		</h5>
		<table>
			<tbody>
				<tr>
					<td align="right"><strong>Orden: </strong></td>
					<td><?=$orden?></td>
					<td align="right"><strong>Fecha solicitud: </strong></td>
					<td><?=$solicitud['sol_fecha_creacion']; ?></td>
				</tr>
				<tr>
					<td align="right"><strong>Persona que solicita: </strong></td>
					<td><?=$solicitud['sol_persona_solicita']; ?></td>
					<td align="right"><strong>Fecha deseada: </strong></td>
					<td><?=$solicitud['sol_fecha_deseada']; ?></td>
				</tr>
				<tr>
					<td align="right"><strong>Cliente: </strong></td>
					<td colspan="3"><?=$solicitud['sol_empresa']; ?></td>
					
				</tr>
			</tbody>
		</table>
		<br><br>
		<h3>Detalle de la Orden</h3	>
		<hr>
		<table id="general">
			<thead>
				<tr>
					<th>Producto</th>
					<th>Nombre</th>
					<th>Cantidad</th>
					<th>Sacos</th>
					<th>Presentaci&oacute;n</th>
				</tr>
			</thead>
			<tbody>
			<?php   
			foreach ($detalle as $productos) {
			?>
				<tr>
					<td><?=$productos->producto; ?></td>
					<td><?=$productos->nombre; ?></td>
					<td><?=$productos->cantidad; ?></td>
					<td><?=($productos->cantidad / $productos->um); ?></td>
					<td><?=$productos->um; ?></td>
				</tr>
			<?php  } ?>
			</tbody>
			<tfoot>
				<tr>
					<td>
					Agradecemos su preferencia<br/>
	                VIMIFOS  S.A. de C.V.
					</td>
				</tr>
			</tfoot>
		</table>
	</section>
	<footer>	
		<div id="foot"><img src="./assets/img/fondo_foot_pdf.jpg" height="100%" width="100%"></div>
	</footer>
</body>
</html>