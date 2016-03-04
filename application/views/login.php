<!DOCTYPE html>
<html lang="es">
<head>
	<title>Login</title>
	<meta name="description" content="Descripcion del contenido de la pagina">
	<meta name="keywords" content="Palabras para busquedas rapidas">
	<meta name="author" content="Autor(es)">
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="<?=base_url().'assets/img/favicon.ico' ?>" />
    <link rel="stylesheet" href="<?=base_url().'assets/css/login.css' ?>" />
    <link rel="stylesheet" href="<?=base_url().'assets/css/font-awesome.css'?>" >
</head>
<body>
	<header>
		<img src="<?=base_url('assets/img/logo_vim.png');?>" alt="logo" />
	</header>
	<section>
		<div id="login-section">
			<form method="post">
				<fieldset>
					<legend>Inicio de Sesión</legend>
					<p>Favor de proporcionar sus datos.</p>
					<?php if(@$error_login): ?>
						Error en el usuario o contrase&ntilde;a.
						<br />
					<?php endif; ?>

					<?php echo @validation_errors(); ?>

					<br />
					<label for="username">Username</label>
					<!-- <input type="text" class="login username-field" placeholder="Username" value="" name="username" id="username"> -->
					<input type="text" name="username" value="<?php echo @$_POST['username']; ?>"/>
					<label for="password">Password:</label>
					<!-- <input type="password" class="login password-field" placeholder="Password" value="" name="password" id="password"> -->
					<input type="password" name="password" value="<?php echo @$_POST['password']; ?>" />
				</fieldset>
				<!-- <input type="checkbox" tabindex="4" value="First Choice" class="field login-checkbox" name="Field" id="Field">
				<label for="Field" class="choice">Mantener conectado</label> -->
				<button></i>Inicio</button>
			</form>
		</div>
	</section>
	<footer>
	</footer>
</body>
</html>