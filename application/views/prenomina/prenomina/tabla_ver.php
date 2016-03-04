<section>
<?=isset($mensajes) ? $mensajes  : "";?>
  <div class="panel">
    <div class="panel-body"><?=$table;?></div>
  </div>
</section>
<script>
 	$( document ).ready(function() {
     	$('table tbody').delegate("tr", "click", function(){
        	location.href = '<?=$action;?>' + "/" + this.cells[0].innerHTML;
    	});
 	});
</script>