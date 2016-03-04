<div class="container">
	<?=$agregar;?>
    <?=$table;?>
</div>
<script>
 	$( document ).ready(function() {
     	$('table.table tbody').delegate("tr", "click", function(){
        	location.href = '<?=$action;?>' + "/" + this.cells[0].innerHTML;
    	});
 	});
</script>