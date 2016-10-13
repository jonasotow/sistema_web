    function mult()
    {
        var valor1=verificar("valor1");
        var valor2=verificar("valor2");


        document.getElementById("total").value=parseFloat(valor1)*parseFloat(valor2);
    }
  
	    function validate_importe(value,decimal)
	    {
	        if(decimal==undefined)
	            decimal=0;
	 
	        if(decimal==1)
	        {
	            // Permite decimales tanto por . como por ,
	            var patron=new RegExp("^[0-9]+((,|\.)[0-9]{0,4})?$");
	        }else{
	            // Numero entero normal
	            var patron=new RegExp("^([0-9])*$")
	        }
	 
	        if(value && value.search(patron)==0)
	        {
	            return true;
	        }
	        return false;
	    }
