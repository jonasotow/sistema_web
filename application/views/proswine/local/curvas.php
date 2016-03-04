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
    	<?= $formulario; ?>
		<?= $table;?>
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
		$('input[name=groupd_id_group]').attr('value',"");
		$('input[name=idgroupd_det]').attr('value',"");
		$('input[name=groupd_week]').attr('value',"");
		$('input[name=groupd_qty]').attr('value',"");
		$('textarea[name=groupd_cmmt]').html('');
		$('button[name=eliminar]').attr('disabled',true);
		$('button[type=reset]').attr('disabled',true);
		
		$('table tbody tr').delegate("td", "click", function(event){
			if (this.id !== ''){
				var currentCellText = $(this).text();
				var RowIndex =$(this).parent().parent().children().index($(this).parent());
				var ColIndex = $(this).parent().children().index($(this));
				var ColName = $("thead tr").children(':eq(' + ColIndex + ')').text();
				var Row = $('table tbody tr')[RowIndex];
	            $('input[name=idgroupd_det]').attr('value',this.id);
	            $('input[name=groupd_id_group]').attr('value',Row.cells[1].innerHTML);
	            $('input[name=groupd_week]').attr('value',ColName);
	            $('input[name=groupd_qty]').attr('value',currentCellText);
	            $('textarea[name=groupd_cmmt]').html($(this).data('cmmt'));
	            $('button[name=eliminar]').attr('disabled',false);
	            $('button[type=reset]').attr('disabled',false);
        	}
		});
		
		$('input').on("change",function(event){
			if (this.name == 'groupd_id_group'){
				try{
					var qty = $('table tbody tr')[this.value - 1].cells[parseInt($('input[name=groupd_week]').val()) + 2].innerHTML;
					$('input[name=idgroupd_det]').attr('value',$('table tbody tr')[this.value - 1].cells[parseInt($('input[name=groupd_week]').val()) + 2].id);
					$('textarea[name=groupd_cmmt]').html($($('table tbody tr')[this.value - 1].cells[parseInt($('input[name=groupd_week]').val()) + 2]).data('cmmt'));
					$('input[name=groupd_qty]').attr('value',qty);
					$('button[name=eliminar]').attr('disabled',false);
					$('button[type=reset]').attr('disabled',false);
				} catch(err){
					$('input[name=idgroupd_det]').attr('value',"");
					$('input[name=groupd_week]').attr('value',"");
					$('input[name=groupd_qty]').attr('value',"");
					$('button[name=eliminar]').attr('disabled',true);
					$('button[type=reset]').attr('disabled',true);
				}
			}
			if (this.name == 'groupd_week'){
				try{
					var qty = $('table tbody tr')[$('input[name=groupd_id_group]').val() - 1].cells[parseInt($(this).val()) + 2].innerHTML;
					$('input[name=idgroupd_det]').attr('value',$('table tbody tr')[$('input[name=groupd_id_group]').val() - 1].cells[parseInt($(this).val()) + 2].id);
					$('textarea[name=groupd_cmmt]').html($($('table tbody tr')[$('input[name=groupd_id_group]').val() - 1].cells[parseInt($(this).val()) + 2]).data('cmmt'));
					$('input[name=groupd_qty]').attr('value',qty);
					$('button[name=eliminar]').attr('disabled',false);
					$('button[type=reset]').attr('disabled',false);
				} catch(err){
					$('input[name=idgroupd_det]').attr('value',"");
					$('input[name=groupd_week]').attr('value',"");
            		$('input[name=groupd_qty]').attr('value',"");
					$('button[name=eliminar]').attr('disabled',true);
					$('button[type=reset]').attr('disabled',true);
				}
			}
		});
		var confirmation = $('#dialog-confirm').dialog({
		autoOpen: false,
		resizable: false,
      	width:600,
		minHeight:100,
      	modal: true,
     	buttons: {
        	"Eliminar": function() {
	        	$('input[name=groupd_site]').attr('value',<?=$sitio;?>);
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
		$('button[type=submit]').on('click',function(event){
			if(this.id === 'eliminar'){
				event.preventDefault();
				confirmation.dialog('open');
  				return false;
			}
			$('input[name=groupd_site]').attr('value',<?=$sitio;?>);
		});
		$('button[type=reset]').on('click',function(event){
			event.preventDefault();
			$('input[name=groupd_id_group]').attr('value',"");
			$('input[name=idgroupd_det]').attr('value',"");
			$('input[name=groupd_week]').attr('value',"");
			$('input[name=groupd_qty]').attr('value',"");
			$('textarea[name=groupd_cmmt]').html('');
			$('button[name=eliminar]').attr('disabled',true);
			$('button[type=reset]').attr('disabled',true);
		});
	});
</script>