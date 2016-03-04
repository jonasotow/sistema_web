<header>
 <h1>Cotizador de Fletes</h1>
  <img src="<?=base_url('assets/img/logo_vim_gris.png');?>" alt="Logo Vimifos" />
 <p>BIENVENIDO : <?=$usuario;?><br/><script>mostrarFecha();</script>
 ( <a href="<?=site_url('aplicaciones/home');?>"><i class="fa fa-home"></i></a> |
  <a href="<?=site_url('inicio_class/logout');?>"><i class="fa fa-lock"></i></a> )</p>
  <h2>Tarifario</h2>
  <span><a href="<?=site_url('carga/descargar_tarifario');?>" target="_blank"><img src="<?=base_url('assets/img/pdf2.png');?>" alt="Tarifario"/></a></span>
</header>
<aside class="list-group">
  	<?php
     if (is_array($sub_menu)) {
     	foreach ($sub_menu as $key => $value) {
     	?>
     	    <a class="list-group-item" href="<?=site_url($value->rec_controlador.'/'.$value->rec_accion);?>"><i class="fa <?=$value->rec_img?> fa-fw fa-lg "></i>
            <span class="aside-text"><?=$value->rec_etiqueta?></span>
          </a>
     	<?php	
     	}
     }
	?>
  </aside>