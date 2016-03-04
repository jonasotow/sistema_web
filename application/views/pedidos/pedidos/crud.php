<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('pedidos/home');?>">Orden de compra</a></li>
			<li><a href="<?=site_url($titulo);?>"><?=!isset($titulo) ? "" : $titulo; ?></a></li>
			<li class="active"><?=!isset($new) ? "" : $new; ?></li>
	 	</ul>	
</nav>
<section>
	<?=!isset($mensajes) ? "" : $mensajes;?>
	<?=validation_errors(); ?>
	<div class="panel panel-primary">
	  <div class="panel-heading">
	   <h3 class="panel-title"><?=!isset($titulo) ? "" : strtoupper($titulo);?></h3>
	  </div>
	  <div class="panel-body">
	  	<?=!isset($error_imagen) ? "" : $error_imagen;?>
		<?= $formulario; ?>
	  </div>
	  <div class="panel-footer"></div>
	</div>
</section>
<script>
	$( document ).ready(function() {
		var validate = function(){
			var email = $("#usu_email").val();
			if(validateEmail(email))
				if($("#usu_password").val() == $("#usu_password_conf").val())
					return true;
			else{
				if(!validateEmail(email)){
					var divError = document.createElement('div');
					divError.setAttribute("id","errorMsg");
					divError.setAttribute("class","alert alert-danger");
					divError.setAttribute("role","alert");
					divError = $(divError);
					divError.html("El email no es valido");
					$("section").append(divError);
					return false;
				}
				if($("#usu_password").val() !== $("#usu_password_conf").val()){
					var divError = document.createElement('div');
					divError.setAttribute("id","errorMsg");
					divError.setAttribute("class","alert alert-danger");
					divError.setAttribute("role","alert");
					divError = $(divError);
					divError.html("Las contrase&ntilde;as no son iguales");
					$("section").append(divError);
					return false;
				}
			}
		}
		$("form").bind("submit", validate);
	});
</script>