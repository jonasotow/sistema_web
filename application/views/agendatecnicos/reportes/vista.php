<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<!-- polyfiller file to detect and load polyfills -->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
<script>
  webshims.setOptions('waitReady', false);
  //webshims.setOptions('forms-ext', {types: 'date'});
  webshim.setOptions("forms-ext", {
	"widgets": {
		"startView": 2,
		"startValue": "2014-10-12",
		"openOnMouseFocus": true
	}
	});
  webshims.polyfill('forms forms-ext');
</script>

<section>
	<div class="panel panel-primary">
    <div class="panel-heading">Consultas</div>
    <div class="panel-body">

   		<form action="" method="post" id="formulario">
    	<?php 
    		echo form_label('Seleccione un usuario: ');
    			echo "<select name='user'  class='selectpicker' data-style='btn-success'>";
    			echo "<option value='0'> Todos </option>";
    		foreach($usuarios as $usuario){
			    echo "<option value=".$usuario->usu_id.">".$usuario->usu_nombre.' '.$usuario->usu_apellido_paterno."</option>";
	    	}
	    		echo "</select>";
    	?>

    	<br>
    	<?php echo form_label('Rango de fechas: ');
    	$fecha = date("d/m/Y");  

    	echo "<input type='date' name='fch_inicio' value='01/01/2014' placeholder='dd-mm-yyyy'> <input type='date' name='fch_final' value='".$fecha."' placeholder='dd-mm-yyyy' >";
    	?>  
    	<input type="submit">
    	<br> <br>

    	</form>

    	<?php
			if (is_array($registros)) {
				$plantilla = array ( 'table_open'  => '<table class="table table-striped">' );
				$this->table->set_template($plantilla); 
				$this->table->set_heading('ID','Evento', 'Inicio', 'Final', 'Usuario', 'Tiempo de ida (Hrs)', 'Tiempo de Regreso (Hrs)', 'Granja');
				foreach ($registros as $reg) {
					# code...
							
					$this->table->add_row($reg['idcal_mstr'], $reg['cal_what'], $reg['cal_startDate'], $reg['cal_endDate'],$reg['Data']['usu_nombre'],$reg['Data']['tiempo_ida'],$reg['Data']['tiempo_regreso'],$reg['Data']['gran_nombre']);
				}
				echo $this->table->generate(); 
			}
		?>
    </div>
    <div class="panel-footer"></div>
  </div>
</section>

<?php