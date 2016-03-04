<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="Aplicaciones para clientes y trabajadores de Vimifos, empresa lider en nutricion animal en Mexico">
   <meta name="keywords" content="vimifos censos sistemas internos">
   <meta name="author" content="Vimifos">

   <title>Vimifos</title>

   <link rel="shortcut icon" href="<?=base_url().'assets/img/favicon.ico'?>" />
   <link rel="stylesheet" href="<?=base_url().'assets/css/bootstrap.css'?>" >
   <link rel="stylesheet" href="<?=base_url().'assets/css/font-awesome.css'?>" >
   <link rel="stylesheet" href="<?=base_url().'assets/css/estadoscta/estilo.css'?>" >
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
   <script type="text/javascript">
      //<![CDATA[
         base_url = '<?=base_url();?>index.php/';
      //]]>
   </script>
   <script src="<?=base_url().'assets/js/jquery-1.11.1.min.js'?>"></script>
   
   <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
   <!--<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/1.3.1/lodash.min.js"></script>
   -->
   <script src="<?=base_url().'assets/js/bootstrap.min.js'?>"></script>
   <script src="<?=base_url().'assets/js/util.js';?>"></script>
   
   <script>
      $(document).ready(function(){
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
            dateFormat: 'dd/mm/yy',
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
         };
      $.datepicker.setDefaults($.datepicker.regional['es']);
      //Navegadores que no soportan input type=date
      (navigator.userAgent.indexOf('MSIE') != -1 || navigator.userAgent.indexOf('Firefox') != -1 || navigator.userAgent.indexOf('Media Center PC') != -1) && $('input[type=date]').datepicker();
   })
   </script>
</head>
<body>
