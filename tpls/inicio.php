<?php session_start(); 
if (isset($_SESSION['idioma'])) {
	if ($_GET) {
	$i=$_GET['i']; 
$_SESSION['idioma']=$i;
}
} else {
$_SESSION['idioma']='esp';
}?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Que Menú!</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link href="estilos.css" rel="stylesheet"/>
<link href="imagenes/favicon.ico" rel="shortcut icon" />
<link href="slide/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="slide/js-image-slider.js" type="text/javascript"></script>
    <script src="slide/js-image-slider2.js" type="text/javascript"></script>
</head>

<body>
<header>
	<?php
include ("cabecera.php");
?>
</header>
<nav>
<?php
include ("botonera.php");
?>
</nav>
<section id="contenedor"> 
	<section id="slider">
    <?php if($_SESSION['idioma']=='esp') { ?>
            <img src="imagenes/slide1b.jpg" alt="" />
            <img src="imagenes/slide2.jpg" alt="" />
            <img src="imagenes/slide3.jpg" alt="" />
            <img src="imagenes/slide4.jpg" />
    <?php  } 
	if($_SESSION['idioma']=='ing') { ?>
	 		<img src="imagenes/slide1b_ing.jpg" alt="" />
            <img src="imagenes/slide2_ing.jpg" alt="" />
            <img src="imagenes/slide3_ing.jpg" alt="" />
            <img src="imagenes/slide4_ing.jpg" />
	<?php  } ?>
    </section>
    <section id="slider2">
    <?php if($_SESSION['idioma']=='esp') { ?>
            <img src="imagenes/slide1b_b.jpg" alt="" />
            <img src="imagenes/slide2_b.jpg" alt="" />
            <img src="imagenes/slide3_b.jpg" alt="" />
            <img src="imagenes/slide4_b.jpg" />
    <?php  } 
	if($_SESSION['idioma']=='ing') { ?>
	 		<img src="imagenes/slide1b_ing_b.jpg" alt="" />
            <img src="imagenes/slide2_ing_b.jpg" alt="" />
            <img src="imagenes/slide3_ing_b.jpg" alt="" />
            <img src="imagenes/slide4_ing_b.jpg" />
	<?php  } ?>
    </section>
    <section id="beneficios">
    <?php if($_SESSION['idioma']=='esp') { ?>
    	<h2> Totalmente diseñada a su medida </h2>
        <h3> Ideada para todo tipo de locales, restaurantes y hoteles </h3>
        <div class="bene1"> 
        	<h4> Diseño personalizado </h4>
            <p> La imagen es lo más importante. Personalizamos al detalle cada carta electrónica para que respire la imagen de su local. </p>
        </div>
        <div class="bene2">
        	<h4> Multi - Idioma </h4>
            <p> La única carta del mercado con opción multi lenguaje. Español, Ingles, Portugues, Frances, Chino, etc.  </p>
         </div>
        <div class="bene3"> 
        	<h4> Intuitivo y fácil de usar </h4>
            <p> La carta digital habla el mismo idioma que sus clientes. Táctil y de diseño limpio y sencillo hace de ella el menú ideal. </p>
        </div>
     <?php } ?>
      <?php if($_SESSION['idioma']=='ing') { ?>
    	<h2> Fully designed for you. </h2>
        <h3> Designed for all types of premises, restaurants and hotels </h3>
        <div class="bene1"> 
        	<h4> Custom Design </h4>
            <p> The image is the most important. We customize each card retail electronics to breathe from your local image. </p>
        </div>
        <div class="bene2">
        	<h4> Multi - Language </h4>
            <p> The only card on the market with multi language option. Spanish, English, Portuguese, French, Chinese, etc.  </p>
         </div>
        <div class="bene3"> 
        	<h4> Intuitive and easy to use </h4>
            <p> La carta digital habla el mismo idioma que sus clientes. Táctil y de diseño limpio y sencillo hace de ella el menú ideal. </p>
        </div>
     <?php } ?>
    </section>
    <article id="info">
    <?php if($_SESSION['idioma']=='esp') { ?>
    		<h3> Una nueva forma de presentar sus platos en una experiencia innovadora para sus clientes.</h3>
            <p><strong>Potencie las ventas ofreciendo información detallada de cada producto.</strong> 
            <br/>Rentabilice la inversión a corto plazo evitando costosas impresiones de las cartas de papel que cambian cada temporada. Atraiga nuevos clientes actualizando y modernizando la imagen de su local y ofreciéndoles nuevas experiencias.<br/>Aumente las ventas tentando a los clientes con la imagen de tentadores platos y postres. </p>
<?php } 
if($_SESSION['idioma']=='ing') { ?>
<h3> A new way to present your dishes in an innovative experience for their customers.</h3>
            <p><strong>Boost sales by offering detailed information on each product.</strong> 
            <br/>Maximize short term investment impressions avoiding costly paper charts that change every season. Attract new customers upgrading and modernizing the image of his shop and offering new experiences.<br/>Increase Sales enticing customers with the image of tempting dishes and desserts.</p>
<?php }?>

    </article>
    <section id="imagenMenu">
    </section>
</section>
<footer>
<div id="logo2"> 
  <img src="imagenes/logo_footer.png" width="84" height="68">
</div>
<div id="datos">
+54(911) 4411-3498  |  +54(911) 4411-3501  | <a href="mailto:contacto@que-menu.com.ar">contacto@que-menu.com.ar</a>
</div>
<div id="redes"> 
  <img src="imagenes/Retro-Facebok-48.png" width="48" height="48"> 
  <img src="imagenes/Retro-Skype-48.png" width="48" height="48" style="margin-left:10px;"> 
  </div>
</footer>




 <?php
  // Archivo en donde se acumulará el numero de visitas
$IP = getenv('REMOTE_ADDR'); 
$fecha = date("j \d\e\l n \d\e Y"); 
$hora = date("h:i:s"); 
$segundos = time(); 
$can = "3600"; 
$resta = $segundos-$can; 

  $archivo = "numero.dat";
  // Abrimos el archivo para solamente leerlo (r de read)
  $abre = fopen($archivo, "r");
  // Leemos el contenido del archivo
  $total = fread($abre, filesize($archivo));
  // Cerramos la conexión al archivo
  fclose($abre);
  // Abrimos nuevamente el archivo
  $abre = fopen($archivo, "a");
  // Sumamos 1 nueva visita
  // $total = $total + 1;
  $total = $IP." - ".$fecha." - ".$hora." - ".$segundos." - ".$resta." - "."Inicio"."\r\n";
  // Y reemplazamos por la nueva cantidad de visitas 
  $grabar = fwrite($abre, $total);
  // Cerramos la conexión al archivo
  fclose($abre);
  // Imprimimos el total de visitas en una variable ($total)
?> 

</body>
</html>