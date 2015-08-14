<div id="iconoipad6"></div>
<div id="tituloseccion1">
  <h2> Reseteo de Contraseña</h2>
</div>
<section id="caracteristicas">
  <div id="imagenusuario"> </div>
  <div id="formulario">
  <div class="pregunta">Olvido su contraseña? Complete el formulario y le enviaremos un email con una url de reseteo a la direccion de correo registrada en nuestra base.</div>
  <?php if (isset($msg)){ echo showMsg($msg); } ?>
  <form action="" method="post">
    Email (*):<br/> <input type="text" name="email" required />
    <input type="submit" name="enviar" value="Enviar" class="envio"/>
  </form>
  </div>
  <div class="borrar"> </div>
</section>
