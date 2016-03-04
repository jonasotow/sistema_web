<section>
	<h1>Datos Generales</h1>
	   	<form action="<?php echo site_url('censos/recibirDatos/'.$num_registros); ?>" method="post" class="form-inline">
	   		<?php 
	   			foreach ($censos as $key => $censo) {
	   		?>

	   		<input type="hidden" name="val_id_campo<?php echo $key; ?>" value="<?php  echo $censo->cam_id_campo ?>"/>
	   		<input type="hidden" name="val_id_periodo<?php echo $key; ?>" value="<?php  echo $periodos->per_id_periodo; ?>"/>
	   		<?php		
	   			$list = explode( "\n" , $censo->cam_value);
			   	$cuenta_paids = count( $list );
	   				switch ($censo->cam_type) {
	   					case 'text':
	   		?>
	   						<label><?php echo $censo->cam_label; ?></label>
	   						<input type="text" name="val_valor<?php echo $key; ?>" class="form-control"  value="<?php echo $censo->cam_value ?>"  placeholder="rrrrrrrrrrrr" />
	   		<?php
	   						break;

	   					case 'radio':
			   				    ?>
			   				    <label><?php echo $censo->cam_label; ?></label>
			   				    <br>
			   				    <?php
			   					for ($i=0; $cuenta_paids > $i ; $i++) { 
			   					 ?>
			   					 <label><?php echo $list[$i]; ?>
			   						<input type="radio" name="val_valor<?php echo $key; ?>" />
			   					 </label>	
							
			   					<?php	
			   					}
			   					echo "<br>";
	   						break;

	   					case 'checkbox':
			   					?>
			   				    <label><?php echo $censo->cam_label; ?></label>
			   				    <br>
			   				    <?php
			   					for ($i=0; $cuenta_paids > $i ; $i++) { 
			   					?>
			   					<label>
			   						<?php echo $list[$i]; ?>
			   						<input type="checkbox" name="val_valor<?php echo $key; ?>[]" class="form-control" />
			   					</label>
			   					
			   					<?php	
			   					}
			   					echo "<br>";
	   						break;

	   					case 'textarea':
	   						?>
	   				
		   				    <label><?php echo $censo->cam_label; ?></label>
		   				    <br>
	   						<textarea name="val_valor<?php echo $key; ?>" value="<?php  echo $censo->cam_value ?>" class="form-control"  placeholder="a" ></textarea>
	   						<?php
	   						break;

	   					case 'select':
	   						?>
	   						
			   				<label><?php echo $censo->cam_label; ?></label>
	   						<select name="val_valor<?php echo $key; ?>" class="form-control">
								<option value="">Selecciona un valor...</option>
							<?php 

			   					for ($i=0; $cuenta_paids > $i ; $i++) { 
			   					?>
			   					<option><?php echo $list[$i]; ?></option>
			   					<?php	
			   					}
			   				?>
	   						</select>	
	   						<?php
	   						break;		
	   					default:
	   						echo "No es un valor aceptable para un input 'error en la creacion de los campos dinamicos'";
	   						break;
	   				}
	   			}
	   		?>
	   		<br>
			<button type="submit" class="btn btn-primary" >Enviar</button>
			<button type="reset" class="btn btn-danger regresar" >Regresar</button>
		</form>
</section>