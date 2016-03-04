    var array = "";
    var cb = [];
        $(document).ready(function() {
	        $("select").change(function(){
		        if($(this).attr('id') !== 'fuente'){
			        var llamada = undefined;
					if(llamada == undefined){
				        llamada = $.ajax({
					        type: 'post',
					        url: base_url + "preciosmercado/preciosmercado_precio_mer/llenar_select",
							async: true,
							data: { 'tipo': $(this).val(), 'select': $(this).attr('id'), 'clase' :  $('#clase').val() },
							dataType: 'json',
					        success: function(data) {
						        $("#" + data.tipo + " option").remove();
						        $("#" + data.tipo).append($(document.createElement('option')).html('Selecciona un Elemento'));
						        $.each(data,function(valor){
							        if(!isNaN(valor)){
								        option = document.createElement('option');
								        option.setAttribute("value",data[valor]["id" + data.tipo]);
							        	$("#" + data.tipo).append($(option).html(data[valor][data.tipo]));
						        	}
						        });
						        llamada = undefined;
						    }
					    });
				    }
			    }
	        });

            $("#catalogo").submit(function () {
                var url = base_url + "preciosmercado/preciosmercado_precio_mer/buscar_capturas";
                var f = new Date();

                //Ponemos un loader para que el usuario visualize una imagen mientras carga la pagina
                //$('#compras').html('<tr><td colspan="4" align="center"><img src="preciosmercado/assets/img/loading.gif"/></td></tr>');
                var page = $(this).attr('data');        
                var dataString = 'page='+page;
                var anio = document.getElementById("anio").value;
                /*document.getElementById('anio').disabled = true;*/

                pfechas('01-01-'+anio,/* f.getDate()+"-"+(f.getMonth()+1)+"-"+f.getFullYear()*/'31-12-'+anio);
                
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#catalogo").serialize(),
                    success: function(data){
                        $("#compras").html(data);
                    }
                });
                return false;
            })

            $("#datos").submit(function () {
            
                if(confirm("¿Los datos seran guardados, confirmar?")){
                	var url = base_url + "preciosmercado/preciosmercado_precio_mer/guardar_compra";

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: $("#datos").serialize(),
                        success: function(data){
                            var url2 = base_url + "preciosmercado/preciosmercado_precio_mer/buscar_capturas";
                            var f = new Date();

                            //Ponemos un loader para que el usuario visualize una imagen mientras carga la pagina
                            //$('#compras').html('<tr><td colspan="4" align="center"><img src="preciosmercado/assets/img/loading.gif"/></td></tr>');
                            var page = $(this).attr('data');        
                            var dataString = 'page='+page;

                            pfechas('01-01-'+anio,/* f.getDate()+"-"+(f.getMonth()+1)+"-"+f.getFullYear() */'31-12-'+anio);

                            $.ajax({
                                type: "POST",
                                url: url2,
                                data: $("#catalogo").serialize(),
                                success: function(data){
                                    $("#compras").html(data);
                                }
                            });
                        }
                    });
                    return false;
                }else{
                    return false;
                }
                })
            });
        function RevisarFormato(evt)
        {
            var nav4 = window.Event ? true : false; 
            var key = nav4 ? evt.which : evt.keyCode; 
            return (key <= 13 || key==46 || (key >= 38 && key <= 57)); 
        }

        function verifica(nombreGrupo){
                var n=0;
                cb = document.getElementsByName(nombreGrupo);
                for (var i = 0; i < cb.length; i++){
                    var e = parseInt(i);
                    if(cb[i].checked == true){
                        document.getElementById('precio'+cb[i].value).value = document.getElementById('precio_copiar').value;
                        document.getElementById('tipo'+cb[i].value).value = document.getElementById('tipo_copiar').value;
                        n++;
                    }
                }
                if(n != 0){
                    alert("Los datos se han copiado en las casillas seleccionadas.");
                }
        }