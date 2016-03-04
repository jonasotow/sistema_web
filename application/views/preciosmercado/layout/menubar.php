<header>
 <h1>Precio de Mercado</h1>
  	<img src="<?=base_url('assets/img/logo_vim_gris.png');?>" alt="Logo Vimifos" />
 	<p>BIENVENIDO : <?=$usuario;?><br/><script>mostrarFecha();</script>
 	( <a href="<?=site_url('aplicaciones/home');?>"><i class="fa fa-home"></i></a> |
  	<a href="<?=site_url('inicio_class/logout');?>"><i class="fa fa-lock"></i></a> )</p>
</header>
<aside class="list-group">
  <a class="list-group-item" href="<?=site_url('tipo');?>"><i class="fa fa-tumblr-square fa-lg"></i><span class="aside-text">Tipos</span></a>
  <a class="list-group-item" href="<?=site_url('clases');?>"><i class="fa fa-bars fa-lg"></i><span class="aside-text">Clases</span></a>
   <a class="list-group-item" href="<?=site_url('regiones');?>"><i class="fa fa-globe fa-lg"></i><span class="aside-text">Regiones</span></a>
  <a class="list-group-item" href="<?=site_url('fuentes');?>"><i class="fa fa-university fa-lg"></i><span class="aside-text">Fuentes</span></a>
  <a class="list-group-item" href="<?=site_url('precio_mer');?>"><i class="fa fa-usd fa-lg"></i><span class="aside-text">Precios de Mercado</span></a>
</aside>