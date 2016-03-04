<section>
	<div id="aplicaciones">
		<ul>
		<?php
		if ( is_array(($menu)) ) {
			foreach ($menu as $key_aplicacion => $aplicacion) { 
        ?>
	         <li>
	         		<a href="<?=site_url($aplicacion->apl_inicio.'/home');?>" title="<?=$aplicacion->apl_descripcion;?>">
	         		<p>
						<img src="<?php echo base_url().'assets/img/'. $aplicacion->apl_imagen;?>" class="logo_aplicaciones" alt="aplicacion" />
						<span class="tex-menu"><?=$aplicacion->apl_nombre; ?></span>
					</p>
					</a>		
	         </li>
        <?php 
        	}
        }else{
        	echo "No hay permisos para las aplicaciones";
        } 	
        ?>        
      </ul>	
	</div>
</section>
<script>
	$( document ).ready(function() {
		var irPaginaExterna = function(pagina){
			$.ajax({
			  type: "POST",
			  url: "<?=site_url('inicio_class/appexterna');?>",
			  data: { app: pagina }
			}).done(function( dir ) {
			    location.href = dir;
			});
		};
		$('a[id^=externo]').click(function(event){
			event.preventDefault();
			irPaginaExterna(this.name);
		});		
	});
</script>