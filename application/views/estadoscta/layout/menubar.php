<header>
 <h1>ESTADOS DE CUENTA</h1>
  <img src="<?=base_url('assets/img/logo_vim_gris.png');?>" alt="Logo Vimifos" />
 <p>BIENVENIDO : <?=$usuario;?><br/><script>mostrarFecha();</script>
 ( <a href="<?=site_url('aplicaciones/home');?>">Inicio</i></a> |
  <a href="<?=site_url('inicio_class/logout');?>">Salir</i></a> )</p>
</header>
<aside class="list-group">
  	<?php
     if (is_array($sub_menu)) {
     	foreach ($sub_menu as $key => $value) {
     	?>
     	    <a class="list-group-item" href="<?=site_url($value->rec_controlador.'/'.$value->rec_accion);?>"><i class="fa <?=$value->rec_img?> fa-fw fa-lg"></i><span class="aside-text"><?=$value->rec_etiqueta?></span></a>
     	<?php	
     	}
     }
	?>
  </aside>  