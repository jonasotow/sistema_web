<section>
<!-- Include CSS for JQuery Frontier Calendar plugin (Required for calendar plugin) -->
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/calendario/css/frontierCalendar/jquery-frontier-cal-1.3.2.css'); ?>" />
<!-- Include CSS for color picker plugin (Not required for calendar plugin. Used for example.) -->
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/calendario/css/colorpicker/colorpicker.css'); ?>" />
<!-- Include CSS for JQuery UI (Required for calendar plugin.) -->
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/calendario/css/jquery-ui/smoothness/jquery-ui-1.8.1.custom.css'); ?>" />
<!--
Include JQuery Core (Required for calendar plugin)
** This is our IE fix version which enables drag-and-drop to work correctly in IE. See README file in js/jquery-core folder. **
-->
<script type="text/javascript" src="<?=base_url('assets/calendario/js/jquery-core/jquery-1.4.2-ie-fix.min.js'); ?>"></script>
<!-- Include JQuery UI (Required for calendar plugin.) -->
<script type="text/javascript" src="<?=base_url('assets/calendario/js/jquery-ui/smoothness/jquery-ui-1.8.1.custom.min.js'); ?>"></script>
<!-- Include color picker plugin (Not required for calendar plugin. Used for example.) -->
<script type="text/javascript" src="<?=base_url('assets/calendario/js/colorpicker/colorpicker.js'); ?>"></script>
<!-- Include jquery tooltip plugin (Not required for calendar plugin. Used for example.) -->
<script type="text/javascript" src="<?=base_url('assets/calendario/js/jquery-qtip-1.0.0-rc3140944/jquery.qtip-1.0.js'); ?>"></script>
<!-- Manejo de las fechas, poder globalizar las mismas -->
<script type="text/javascript" src="<?=base_url('assets/calendario/js/date.js'); ?>"></script>
<!--
	(Required for plugin)
	Dependancies for JQuery Frontier Calendar plugin.
    ** THESE MUST BE INCLUDED BEFORE THE FRONTIER CALENDAR PLUGIN. **
