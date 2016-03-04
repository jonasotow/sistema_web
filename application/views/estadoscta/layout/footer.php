      <!-- FOOTER -->
      <footer>
        <p>&copy; 2015 Compañia, Inc. &middot; <a href="http://vimifos.com/avisodeprivacidad" target="_blank">Aviso de privacidad</a> &middot; <a href="#">Terminos</a></p>
      </footer>
   <script src="<?php echo base_url().'assets/js/pedidos/pedidos.js'?>"></script>
</body>
</html>
<script>
	var producto = <?php echo json_encode($idProducto) ?>;
	var fases = <?php echo json_encode($idFase) ?>;
	var ingrediente = <?php echo json_encode($idIngrediente) ?>;
	var especificacion = <?php echo json_encode($idEspecificacion) ?>;
	var forraje = <?php echo json_encode($idForraje) ?>;
	var counter = 0;
	var counter2 = 0;
	var counter3 = 0;
	function campos_fases(){
	if(counter > 0){
		obtener_fases((counter + 1));
		$("#Fases").append("<div id='referencia" + (counter + 1) +"'> " +
			"<div class='form-group'><label for='idDetalleEtapa'>Fases #" + (counter + 1) + ":</label> " +
			"<select id='idfase" + (counter + 1) + "' class='form-control' name='idDetalleEtapa[]' data-fase=" + (counter + 1) + "'> " + fases + "</select></div> " +
			"<div class='form-group'><label for='Rango'>Rango:</label> " +
			"<input id='Rango" + (counter + 1) + "' class='form-control' type='text' size='30' maxlength='30' name='Rango[]'> " +
			"</div>" +
			"<div class='form-group'><label for='idProducto'>Micro:</label> " +
			"<select id='idProducto" + (counter + 1) + "' class='form-control' name='idProducto[]'> " + producto + "</select></div> " +
			"<div class='form-group'><label for='Precio'>Precio:</label> " +
			"<input id='Precio' class='form-control' type='text' size='30' maxlength='30' name='Precio[]'> " +
			"</div><div class='form-group'><button name='Guardar' onclick='eliminar_fases(" + (counter + 1) + ")' type='button' id='eliminar_div' class='btn btn-primary'>-</button></div></div>");
			/* $('html,body').animate({
				scrollTop: $("#Fases").offset().top
			}, 3000); */
			counter++;
	} else {
		$("#Fases").append("<div id='referencia" + (counter + 1) +"'> " +
			"<div class='form-group'><label for='idDetalleEtapa'>Fases #" + (counter + 1) + ":</label> " +
			"<select id='idfase" + (counter + 1) + "' class='form-control' name='idDetalleEtapa[]' data-fase=" + (counter + 1) + "'> " + fases + "</select></div> " +
			"<div class='form-group'><label for='Rango'>Rango:</label> " +
			"<input id='Rango" + (counter + 1) + "' class='form-control' type='text' size='30' maxlength='30' name='Rango[]'> " +
			"</div>" +
			"<div class='form-group'><label for='idProducto'>Micro:</label> " +
			"<select id='idProducto" + (counter + 1) + "' class='form-control' name='idProducto[]'> " + producto + "</select></div> " +
			"<div class='form-group'><label for='Precio'>Precio:</label> " +
			"<input id='Precio' class='form-control' type='text' size='30' maxlength='30' name='Precio[]'> " +
			"</div><div class='form-group' id='boton'></div></div>");
			/* $('html,body').animate({
				scrollTop: $("#Fases").offset().top
			}, 3000); */
			counter++;
		}
	}
	function eliminar_fases(contador){
	  	var r = confirm("Deseas eliminar la Fase #" + contador + "?");
	  	if (r == true) {
	    	if(contador < counter){
	      		alert("No es posible eliminar esta Fase, elimine la ultima agregada!");
	    	}else{
	      		$('div').remove('#referencia'+contador);
	      	counter--;
	    	}
	  	}
	}
	function eliminar_ingrediente(contador){
	  	var r = confirm("Deseas eliminar el Ingrediente #" + contador + "?");
	  	if (r == true) {
	    	if(contador < counter2){
	      		alert("No es posible eliminar este Ingrediente, elimine el ultimo agregado!");
	    	}else{
	      		$('div').remove('#referencia2'+contador);
	      	counter2--;
	    	}
	  	}
	}
	function eliminar_forraje(contador){
	  	var r = confirm("Deseas eliminar el Forraje #" + contador + "?");
	  	if (r == true) {
	    	if(contador < counter3){
	      		alert("No es posible eliminar este Forraje, elimine el ultimo agregado!");
	    	}else{
	      		$('div').remove('#referencia3'+contador);
	      	counter3--;
	    	}
	  	}
	}
	function campos_ingrediente(){
	if(counter2 > 0){
		$("#Ingrediente").append("<div id='referencia2" + (counter2 + 1) +"'>" +
					"<div class='form-group'><label for='idIngrediente'>Ingrediente:</label> " +
					"<select id='idIngrediente" + (counter2 + 1) +"' class='form-control' name='idIngrediente[]' data-ingrediente=" + (counter + 1) + "'>" + ingrediente + "</select></div><div class='form-group'> " +
					"<label for='PrecioIngrediente'>Precio:</label><input required id='PrecioIngrediente' class='form-control' type='text' size='30' maxlength='30' name='PrecioIngrediente[]'> " +
					"</div><div class='form-group'><label for='idEspecificacion'>Especificacion:</label> " +
					"<input name='idEspecificacion[]' value='0' type='text' class='form-control'/>%</div>&nbsp;<div class='form-group'><button name='Guardar' onclick='eliminar_ingrediente(" + (counter2 + 1) + ")' type='button' id='eliminar_div' class='btn btn-primary'>-</button></div></div>");
		counter2++;
		} else {
			$("#Ingrediente").append("<div id='referencia2" + (counter2 + 1) +"'><div class='form-group'><label for='idIngrediente'>Ingrediente:</label> " +
					"<select id='idIngrediente" + (counter2 + 1) +"' class='form-control' name='idIngrediente[]' data-ingrediente=" + (counter + 1) + "'>" + ingrediente + "</select></div><div class='form-group'> " +
					"<label for='PrecioIngrediente'>Precio:</label><input required id='PrecioIngrediente' class='form-control' type='text' size='30' maxlength='30' name='PrecioIngrediente[]'> " +
					"</div><div class='form-group'><label for='idEspecificacion'>Especificacion:</label> " +
					"<input name='idEspecificacion[]' value='0' type='text' class='form-control'/>%</div>&nbsp;<div class='form-group' id='botoni'></div></div>");
		counter2++;
		}
	}
	function campos_racion(){
	if(counter3 > 0){
		$("#Forraje").append("<div id='referencia3" + (counter3 + 1) +"'>" +
					"<div class='form-group'><label for='idForraje'>Forraje:</label> " +
					"<select id='idForraje" + (counter3 + 1) +"' class='form-control' name='idForraje[]' onChange='obtener_especificacionf(" + (counter3 + 1) + ")'>" + forraje + "</select></div><div class='form-group'> " +
					"<label for='PrecioIngrediente'>Precio:</label><input required id='PrecioForraje' class='form-control' type='text' size='30' maxlength='30' name='PrecioForraje[]'> " +
					"</div><div class='form-group'><label for='idEspecificacion'>Especificacion:</label> " +
					"<input name='idEspecificacionf[]' value='0' type='text' class='form-control'/></div><div class='form-group'><button name='Guardar' onclick='eliminar_forraje(" + (counter3 + 1) + ")' type='button' id='eliminar_div' class='btn btn-primary'>-</button></div></div>");
		counter3++;
		} else {
			$("#Forraje").append("<div id='referencia3" + (counter3 + 1) +"'><div class='form-group'><label for='idIngrediente'>Ingrediente:</label> " +
					"<select id='idForraje" + (counter3 + 1) +"' class='form-control' name='idForraje[]' onChange='obtener_especificacionf(" + (counter3 + 1) + ")'>" + forraje + "</select></div><div class='form-group'> " +
					"<label for='PrecioIngrediente'>Precio:</label><input required id='PrecioForraje' class='form-control' type='text' size='30' maxlength='30' name='PrecioForraje[]'> " +
					"</div><div class='form-group'><label for='idEspecificacionf'>Especificacion:</label> " +
					"<input name='idEspecificacionf[]' value='0' type='text' class='form-control'/></div><div class='form-group' id='botonf'></div></div>");
		counter3++;
		}
	}
</script>
