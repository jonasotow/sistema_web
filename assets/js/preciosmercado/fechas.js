//RANGO DE FECHAS
        function pfechas(entrada,salida){
            fechaEntrada = new Array(); 
            fechaEntrada = entrada.split("-"); //Separador
            fechaSalida = new Array(); 
            fechaSalida = salida.split("-"); //Separador
            maxLength(fechaEntrada,fechaSalida,meses(fechaEntrada));
        }
        function anioBisiesto(anio){
            if((anio%4==0 && anio%100 != 0) || anio%400 == 0)
                return 29;
            else
                return 28;
        }
        function meses(fecha){
            var longitud;
            if(fecha[1] == 2)
                return anioBisiesto(fecha[2]);
                    else if(fecha[1] == 1 || fecha[1] == 3 || fecha[1] == 5 || fecha[1] == 7 || fecha[1] == 8 || fecha[1] == 10 || fecha[1] == 12)
                return 31;
                    else
                return 30; 
        }
        function maxLength(fechaIn,fechaOut,longitud){
			var dia;
			var mes;
            array = '';
            while(true){
				dia = ('0' + fechaIn[0]).slice(-2).toString(); //Formateamos numeros a 2 decimales
				mes = ('0' + fechaIn[1]).slice(-2).toString(); //Formateamos numeros a 2 decimales
                array = array + dia + "/"+ mes +"/"+fechaIn[2] + ",";
                if(fechaIn[0] == fechaOut[0] && fechaIn[1] == fechaOut[1] && fechaIn[2] == fechaOut[2]){
                    break;
                } 
                if(fechaIn[0] < longitud){
                    fechaIn[0]++; 
                } else{
                    fechaIn[0] = 0;
                    fechaIn[0]++;
                    fechaIn[1]++;
                    longitud = meses(fechaIn)
                    if(fechaIn[1] > 12){
                        fechaIn[2]++;
                        fechaIn[1]=1
                    }
                }
            }
            //Defenimos nuestra cadena en una cookie
            document.cookie ="array="+array+"; expires=Tue, 12 Jan 2017 12:23:00 GMT; path=/";
        }
        //RANGO DE FECHAS