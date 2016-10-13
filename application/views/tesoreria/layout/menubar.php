<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <div class="mdl-layout__header ">
        <div class="mdl-layout__header-row">
        	<span class="mdl-layout-title">
        		<a href="<?=base_url().'tesoreria/home' ?>">
                    <img class="vimifos-logo-image" src="<?=base_url('assets/img/logo_vim_gris.png');?>">
                </a>
        	</span>
          <!-- Agregamos un espacio entre el logo de y el menú -->
        	<div class="vimifos-header-spacer mdl-layout-spacer"></div>
	        <div class="vimifos-navigation-container">
	            <div class="mdl-typography--text-uppercase vimifos-font-small"><?=$usuario;?><br/></div>
	            <div class="mdl-typography--text-uppercase vimifos-font-small"><script>mostrarFecha();</script></div>	
	        </div>
    	</div>
    </div>

    <div class="vimifos-drawer mdl-layout__drawer">
    	<span class="mdl-layout-title">
        	<a href="<?=base_url().'tesoreria/home' ?>">
                <img class="vimifos-logo-image" src="<?=base_url('assets/img/logo_vim_gris.png');?>">
            </a>
        </span>
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link a-prin" href="<?=site_url('flujo');?>">Flujo</a>
            <a class="mdl-navigation__link a-prin" href="<?=site_url('inversion');?>">Inversión</a>
			<a class="mdl-navigation__link a-prin" href="<?=site_url('divisas');?>">Compra de Divisas</a>
            <a class="mdl-navigation__link a-prin" href="<?=site_url('tipocambio');?>">Tipo de Cambio</a>
            <div class="vimifos-drawer-separator"></div>
			<a class="mdl-navigation__link a-prin" href="<?=site_url('reportes');?>">Reportes</a>
			<div class="vimifos-drawer-separator"></div>
            <a class="mdl-navigation__link a-prin" href="<?=site_url('catalogos/');?>">Catalogos</a>
	
            <div class="vimifos-drawer-separator"></div>
			<a class="mdl-navigation__link a-red" href="<?=site_url('inicio_class/logout');?>"><i class="material-icons">exit_to_app</i> Cerrar Sesión </a>
        </nav>
      </div>

