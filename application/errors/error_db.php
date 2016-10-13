<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Aplicaciones para clientes y trabajadores de Vimifos, empresa lider en nutricion animal en Mexico">
	<meta name="keywords" content="vimifos tesoreria finanzas sistemas internos">
	<meta name="author" content="Vimifos">

	<title><?php echo $heading; ?> - Vimifos</title>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


</head>
<body>	
	<div class="container">
		<h1><?php echo $heading; ?> llama al 911</h1>
	        
	    <div class="alert alert-danger" role="alert">
			 <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			<?php echo $message; ?>
		</div>
                            
        <button type="button" class="btn btn-primary" onclick="history.back()">Regresar</button>
                            
                



	</div>

</body>
</html>