-->
<script type="text/javascript" src="<?=base_url('assets/calendario/js/lib/jshashtable-2.1.js'); ?>"></script>
<!-- Include JQuery Frontier Calendar plugin -->
<script type="text/javascript" src="<?=base_url('assets/calendario/js/frontierCalendar/jquery-frontier-cal-1.3.2.js'); ?>"></script>
<!-- Some CSS for our example. (Not required for calendar plugin. Used for example.)-->
<style type="text/css" media="screen">
/*
Default font-size on the default ThemeRoller theme is set in ems, and with a value that when combined 
with body { font-size: 62.5%; } will align pixels with ems, so 11px=1.1em, 14px=1.4em. If setting the 
body font-size to 62.5% isn't an option, or not one you want, you can set the font-size in ThemeRoller 
to 1em or set it to px.
http://osdir.com/ml/jquery-ui/2009-04/msg00071.html
*/
.shadow {
	-moz-box-shadow: 3px 3px 4px #aaaaaa;
	-webkit-box-shadow: 3px 3px 4px #aaaaaa;
	box-shadow: 3px 3px 4px #aaaaaa;
	/* For IE 8 */
	-ms-filter: "progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#aaaaaa')";
	/* For IE 5.5 - 7 */
	filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#aaaaaa');
}
</style>
<script type="text/javascript">
$(document).ready(function(){	

	var clickDate = "";
	var clickAgendaItem = "";
	var jfcalplugin = "";
	/**
	 * Initializes calendar with current year & month
	 * specifies the callbacks for day click & agenda item click events
	 * then returns instance of plugin object
	 */
	var jfcalplugin = $("#mycal").jFrontierCal({
		date: new Date(),
		dayClickCallback: myDayClickHandler,
		agendaClickCallback: myAgendaClickHandler,
		agendaMouseoverCallback: myAgendaMouseoverHandler,
		applyAgendaTooltipCallback: myApplyTooltip,
		dragAndDropEnabled: false
	}).data("plugin");
	
	/**
	 * Buscar registros existentes en la base de datos
	 */

	 $.ajax({
        type: 'post',
        url: "<?=site_url('calendario/viewEvent');?>",
		async: false,
		dataType: 'json',
		async: true,
		data: { 'id': <?=$id_usuario;?> },
        success: function(events) {
	        jfcalplugin.deleteAllAgendaItems("#mycal");
	        $.each(events, function(id, event){
		        var allDay = event.cal_allDay !== 1 ? false: true;
		        jfcalplugin.addAgendaItem(
						"#mycal",
						event.cal_what,
						Date.parse(event.cal_startDate),
						Date.parse(event.cal_endDate),
						allDay,
						event.Data,
						{
							backgroundColor: event.cal_backgroundColor,
							foregroundColor: event.cal_foregroundColor
						}
					);
	        });
	    }
    });
	
	/**
	 * Custom tooltip - use any tooltip library you want to display the agenda data.
	 * for this example we use qTip - http://craigsworks.com/projects/qtip/
	 *
	 * @param divElm - jquery object for agenda div element
	 * @param agendaItem - javascript object containing agenda data.
	 */
	function myApplyTooltip(divElm,agendaItem){

		// Destroy currrent tooltip if present
		if(divElm.data("qtip")){
			divElm.qtip("destroy");
		}
		
		var displayData = "";
		
		var title = agendaItem.title;
		var startDate = agendaItem.startDate;
		var endDate = agendaItem.endDate;
		var allDay = agendaItem.allDay;
		var data = agendaItem.data;

		var etiqueta = "";
		var viaje_ida = "";
		var viaje_regreso = "";

		displayData += "<br><b>" + title+ "</b><br><br>";
		if(allDay){
			displayData += "(All day event)<br><br>";
		}else{

			//displayData += "<b>Fecha Inicio:</b> " + startDate.toLocaleTimeString() + "<br>" + "<b>Fecha Final:</b> " + endDate.toLocaleTimeString() + "<br><br>";

			displayData += "<b style='font-size: 12px; color: red;'>La hora real contiene los tiempos del traslado.</b><br><br>";

			for (var propertyName in data) {
				if(propertyName === "tiempo_ida") {
					etiqueta = "Duración viaje de ida";
					displayData += "<b>" + etiqueta + ":</b> " + data[propertyName] + " Hrs." + "<br>";
					viaje_ida = data[propertyName];
				}
			}
			
			for(var propertyName in data){
				if(propertyName === "tiempo_regreso")
					viaje_regreso = data[propertyName];
			}
			
			displayData += "<b>Hora Inicio:</b> " + new Date(startDate.getTime() + (viaje_ida * 3600000)).toTimeString().substr(0,startDate.toTimeString().indexOf('GMT') - 1)
				 + "<br>" + "<b>Hora Final:</b> " + new Date(endDate.getTime() - (viaje_regreso * 3600000)).toTimeString().substr(0,endDate.toTimeString().indexOf('GMT') - 1) + "<br>";
				 
			displayData += "<b>Duración viaje de regreso:</b> " + viaje_regreso + " Hrs." + "<br><br>";

			displayData += "<b>Hora real inicio:</b> " + startDate.toTimeString().substr(0,startDate.toTimeString().indexOf('GMT') - 1) + "<br>";
			displayData += "<b>Hora real final:</b> " + endDate.toTimeString().substr(0,endDate.toTimeString().indexOf('GMT') - 1) + "<br><br />";
		}
		for (var propertyName in data) {

			if(propertyName === "gran_nombre") {
				etiqueta = "Granja";
				displayData += "<b>" + etiqueta + ":</b> " + data[propertyName] + "<br>"	
			}

			if(propertyName === "usu_nombre") {
				etiqueta = "Técnico";
				displayData += "<b>" + etiqueta + ":</b> " + data[propertyName] + "<br>"	
			}				
			/*displayData += "<b>" + propertyName + ":</b> " + data[propertyName] + "<br>"	 */
		}

		// use the user specified colors from the agenda item.
		var backgroundColor = agendaItem.displayProp.backgroundColor;
		var foregroundColor = agendaItem.displayProp.foregroundColor;
		var myStyle = {
			border: {
				width: 5,
				radius: 10
			},
			padding: 10, 
			textAlign: "left",
			tip: true,
			name: "dark" // other style properties are inherited from dark theme		
		};
		if(backgroundColor != null && backgroundColor != ""){
			myStyle["backgroundColor"] = backgroundColor;
		}
		if(foregroundColor != null && foregroundColor != ""){
			myStyle["color"] = foregroundColor;
		}
		// apply tooltip
		divElm.qtip({
			content: displayData,
			position: {
				corner: {
					tooltip: "bottomMiddle",
					target: "topMiddle"			
				},
				adjust: { 
					mouse: true,
					x: 0,
					y: -15
				},
				target: "mouse"
			},
			show: { 
				when: { 
					event: 'mouseover'
				}
			},
			style: myStyle
		});

	};

	/**
	 * Make the day cells roughly 3/4th as tall as they are wide. this makes our calendar wider than it is tall. 
	 */
	jfcalplugin.setAspectRatio("#mycal",0.75);

	/**
	 * Called when user clicks day cell
	 * use reference to plugin object to add agenda item
	 */
	function myDayClickHandler(eventObj){
		// Get the Date of the day that was clicked from the event object
		var date = eventObj.data.calDayDate;
		// store date in our global js variable for access later
		clickDate = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
		// open our add event dialog
		var fecha_menor = new Date();
		var dayOfMonth = fecha_menor.getDate();
		fecha_menor.setDate(dayOfMonth - 1);

		if (date > fecha_menor) {
				$('#add-event-form').dialog('open');
			}else{
				alert('Advertencia: Favor de verificar la fecha.');			
			} 
	};
	
	/**
	 * Called when user clicks and agenda item
	 * use reference to plugin object to edit agenda item
	 */
	function myAgendaClickHandler(eventObj){
		// Get ID of the agenda item from the event object
		var agendaId = eventObj.data.agendaId;		
		// pull agenda item from calendar
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
		clickAgendaItem = agendaItem;
		$("#display-event-form").dialog('open');
	};
	
	/**
	 * Called when a user mouses over an agenda item	
	 */
	function myAgendaMouseoverHandler(eventObj){
		var agendaId = eventObj.data.agendaId;
		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
		//alert("You moused over agenda item " + agendaItem.title + " at location (X=" + eventObj.pageX + ", Y=" + eventObj.pageY + ")");
	};
	/**
	 * Initialize jquery ui datepicker. set date format to yyyy-mm-dd for easy parsing
	 */
	$("#dateSelect").datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'yy-mm-dd'
	});
	
	/**
	 * Set datepicker to current date
	 */
	$("#dateSelect").datepicker('setDate', new Date());
	/**
	 * Use reference to plugin object to a specific year/month
	 */
	$("#dateSelect").bind('change', function() {
		var selectedDate = $("#dateSelect").val();
		var dtArray = selectedDate.split("-");
		var year = dtArray[0];
		// jquery datepicker months start at 1 (1=January)		
		var month = dtArray[1];
		// strip any preceeding 0's		
		month = month.replace(/^[0]+/g,"")		
		var day = dtArray[2];
		// plugin uses 0-based months so we subtrac 1
		jfcalplugin.showMonth("#mycal",year,parseInt(month-1).toString());
	});	
	/**
	 * Initialize previous month button
	 */
	$("#BtnPreviousMonth").button();
	$("#BtnPreviousMonth").click(function() {
		jfcalplugin.showPreviousMonth("#mycal");
		// update the jqeury datepicker value
		var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
		var cyear = calDate.getFullYear();
		// Date month 0-based (0=January)
		var cmonth = calDate.getMonth();
		var cday = calDate.getDate();
		// jquery datepicker month starts at 1 (1=January) so we add 1
		$("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);
		return false;
	});
	/**
	 * Initialize next month button
	 */
	$("#BtnNextMonth").button();
	$("#BtnNextMonth").click(function() {
		jfcalplugin.showNextMonth("#mycal");
		// update the jqeury datepicker value
		var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
		var cyear = calDate.getFullYear();
		// Date month 0-based (0=January)
		var cmonth = calDate.getMonth();
		var cday = calDate.getDate();
		// jquery datepicker month starts at 1 (1=January) so we add 1
		$("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);		
		return false;
	});
	
	/**
	 * Initialize add event modal form
	 */

	$("#add-event-form").dialog({
		autoOpen: false,
		height: 650,
		width: 600,
		modal: true,
		buttons: {
			'Agregar': function() {

				var what = jQuery.trim($("#what").val());
			
				if(what == ""){
					alert("Favor de agregar una descripción al evento.");
				}else{
				
					var startDate = $("#startDate").val();
					var startDtArray = startDate.split("-");
					var startYear = startDtArray[0];
					// jquery datepicker months start at 1 (1=January)		
					var startMonth = startDtArray[1];		
					var startDay = startDtArray[2];
					// strip any preceeding 0's		
					startMonth = startMonth.replace(/^[0]+/g,"");
					startDay = startDay.replace(/^[0]+/g,"");

					// Tiempo de Ida y tiempo de regreso
					var tiempoida = jQuery.trim($("#tiempoida").val());
					var tiemporegreso = jQuery.trim($("#tiemporegreso").val());
					tiempoida = parseInt(tiempoida.replace(/^[0]+/g,""));
					tiemporegreso = parseInt(tiemporegreso.replace(/^[0]+/g,"")); 

					var startHour = jQuery.trim($("#startHour").val());
					var startMin = jQuery.trim($("#startMin").val());
					var startMeridiem = jQuery.trim($("#startMeridiem").val());
					startHour = parseInt(startHour.replace(/^[0]+/g,""));	

					// Se restan las horas de ida a la hora inicial del evento
					//startHour = startHour - tiempoida;

					if(startMin == "0" || startMin == "00"){
						startMin = 0;
					}else{
						startMin = parseInt(startMin.replace(/^[0]+/g,""));
					}
					if(startMeridiem == "AM" && startHour == 12){
						startHour = 0;
					}else if(startMeridiem == "PM" && startHour < 12){
						startHour = parseInt(startHour) + 12;
					}

					var endDate = $("#endDate").val();
					var endDtArray = endDate.split("-");
					var endYear = endDtArray[0];
					// jquery datepicker months start at 1 (1=January)		
					var endMonth = endDtArray[1];		
					var endDay = endDtArray[2];
					// strip any preceeding 0's		
					endMonth = endMonth.replace(/^[0]+/g,"");
					
					endDay = endDay.replace(/^[0]+/g,"");
					var endHour = jQuery.trim($("#endHour").val());

					var endMin = jQuery.trim($("#endMin").val());
					var endMeridiem = jQuery.trim($("#endMeridiem").val());
					endHour = parseInt(endHour.replace(/^[0]+/g,""));
	
					if(endMin == "0" || endMin == "00"){
						endMin = 0;
					}else{
						endMin = parseInt(endMin.replace(/^[0]+/g,""));
					}
					if(endMeridiem == "AM" && endHour == 12){
						endHour = 0;
					}else if(endMeridiem == "PM" && endHour < 12){
						endHour = parseInt(endHour) + 12;
					}
					
					//alert("Start time: " + startHour + ":" + startMin + " " + startMeridiem + ", End time: " + endHour + ":" + endMin + " " + endMeridiem);

					// Dates use integers
					var startDateObjdB = new Date(Date.UTC(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),startHour,startMin,0,0));
					var endDateObjdB = new Date(Date.UTC(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay),endHour,endMin,0,0));
					
					var startDateObj = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),startHour,startMin,0,0);
					var endDateObj = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay),endHour,endMin,0,0);

					var aux_fechain = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),startHour,startMin,0,0);
					var aux_fechafin = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay),endHour,endMin,0,0);

					// Para base de datos
					var idadB = startDateObjdB.setHours(startDateObjdB.getHours() - tiempoida);
					var vueltadB = endDateObjdB.setHours(endDateObjdB.getHours() + tiemporegreso);
					startDateObjdB.setTime(idadB);
					endDateObjdB.setTime(vueltadB);

					//Para vista
					var ida = startDateObj.setHours(startDateObj.getHours() - tiempoida);
					var vuelta = endDateObj.setHours(endDateObj.getHours() + tiemporegreso);
					startDateObj.setTime(ida);
					endDateObj.setTime(vuelta); 

					// add new event to the database
					var temp = new Array();
					var id = $('#tecnicos').val();
					$('#tecnicos option[value=' + id + ']').html()
					temp.push({
							what: what, 
							startDate: startDateObjdB, 
							endDate: endDateObjdB,
							allDay: false,
							data : {
								tec_id_usuario: $('#tecnicos').val(),
								usu_nombre: $('#tecnicos option[value=' + id + ']').html(),
								gran_id_granja: $('#granjas').val(),
								gran_nombre: $('#granjas option[value=' + $('#granjas').val() + ']').html(),
								tiempo_ida: $('#tiempoida').val(),
								tiempo_regreso: $('#tiemporegreso').val()
							},
							backgroundColor: $('#tecnicos option[value=' + id + ']').attr('data-color'),
							foregroundColor: "#FFFFFF"
						});			



					if(aux_fechain.toLocaleTimeString() > aux_fechafin.toLocaleTimeString()){
						alert('ERROR: Fecha de inicio no puede ser mayor a la final.');	
					}
					else if(aux_fechain.toLocaleTimeString() == aux_fechafin.toLocaleTimeString()){
						alert("ERROR: Las fechas no pueden ser iguales.");
					}
					else
					{
						$.ajax({
				        type: 'post',
				        url: "<?=site_url('calendario/addEvent');?>",
				        data: { datos: JSON.stringify(temp)},
		    			async: false,
				        success: function(msg) {
				        	if(eval(msg) != 0){
					        	jfcalplugin.addAgendaItem(
									"#mycal",
									what,
									startDateObj,
									endDateObj,
									false,
									{
										tec_id_usuario: $('#tecnicos').val(),
										usu_nombre: $('#tecnicos option[value=' + id + ']').html(),
										gran_id_granja: $('#granjas').val(),
										gran_nombre: $('#granjas option[value=' + $('#granjas').val() + ']').html(),
										tiempo_ida: $('#tiempoida').val(),
										tiempo_regreso: $('#tiemporegreso').val(),
										id: msg
									},
									{
										backgroundColor: $('#tecnicos option[value=' + id + ']').attr('data-color'),
										foregroundColor: "#FFFFFF"
									}
								);
					    	}
					    	else{
					    		alert('ERROR: Favor de verificar hora y fecha seleccionadas.');
					    	}
					    }
				    	});
					}

					$(this).dialog('close');

				}
				
			},
			Cancelar: function() {
				$(this).dialog('close');
			}
		},
		open: function(event, ui){
			// initialize start date picker
			$("#startDate").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'yy-mm-dd',
				minDate: "-0D"
			});
			// initialize end date picker
			$("#endDate").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				changeMonth: true,
				changeYear: true,
				showButtonPanel: true,
				dateFormat: 'yy-mm-dd',
				minDate: "-0D"
			});
			// initialize with the date that was clicked
			$("#startDate").val(clickDate);
			$("#endDate").val(clickDate);
			// initialize color pickers
			/* $("#colorSelectorBackground").ColorPicker({
				color: "#333333",
				onShow: function (colpkr) {
					$(colpkr).css("z-index","10000");
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$("#colorSelectorBackground div").css("backgroundColor", "#" + hex);
					$("#colorBackground").val("#" + hex);
				}
			}); */
			//$("#colorBackground").val("#1040b0");		
			$("#colorSelectorForeground").ColorPicker({
				color: "#ffffff",
				onShow: function (colpkr) {
					$(colpkr).css("z-index","10000");
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$("#colorSelectorForeground div").css("backgroundColor", "#" + hex);
					$("#colorForeground").val("#" + hex);
				}
			});
			$("#what").focus();
		},
		close: function() {
			// reset form elements when we close so they are fresh when the dialog is opened again.
			$("#startDate").datepicker("destroy");
			$("#endDate").datepicker("destroy");
			$("#startDate").val("");
			$("#endDate").val("");
			$("#tiempoida").val("");
			$("#tiemporegreso").val("");
			$("#startHour option:eq(0)").attr("selected", "selected");
			$("#startMin option:eq(0)").attr("selected", "selected");
			$("#startMeridiem option:eq(0)").attr("selected", "selected");
			$("#endHour option:eq(0)").attr("selected", "selected");		
			$("#endMin option:eq(0)").attr("selected", "selected");
			$("#endMeridiem option:eq(0)").attr("selected", "selected");			
			$("#what").val("");
		}
	});
	
	/**
	 * Initialize display event form.
	 */
	 
				
	$("#display-event-form").dialog({
		autoOpen: false,
		height: 600,
		width: 450,
		modal: true,
		buttons: {		
			Cancelar: function() {
				$(this).dialog('close');
			},
			/*'Editar': function() {
				alert("Make your own edit screen or dialog!");
			}, */
			'Eliminar': function() {
				if(confirm("¿Seguro que desea eliminar este evento?")){
					if(clickAgendaItem != null){
						//Eliminar de la db
						var data = clickAgendaItem.data;
						var id = 0;
						for (var propertyName in data) {
							if(propertyName == 'id')
							id = data[propertyName];	
						}
						$.ajax({
					        type: 'post',
					        url: "<?=site_url('calendario/delEvent');?>",
					        data: { 'id': id},
			    			async: false,
					        success: function(msg) {}
					    });
						jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId);
					}
					$(this).dialog('close');
				}
			}			
		},
		open: function(event, ui){

			if(clickAgendaItem != null){
				var title = clickAgendaItem.title;
				var startDate = clickAgendaItem.startDate;
				var endDate = clickAgendaItem.endDate;
				var allDay = clickAgendaItem.allDay;
				var data = clickAgendaItem.data;
				var fecha_ida = "";
				// in our example add agenda modal form we put some fake data in the agenda data. we can retrieve it here.
				$("#display-event-form").append(
					"<br><b>" + title+ "</b><br><br>"		
				);				
				if(allDay){
					$("#display-event-form").append(
						"(All day event)<br><br>"				
					);				
				}else{

					for (var propertyName in data) {
						if(propertyName === "tiempo_ida") {
							var x = data[propertyName];
						}
						if(propertyName === "tiempo_regreso") {
							var y = data[propertyName];
						}
					}

					$("#display-event-form").append(
						/*"<b>Fecha Inicio:</b> " + startDate.toLocaleTimeString() + "<br>" +
						"<b>Fecha Final:</b> " + endDate.toLocaleTimeString() + "<br><br>" + */
						"<b style='font-size: 12px; color: red;'>La hora real contiene los tiempos del traslado.</b><br><br>" +
						"<b>Duración viaje de ida:</b> " + x + " Hrs." + "<br>" +
						"<b>Hora inicio:</b> " + new Date(startDate.getTime() + (x * 3600000)).toTimeString().substr(0,startDate.toTimeString().indexOf('GMT') - 1) + "<br>" +
						"<b>Hora final:</b> " + new Date(endDate.getTime() - (y * 3600000)).toTimeString().substr(0,endDate.toTimeString().indexOf('GMT') - 1) + "<br>" +					
						"<b>Duración viaje de regreso:</b> " + y + " Hrs."+ "<br><br />" +
						"<b>Hora real inicio:</b> " + startDate.toTimeString().substr(0,startDate.toTimeString().indexOf('GMT') - 1) + "<br>" +
						"<b>Hora real final:</b> " + endDate.toTimeString().substr(0,endDate.toTimeString().indexOf('GMT') - 1) + "<br><br />"
					);				
				}
				for (var propertyName in data) {

					if(propertyName === "gran_nombre") {
						etiqueta = "Granja";
						$("#display-event-form").append("<b>" + etiqueta + ":</b> " + data[propertyName] + "<br>");
					}

					if(propertyName === "usu_nombre") {
						etiqueta = "Técnico";
						$("#display-event-form").append("<b>" + etiqueta + ":</b> " + data[propertyName] + "<br>");
					}			

					
				}			
			}		
		},
		close: function() {
			// clear agenda data
			$("#display-event-form").html("");
		}
	});
	
	$('#cal_tecnicos').change(function(event){
		jfcalplugin.deleteAllAgendaItems("#mycal");
		$.ajax({
	        type: 'post',
	        url: "<?=site_url('calendario/viewEvent');?>",
			async: false,
			dataType: 'json',
			async: true,
			data: { 'id': $(this).val() },
	        success: function(events) {
		        $.each(events, function(id, event){
			        var allDay = event.cal_allDay !== 1 ? false: true;
			        jfcalplugin.addAgendaItem(
							"#mycal",
							event.cal_what,
							Date.parse(event.cal_startDate),
							Date.parse(event.cal_endDate),
							allDay,
							event.Data,
							{
								backgroundColor: event.cal_backgroundColor,
								foregroundColor: event.cal_foregroundColor
							}
						);
		        });
		    }
	    });
	});
});

