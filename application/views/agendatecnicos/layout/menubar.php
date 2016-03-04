<header>
	<span>
 		BIENVENIDO : <?=$usuario;?>
 	</span>
 <h1>Agenda</h1>
 <p><script type="text/javascript">mostrarFecha();</script></p>
 <img src="<?=base_url('assets/img/logo_vim_gris.png');?>" alt="Logo Vimifos" />
 <a href="<?=site_url('aplicaciones/home');?>"><i class="fa fa-home"></i></a>
 <a href="<?=site_url('inicio_class/logout');?>"><i class="fa fa-lock"></i></a>
</header>
<aside class="list-group">
 <!-- <a class="list-group-item" href="<?=site_url('usuariost');?>"><i class="fa fa-users fa-fw fa-lg"></i><span class="aside-text">Usuarios</span></a>
  <a class="list-group-item" href="<?=site_url('clientes1');?>"><i class="fa fa-user fa-fw fa-lg"></i><span class="aside-text">Cliente</span></a>
  <a class="list-group-item" href="<?=site_url('granjas1');?>"><i class="fa fa-university fa-fw fa-lg"></i><span class="aside-text">Granjas</span></a> -->  
  <a class="list-group-item" href="<?=site_url('calendario');?>"><i class="fa fa-calendar fa-fw fa-lg"></i><span class="aside-text">Calendario</span></a>
  <!--<a class="list-group-item" href="<?=site_url('reportes');?>"><i class="fa fa-calendar fa-fw fa-lg"></i><span class="aside-text">Consultas</span></a>  -->
</aside>