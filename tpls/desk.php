<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title><?php echo TITLE; ?></title>
<link href="<?php echo URL; ?>img/favicon.ico" rel="shortcut icon" />
<link href="<?php echo URL; ?>css/estilos.css" rel="stylesheet" />
<link href="<?php echo URL; ?>css/notifIt.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo URL; ?>js/jquery-2.0.3.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/notifIt.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/notify.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/jquery.simplemodal-1.4.4.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/common.js"></script>
</head>
<body>
  <div id="body-admin">
    <!--<div id="header-admin">Panel de Administraci&oacute;n</div>-->
    <!-- <nav><?php echo $botonera; ?></nav> -->
      <?php echo $contenido; ?>
    <footer><?php echo $footer; ?></footer>
      <div id="darkLayer" class="darkClass" style="display:none"><!--Cargando...--></div>
  </div>
</body>

</html>