</script>
	<label class="" style="margin-left: 122px; margin-top:15px; font-size:14px;">Selecciona un T&eacute;cnico</label>
	<?=$cal_tecnicos;?>
	<div id="example" style="margin: auto; width:80%;">
	<div id="toolbar" class="ui-widget-header ui-corner-all" style="padding:3px; vertical-align: middle; white-space:nowrap; overflow: hidden;">
		<button id="BtnPreviousMonth">Mes Anterior</button>
		<button id="BtnNextMonth">Mes Siguiente</button>
		Fecha: <input type="text" id="dateSelect" size="20"/>
	</div>
	<div id="mycal"></div>

	</div>

	<!-- Add event modal form -->
	<style type="text/css">
		label, input.text, select { display:block; }
		fieldset { padding:0; border:0; margin-top:25px; }
		.ui-dialog .ui-state-error { padding: .3em; }
		.validateTips { border: 1px solid transparent; padding: 0.3em; }
	</style>
	<div id="display-event-form"></div>
	<div id="add-event-form" title="Agregar evento">
		<p class="validateTips">Todos los campos son requeridos.</p>
		<form>
		<fieldset>
			<label for="name">Evento</label>
			<input type="text" name="what" id="what" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>
			<table style="width:100%; padding:5px;">
				<tr>
					<td></td>
					<td>
						<label>Fecha Inicio</label>
						<input type="text" name="startDate" id="startDate" value="" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>				
					</td>
					<td>&nbsp;</td>
					<td>
						<label>Hora Inicio</label>
						<select id="startHour" class="selectpicker" style="margin-bottom:12px; width:95%; padding: .4em;">
							<option value="12" SELECTED>12</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
						</select>				
					<td>
					<td>
						<label>Minuto Inicio</label>
						<select id="startMin" class="selectpicker" style="margin-bottom:12px; width:95%; padding: .4em;">
							<option value="00" SELECTED>00</option>
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
							<option value="50">50</option>
						</select>				
					<td>
					<td>
						<label>AM/PM</label>
						<select id="startMeridiem" class="selectpicker" style="margin-bottom:12px; width:95%; padding: .4em;">
							<option value="AM" SELECTED>AM</option>
							<option value="PM">PM</option>
						</select>				
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<label>Fecha Fin</label>
						<input type="text" name="endDate" id="endDate" value="" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>				
					</td>
					<td>&nbsp;</td>
					<td>
						<label>Hora Fin</label>
						<select id="endHour" class="selectpicker" style="margin-bottom:12px; width:95%; padding: .4em;">
							<option value="12" SELECTED>12</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
						</select>				
					<td>
					<td>
						<label>Minuto Fin</label>
						<select id="endMin" class="selectpicker" style="margin-bottom:12px; width:95%; padding: .4em;">
							<option value="00" SELECTED>00</option>
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
							<option value="50">50</option>
						</select>				
					<td>
					<td>
						<label>AM/PM</label>
						<select id="endMeridiem" class="selectpicker" style="margin-bottom:12px; width:95%; padding: .4em;">
							<option value="AM" SELECTED>AM</option>
							<option value="PM">PM</option>
						</select>				
					</td>				
				</tr>
				<tr>
					<td></td>
					<td>
						<label>Tiempo de ida (Horas)</label>
						<select id="tiempoida" class="selectpicker" style="margin-bottom:12px; width:30%; padding: .4em;">
							<option value="1" SELECTED>1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="11">12</option>
						</select>	
						<label>Tiempo de regreso (Horas)</label>
						<select id="tiemporegreso" class="selectpicker" style="margin-bottom:12px; width:30%; padding: .4em;">
							<option value="1" SELECTED>1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="11">12</option>
						</select>	
					</td>			
				</tr>
			</table>
			<table style="width:100%; padding:5px;">
				<tr>
					<td></td>
					<td>
						<label>Selecciona un T&eacute;cnico</label>
						<?=$tecnicos;?>
					</td>
					<td>
						<label>Selecciona una Granja</label>
						<?=$granjas;?>
					</td>
				</tr>	
			</table>
		</fieldset>
		</form>
	</div>
</section>
