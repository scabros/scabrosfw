<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title>Error</title>
<link href="<?php echo URL; ?>img/favicon.ico" rel="shortcut icon" />
<link href="<?php echo URL; ?>css/estilos.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>css/notifIt.css">
<script src="<?php echo URL; ?>js/jquery-2.0.3.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/notifIt.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/notify.min.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/common.js"></script>
<style type="text/css">
pre {
  white-space: pre-wrap;       /* CSS 3 */
  white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
  white-space: -pre-wrap;      /* Opera 4-6 */
  white-space: -o-pre-wrap;    /* Opera 7 */
  word-wrap: break-word;       /* Internet Explorer 5.5+ */
}
</style>
</head>
<body>
  <header>
    <div>
      <div> 
        <a href="inicio.php">
          <div style="text-align: center;">
            <img src="img/Ninja_Male.png" width="100px" />
          </div>
        </a>
      </div>
    </div>
    <div class="borrar"></div>
  </header>
  <section id="contenedor">
    <div id="tituloseccion1" style="border: 1px solid red"><h2> Error </h2></div>
    <section id="caracteristicas3">
      <h4 style="margin-left: 10%;">Ups...hubo un problema. Int&eacute;ntalo nuevamente</h4>
      <div>
        <div width="50%;" style="font-size: small;">
          <pre><?php if(isset($error)) echo $error; ?></pre>
        </div>
        <div width="50%;">
          <img style="float: right" src="img/Ninja_Male.png" width="100px" alt="error" />
        </div>
      </div>
    <div class="borrar"> </div>
    </section>
  </section>
  <footer>
    <div id="logo2"> 
      <img width="84" height="68">
    </div>
    <div id="datos">
      <a href="https://github.com/scabros/scabrosfw">Fork on Github</a>
    </div>
  </footer>
  <?php getNotification(); ?>
  <div id="darkLayer" class="darkClass" style="display:none"><!--Cargando...--></div>
</body>
</html>



