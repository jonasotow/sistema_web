/*var counter = 1;
var limit = 50;
function addInput(divName){
     if (counter == limit)  {
          alert("Se alcanzo el limite" + counter + " inputs");
     }
     else {
        var newdiv = document.createElement('div');
        newdiv.setAttribute("class", "form-group");
        newdiv.innerHTML = 
        	"<label for='addinput' class='control-label right col-xs-2'>Monto " + (counter + 1) + "</label>" + 
        	"<div class='input-group left col-xs-2'> <div class='input-group-addon'>$</div> <input class='form-control' value='0' onkeyup='sumard();' id='valor"+ (counter + 1) +"' type='text' name='myInputs[]'> </div>";

        document.getElementById(divName).appendChild(newdiv);
        counter++;
     }
}

*/
	var counter = 1;
	var limit = 50;
function sumarpagod() {

	importe_total = 0
	
	$(".importe_linea").each(
		function(index, value) {
			importe_total = importe_total + eval($(this).val());
		}
	);
	$("#total").val(importe_total);
}
 
function addpagod() {
	if (counter == limit){
	    alert("Se alcanzo el limite" + counter + " inputs");
	}
	else{

		$('#pago<?=$movcuebanune->cued_id;?>').append('<div <div class="form-group" id="pago'+ (counter + 1) +'"><label class="control-label right col-xs-2">Pago</label><div class="input-group left col-xs-2"><div class="input-group-addon">$</div><input id="pago'+ (counter + 1) +'" type="text" class="form-control importe_linea" onkeyup="sumarpagod();" value="0.00"/>  </div> <button class="btn btn-danger p"onclick="removeDiv(\'pago' + (counter + 1) +'\');">Eliminar</button> </div>');
	
	counter++;
	}
}

function removeDiv(divId) {
   $("#"+divId).remove();

   var sumarpagodn = sumarpagod();
   sumarpagodn();

}
						

																	
																	
																	
