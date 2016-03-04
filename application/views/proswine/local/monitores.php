<nav class="navbar" role="navigation">
		<a class="navbar-brand regresar"><i class="fa fa-arrow-left"></i></a>
		<a class="navbar-brand" href="<?=!isset($action) ? "" : $action; ?>"><i class="fa fa-plus-square"></i><span class="section-text"></span></a>
      	<ul class="navbar-right breadcrumb">
			<li><a href="<?=site_url('censos/home');?>">Censos</a></li>
			<li class="active"><?=!isset($new) ? "" : $new;?></li>
	 	</ul>	
</nav>
<section>
	<div class="panel panel-primary">
    <div class="panel-heading"><?=!isset($titulo) ? "" : strtoupper($titulo);?></div>
    <div class="panel-body">
    	<?=!isset($tabs) ? "" : $tabs;?>
    	<br />
    	<div id="tabs" class="tab-content">
    	<?= $formulario_montas; ?>
    	<?= $formulario_lactancia; ?>
    	<?= $formulario_engordas; ?>
    	<?= $formulario_pasar_lactancia; ?>
    	<?= $formulario_curvas; ?>
    	<?= $formulario_ventas; ?>
    	<?= $formulario_inv; ?>
		<!-- <?= $table;?> -->
		</div>
    	<?=validation_errors('<div id="msgError">', '</div>'); ?>
    	<div id="dialog-confirm" title="Eliminar Registro" style="width: auto; height: auto;">
  		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Seguro que desea eliminar el registro?</p>
	</div>
    </div>
    <div class="panel-footer"></div>
  </div>
