<div id="iconoipad6"> </div>
<div id="tituloseccion1"><h2>Resetear Contrase&ntilde;a</h2></div>
<section id="caracteristicas3">
<div id="datosclientes">
<?php if (isset($msg)){ echo showMsg($msg); } ?>
<form action="" method="post" id="reset-pass">
	Nuevo Password (*): <input type="password" name="pass1" />
	Confirmar nuevo password (*): <input type="password" name="pass2" />
<input type="submit" name="accion" value="Guardar" class="envio" />
</form>
</div>
<div class="borrar"> </div>
</section>