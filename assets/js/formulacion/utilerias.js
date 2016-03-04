$( document ).ready(function() {
   $('#Datos').hide();
   $('#Tipo_Ganado').hide();
   $('#Detalles').hide();
   $('#Fases').hide();
   $('#Alimentacion').hide();
   $('#Micros').hide();
   $('#Concentrados').hide();
   $('#MicrosEspeciales').hide();
   $('#Ingrediente').hide();
   $('#Forraje').hide();
   $('#Comentario').hide();
   $('#botones').hide();
   $("#boton_siguiente").append("<div class='form-group'><button name='boton1' onclick='datos()' type='button' id='boton1' class='btn btn-primary'>Siguiente >></button></div>");
   campos_fases();
   campos_ingrediente();
   $("#boton").append("<button name='Guardar' onclick='campos_fases()' type='button' id='guardar_especie' class='btn btn-primary'>+</button>");
   $("select[name=Formato]").change(function(){
   		Formato = $("#Formato option:selected").val();
		$.post(base_url + "formulacion/formulacion_ganaderia/llenar_tipo_ganado", {
		Formato : Formato
		}, function(data) {
			$("select[name=idTipo_Ganado]").html(data);
		});
	});
   var Fecha = $.now();
   $("#Fecha").val($.datepicker.formatDate('dd/MM/yy', new Date()));
});

function calculos(){
	var Produccion = $("#Produccion").val();
	var Secas = $("#Secas").val();
	var Reemplazos = $("#Reemplazos").val();
	var Total = (parseInt(Produccion)+parseInt(Secas)+parseInt(Reemplazos));
	$("#NoCabezas").val(isNaN(parseInt(Total)) ? 0 : parseInt(Total));
}

$(document).on("change", "select[id*='idfase']", function(event) {
	var fase = $(this).data("fase");
	var id = $("#idfase" + parseInt(fase) +" option:selected").val();
	$.post(base_url + "formulacion/formulacion_ganaderia/llenar_producto", {
		idFase : id
		}, function(data) {
			$("select[id=idProducto" + parseInt(fase) + "]").html(data);
	});
})

/* function obtener_especificacion(posicion){
	$("select[id=idIngrediente" + posicion +"]").change(function() {
		idIngrediente = $('select[id=idIngrediente'+ posicion +']').val();
		$.post(base_url + "formulacion/formulacion_ganaderia/llenar_especificacion", {
		idIngrediente : idIngrediente
	}, function(data) {
			$("select[id=idEspecificacion" + posicion + "]").html(data);
		});
	})
}

function obtener_especificacionf(posicion){
	$("select[id=idForraje" + posicion +"]").change(function() {
		idForraje = $('select[id=idForraje'+ posicion +']').val();
		$.post(base_url + "formulacion/formulacion_ganaderia/llenar_especificacion", {
		idForraje : idForraje
	}, function(data) {
			$("select[id=idEspecificacionf" + posicion + "]").html(data);
		});
	})
} */

function obtener_fases(valor){
	Formato = $("#Formato option:selected").val();
	/* obtener_tipo_ganado(Formato); */
	if(!valor){
		$.post(base_url + "formulacion/formulacion_ganaderia/llenar_fase", {
			Formato : Formato
		}, function(data) {
				$("select[id=idfase1]").html(data);
	});
	} else {
		$.post(base_url + "formulacion/formulacion_ganaderia/llenar_fase", {
			Formato : Formato
		}, function(data) {
				$("select[id=idfase" + valor +"]").html(data);
		});
	}
}

/* function obtener_tipo_ganado(Formato){
	$.post(base_url + "formulacion/formulacion_ganaderia/llenar_tipo_ganado", {
		Formato : Formato
	}, function(data) {
		$("select[id=idTipo_Ganado]").html(data);
	});
} */

/* function rango(){
	var idFase = $("#idFase option:selected").val();
	$.ajax({
			url: '../rango',
			type:'POST',
			dataType: 'json',
			success: function(idFase){
					$('#Rango').html(rango);
				} // Fin de success
			}); // Fin de la llamada al ajax
} */

function datos(){
	if ($("#Formato option:selected").val() && $("#Formato option:selected").val() != 0) {
		//$("#Formato").prop('disabled', true);
		$('#Datos').show("fast");
		$('#boton1').hide();
		/* $("#Formato").append("<i class='fa fa-check fa-fw fa-lg'></i>"); */
		$('html,body').animate({
    		scrollTop: $("#Datos").offset().top
			}, 3000); 
		$("#boton_siguiente").append("<div class='form-group'><button name='boton2' onclick='detalles()' type='button' id='boton2' class='btn btn-primary'>Siguiente >></button></div>");	
	} else {
		alert("Seleccione el formato a formular.");
	}
}

