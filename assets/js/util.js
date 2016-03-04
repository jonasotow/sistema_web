// JavaScript Document
var mostrarFecha = function(){
        var fecha    = new Date();
        var dia      = fecha.getDate();
        var semana   = fecha.getDay();
        var mes      = fecha.getMonth();
        var anio     = fecha.getFullYear();
        var semanas  =  ["Domingo", "Lunes", "Martes", "Mi&eacute;rcoles", "Jueves", "Viernes", "S&aacute;bado"];
        var meses    =  ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        document.write(semanas[semana] + ", " + dia + " de " + meses[mes] + " de " + anio);
};

var strFecha = function(fecha){
        var dia      = fecha.getDate();
        var semana   = fecha.getDay();
        var mes      = fecha.getMonth();
        var anio     = fecha.getFullYear();
        var semanas  =  ["Domingo", "Lunes", "Martes", "Mi&eacute;rcoles", "Jueves", "Viernes", "S&aacute;bado"];
        var meses    =  ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        return (semanas[semana] + ", " + dia + " de " + meses[mes] + " de " + anio);
};

var strHora = function(fecha){
    var hora     = fecha.getHours();
    var minutos  = fecha.getMinutes();

    if (minutos<=9){
        minutos="0"+minutos;
    }

    return (hora + ":" + minutos);
}

var crearTabla = function(Datos,Id,Class,Caption){
    var Tabla = document.createElement('table');
    Tabla.setAttribute("class",Class);
    Tabla = $(Tabla);
    Tabla.append($(document.createElement('caption')).html(Caption));

    var Head = $(document.createElement('thead'));
    var trHead = $(document.createElement('tr'));
    trHead.append($(document.createElement('th')).html('id'));
    $.each(Columnas(Datos), function(i, item) {
    	trHead.append($(document.createElement('th')).html(item));
	});
	
	Head.append(trHead);
	Tabla.append(Head);
	
	var Body = $(document.createElement('tbody'));
	$.each(Datos,function(i,items){
		var TR = $(document.createElement('tr'));
		TR.append($(document.createElement('td')).html(i));
		$.each(items,function(i,item){
			TR.append($(document.createElement('td')).html(item));
		});
		Body.append(TR);
	});
	Tabla.append(Body);
	return Tabla[0].outerHTML;
};

var Columnas = function(obj) {
	var cols = new Array();
	for (var key in obj[0]) { cols.push(key); }
	return cols;
}

var validateEmail = function(email) { 
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}