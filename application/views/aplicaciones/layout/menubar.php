<header>
  <h1>Aplicaciones</h1>
  <img src="<?=base_url('assets/img/logo_vim_gris.png');?>" alt="Logo Vimifos" />
  <p>
    <?=isset($clave_cliente) ? 'Cliente : '.$clave_cliente.'--->' : '';?>
    <?=isset($usuario) ? 'Bienvenido : '.$usuario : '';?><br/>
    <script>mostrarFecha();</script>     
    ( 
    <a href="<?=site_url('inicio_class/logout');?>">Salir</a> 
    )
  </p> 
</header>