function detalles(){
	if ($('#Solicitante').val().trim() === '') {
		alert("El campo 'Solicitante' esta vacio.");
		$( "#Solicitante" ).focus();
	} else if($('#Fecha').val().trim() === ''){
		alert("El campo 'Fecha' esta vacio.");
		$( "#Fecha" ).focus();
	} else if($('#Nombre_Cliente').val().trim() === ''){
		alert("El campo 'Nombre Cliente' esta vacio.");
		$( "#Nombre_Cliente" ).focus();
	} else if ($('input[name="Tipo_Cliente"]').is(':checked')) {
		$('#boton2').hide();
		var seleccion = $("#Formato option:selected").val();
		$('#Detalles').show("fast");
		$('html,body').animate({
    		scrollTop: $("#Detalles").offset().top
		}, 3000); 
		if (seleccion == 1 || seleccion == 3){
			//DEFINIR VARIABLES DINAMICAS
			$("#Desparasitante").val("NO");
			$("#Implante").val("NO");
			$("#Vacuna").val("NO");
			$('#Tipo_Ganado').show("fast");
			$('#Fases').show("fast");
			$('label[for="Produccion"]').hide();
			$('label[for="Secas"]').hide();
			$('label[for="Reemplazos"]').hide();
			$('#Produccion').hide();
			$('#Secas').hide();
			$('#Reemplazos').hide();
			$("#boton_siguiente").append("<div class='form-group'><button name='boton3' onclick='ingredientes()' type='button' id='boton3' class='btn btn-primary'>Siguiente >></button></div>");	
			/* $("#Datos").append("<i class='fa fa-check fa-fw fa-lg'></i>"); */
		} else if(seleccion == 2){
			$('#Alimentacion').show("fast");
			$('label[for="Implante"]').hide();
			$('label[for="Desparasitante"]').hide();
			$('label[for="Vacuna"]').hide();
			$('#Implante').hide();
			$('#Desparasitante').hide();
			$('#Vacuna').hide();
			$("#boton_siguiente").append("<div class='form-group'><button name='boton7' onclick='micro_lechero()' type='button' id='boton7' class='btn btn-primary'>Siguiente >></button></div>");	
		}
	} else {
		alert("Debe especificar el tipo de cliente.");
	}
}

function micro_lechero(){
	if ($('input[name="TipoFormulacion"]').is(':checked')) {
		$('#boton7').hide();
		$('#Concentrados').show("fast");
		//$("#Concentrados").append("<div class='form-group'><button name='micro' onclick='campos_concentrado()' type='button' id='micro' class='btn btn-primary'>+ Concentrado</button></div>");	
		$('html,body').animate({
	    		scrollTop: $("#Concentrados").offset().top
				}, 3000); 
		$("#boton_siguiente").append("<div class='form-group'><button name='boton8' onclick='ingredientes()' type='button' id='boton8' class='btn btn-primary'>Siguiente >></button></div>");	
	} else {
		alert("Debe especificar el tipo de alimentacion.");
	}
}

function ingredientes(){
	//$("#MicrosEspeciales").prop('disabled', true);
	$('#boton5').hide();
	$('#boton3').hide();
	$('#boton8').hide();
	$("#boton_siguiente").append("<div class='form-group'><button name='boton6' onclick='Forraje()' type='button' id='boton6' class='btn btn-primary'>Siguiente >></button></div>");	
	$('#Ingrediente').show("fast");
	 $('html,body').animate({
    		scrollTop: $("#Ingrediente").offset().top
			}, 3000); 
	$("#botoni").append("<div class='form-group'><button name='ingrediente' onclick='campos_ingrediente()' type='button' id='ingrediente' class='btn btn-primary'>+</button></div><br/>");	
}

function Forraje(){
	var seleccion = $('input:radio[name=TipoFormulacion]:checked').val();
	/* var seleccion2 = $("#Formato option:selected").val();
	if(seleccion2 == "2"){ */
 		if(seleccion == "CONCENTRADO"){
			comentario();
		} else {
			$('#Forraje').show();
			$('#boton6').hide();
			campos_racion();
			$("#boton_siguiente").append("<div class='form-group'><button name='boton11' onclick='comentario()' type='button' id='boton11' class='btn btn-primary'>Siguiente >></button></div>");	
			$("#botonf").append("<div class='form-group'><button name='forraje' onclick='campos_racion()' type='button' id='forraje' class='btn btn-primary'>+</button></div><br/>");	
		}
	/* }else{
		comentario();
	} */
}

function comentario(){
	$('#boton6').hide();
	$('#boton11').hide();
	$('#Comentario').show("fast");
	$('html,body').animate({
    		scrollTop: $("#Comentario").offset().top
			}, 3000);
	$('#botones').show();
}


function campos_microespecial(){
	$("#MicrosEspeciales").append("<div class='form-group'><label for='Producto'>Micro Especial:</label> " +
			"<input id='Producto' class='form-control' type='text' size='30' maxlength='30' value='' name='idProductoEspecial[]'> " +
			"</div><div class='form-group'><label for='PrecioEspecial'>Precio:</label> " +
			"<input id='PrecioEspecial' class='form-control' type='text' size='30' maxlength='30' value='' name='PrecioEspecial[]'></div><br/>");
}
	