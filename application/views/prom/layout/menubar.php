<header>
 <h1>Promocionales</h1>
  <img src="<?=base_url('assets/img/logo_vim_gris.png');?>" alt="Logo Vimifos" />
 <p>BIENVENIDO : <?=$usuario;?><br/><script>mostrarFecha();</script>
 ( <a href="<?=site_url('aplicaciones/home');?>"><i class="fa fa-home"></i></a> |
  <a href="<?=site_url('inicio_class/logout');?>"><i class="fa fa-lock"></i></a> )</p>
</header>
<aside class="list-group">
  <a class="list-group-item" href="<?=site_url('promocionales');?>" target="_blank"><i class="fa fa-hand-o-right fa-lg"></i><span class="aside-text">Acceder a promocionales</span><i class="fa fa-hand-o-left fa-lg"></i></a>
</aside>