</section>
<script>
	$( document ).ready(function() {
		//Inicializacion
		$.datepicker.regional['es'] = {
				closeText: 'Cerrar',
				prevText: '',
				nextText: 'Sig>',
				currentText: 'Hoy',
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
				dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;;', 'Juv', 'Vie', 'S&aacute;b'],
				dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
				weekHeader: 'Sm',
				dateFormat: 'mm/dd/yy',
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};
		$.datepicker.setDefaults($.datepicker.regional['es']);
		//Navegadores que no soportan input type=date
		(navigator.userAgent.indexOf('MSIE') != -1 || navigator.userAgent.indexOf('Firefox') != -1 || navigator.userAgent.indexOf('Media Center PC') != -1) && $('input[type=date]').datepicker();
		//Cambiar el nombre del legend del form
		$('legend').html($(".tab-pane.active").data('name'));
				
		//variables globales
		var sitio = 1;
		
		//funciones
		var limpiarCampos = function(){
			$(':input form').not(':submit, :reset, :button').val('');
			$('button[id=eliminar]').attr('disabled',true);
			$('button[type=reset]').attr('disabled',true);
			$('input[name=groupd_week]').attr('disabled',true);
			$('input[name=idgroupd_det]').attr('disabled',true);
			$('input[name=groupd_inv]').attr('disabled',true);
			$('input[name=groupd_qty]').attr('disabled',true);
			$('textarea[name=groupd_cmmt]').attr('disabled',true);
		};
		
		//Limpiamos los campos
		limpiarCampos();
		
		var BuscarInv = function(Granja,Semana,year){
			$.ajax({
		        type: 'post',
		        url: "<?=site_url('monitores/buscarInv');?>",
				async: false,
				async: true,
				data: { 'semana': Semana, 'granja': Granja, 'year': year },
		        success: function(inv) {
			        $('input[name=groupd_inv]').attr('value',parseInt(inv));
			        if(parseInt(inv)){
				        $('input[name=groupd_week]').attr('disabled',false);
						$('input[name=idgroupd_det]').attr('disabled',false);
						$('input[name=groupd_inv]').attr('disabled',false);
						$('input[name=groupd_qty]').attr('disabled',false);
						$('textarea[name=groupd_cmmt]').attr('disabled',false);
			            $('button[id=eliminar]').attr('disabled',false);
			            $('button[type=reset]').attr('disabled',false);
			        }
			        else{
				        $('input[name=groupd_inv]').attr('disabled',false);
				        $('input[name=groupd_week]').attr('disabled',true);
						$('input[name=idgroupd_det]').attr('disabled',true);
						$('input[name=groupd_qty]').attr('disabled',true);
						$('textarea[name=groupd_cmmt]').attr('disabled',true);						
			        }
			    }
		    });
		}
		
		var BuscarRow = function(cell){
			if (cell.id !== ''){
				var currentCellText = $(cell).text();
				var RowIndex =$(cell).parent().parent().children().index($(cell).parent());
				var ColIndex = $(cell).parent().children().index($(cell));
				var ColName = $("thead tr").children(':eq(' + ColIndex + ')').text();
				var id = $(".tab-pane.active").attr('id');
				var Row = $('#' + id + ' tbody tr')[RowIndex];
				BuscarInv(window.location.pathname.split( '/' )[window.location.pathname.split( '/' ).length - 2],Row.cells[1].innerHTML,window.location.pathname.split( '/' )[window.location.pathname.split( '/' ).length - 1]);
	            $('input[name=idgroupd_det]').attr('value',cell.id);
	            $('input[name=groupd_id_group]').attr('value',Row.cells[1].innerHTML);
	            $('input[name=groupd_week]').attr('value',ColName);
	            $('input[name=groupd_qty]').attr('value',currentCellText);
	            $('textarea[name=groupd_cmmt]').html($(cell).data('cmmt'));
	            $('button[id=eliminar]').attr('disabled',false);
	            $('button[type=reset]').attr('disabled',false);
        	}
    	};
    	
    	//Dialogos
    	var confirmation = $('#dialog-confirm').dialog({
			autoOpen: false,
			resizable: false,
	      	width:600,
			minHeight:100,
	      	modal: true,
	     	buttons: {
	        	"Eliminar": function() {
		        	$('input[name=groupd_site]').attr('value',sitio);
		        	$('input[name=groupd_qty]').attr('value',0);
		        	$('textarea[name=groupd_cmmt]').html('');	        	
		        	$('form').submit();
	        		$( this ).dialog( "close" );
	        	},
	        		Cancel: function() {
	          		$( this ).dialog( "close" );
	        	}
	    	}
		});
		
		//Eventos		
		$("table").delegate("td","click",function(event){BuscarRow(this);});
		
		$('input').on("change",function(event){
			id = $(".tab-pane.active").attr('id');
			if (this.name == 'groupd_id_group'){
				var num = this.value;
				var td = $('#' + id + " tbody tr td").filter(function(){
				    if($(this).text() === num && !$(this).is(':visible'))
					    return this;
				})[0];
				BuscarInv(window.location.pathname.split( '/' )[window.location.pathname.split( '/' ).length - 2],this.value,window.location.pathname.split( '/' )[window.location.pathname.split( '/' ).length - 1]);
				try{
					$('input[name=idgroupd_det]').attr('value',$('#' + id + " tbody tr")[$(td).parent().parent().children().index($(td).parent())].cells[parseInt($('input[name=groupd_week]').val()) + 2].id);
					$('textarea[name=groupd_cmmt]').html($($('#' + id + " tbody tr")[$(td).parent().parent().children().index($(td).parent())].cells[parseInt($('input[name=groupd_week]').val()) + 2]).data('cmmt'));
					$('input[name=groupd_qty]').attr('value',$('#' + id + " tbody tr")[$(td).parent().parent().children().index($(td).parent())].cells[parseInt($('input[name=groupd_week]').val()) + 2].innerHTML);
					$('button[id=eliminar]').attr('disabled',false);
					$('button[type=reset]').attr('disabled',false);
				} catch(err){
					$('input[name=idgroupd_det]').attr('value',"");
					$('input[name=groupd_week]').attr('value',"");
					$('input[name=groupd_qty]').attr('value',"");
					$('button[id=eliminar]').attr('disabled',true);
					$('button[type=reset]').attr('disabled',true);
				}
			}
			if (this.name == 'groupd_week'){
				var num = $('input[name=groupd_id_group]').val();
				var td = $('#' + id + " tbody tr td").filter(function(){
				    if($(this).text() === num && !$(this).is(':visible'))
					    return this;
				})[0];
				try{
					$('input[name=idgroupd_det]').attr('value',$('#' + id + " tbody tr")[$(td).parent().parent().children().index($(td).parent())].cells[parseInt(this.value) + 2].id);
					$('textarea[name=groupd_cmmt]').html($($('#' + id + " tbody tr")[$(td).parent().parent().children().index($(td).parent())].cells[parseInt(this.value) + 2]).data('cmmt'));
					$('input[name=groupd_qty]').attr('value',$('#' + id + " tbody tr")[$(td).parent().parent().children().index($(td).parent())].cells[parseInt(this.value) + 2].innerHTML);
					$('button[id=eliminar]').attr('disabled',false);
					$('button[type=reset]').attr('disabled',false);
				} catch(err){
					$('input[name=idgroupd_det]').attr('value',"");
					$('input[name=groupd_week]').attr('value',"");
            		$('input[name=groupd_qty]').attr('value',"");
					$('button[id=eliminar]').attr('disabled',true);
					$('button[type=reset]').attr('disabled',true);
				}
			}
		});
		
		$('button[type=submit]').on('click',function(event){
			if(this.id === 'eliminar'){
				event.preventDefault();
				confirmation.dialog('open');
  				return false;
			}
			$('input[name=groupd_site]').attr('value',sitio);
		});
		
		$('button[type=reset]').on('click',function(event){
			event.preventDefault();
			limpiarCampos();
		});
		
		//Tabuladores
		$('#menuTabs a').click(function (e) {
			e.preventDefault();
			$('legend').html($("#" + this.toString().split('#')[1]).data('name'));
			sitio = $("#" + this.toString().split('#')[1]).data('site');
			limpiarCampos();
			$(this).tab('show');
		})
	});
</script>