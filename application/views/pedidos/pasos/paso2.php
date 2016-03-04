<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('pedidos/home');?>">Orden de compra</a></li>
			<li><a href="<?=site_url('pasos/paso1');?>">1er Paso</a></li>
			<li class="active">2do paso</li>
	 	</ul>	
</nav>
<section>
	<div class="panel panel-primary">
		<div class="panel-heading">Selecciona el transporte</div>
	  	<div class="panel-body">
  			<div class="transportes">
  				<img id="vimifos" src="<?php echo base_url().'assets/img/pedidos/logo_vim.png';?>">
  				<img id="propio" src="<?php echo base_url().'assets/img/pedidos/transporte.png';?>">
  			</div>
		</div>
		<div class="panel-footer"></div>
	</div>
</section>
<script>
$(document).ready(function() {
  $( ".regresar" ).click(function () {
    location.href = base_url + 'pasos' ;
  });

  $( ".transportes img" ).click(function () {
    var transporte = $(this).attr("id");
      if (transporte == "vimifos") 
        transporte = 1;
      else
        transporte = 2;
    location.href = base_url + 'pasos/paso3/' + transporte ;
  }); 
});
</script>