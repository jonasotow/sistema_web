    /**
     * Funcion que se ejecuta cada vez que se añade una letra en un cuadro de texto
     * Suma los valores de los cuadros de texto
     */
    function sumard()
    {
        var valor1=verificard("valor1");
        var valor2=verificard("valor2");
        var valor3=verificard("valor3");
        var valor4=verificard("valor4");
        var valor5=verificard("valor5");
        var valor6=verificard("valor6");

        // realizamos la suma de los valores y los ponemos en la casilla del
        // formulario que contiene el total
        document.getElementById("totald").value=parseFloat(valor1)+parseFloat(valor2)+parseFloat(valor3)+parseFloat(valor4)+parseFloat(valor5)+parseFloat(valor6);
    }
  
    /**
     * Funcion para verificard los valores de los cuadros de texto. Si no es un
     * valor numerico, cambia de color el borde del cuadro de texto
     */
    function verificard(id)
	    {
	        var obj=document.getElementById(id);
	        if(obj.value=="")
	            value="0";
	        else
	            value=obj.value;
	        if(validate_imported(value,1))
	        {
	            // marcamos como erroneo
	            obj.style.borderColor="#808080";
	            return value;
	        }else{
	            // marcamos como erroneo
	            obj.style.borderColor="#f00";
	            return 0;
	        }
	    }


	    /**
	     * Funcion para validar el importe
	     * Tiene que recibir:
	     *  El valor del importe (Ej. document.formName.operator)
	     *  Determina si permite o no decimales [1-si|0-no]
	     * Devuelve:
	     *  true-Todo correcto
	     *  false-Incorrecto
	     */
	    function validate_imported(value,decimal)
	    {
	        if(decimal==undefined)
	            decimal=0;
	 
	        if(decimal==1)
	        {
	            // Permite decimales tanto por . como por ,
	            var patron=new RegExp("^[0-9]+((,|\.)[0-9]{1,2})?$");
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
