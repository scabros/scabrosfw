<div id="iconoipad6"></div>
<div id="tituloseccion1">
  <h2> Ingresar</h2>
</div>
<section id="caracteristicas">
  <div id="imagenusuario"> </div>
  <div id="formulario">
  <?php if (isset($msg)){ echo showMsg($msg); } ?>
  <form action="" method="post">
    Usuario (*):<br/> <input type="text" name="user" required />
    Clave (*):<br/> <input type="password" name="pass" required />
    <input type="submit" name="entrar" value="Ingresar" class="envio"/>
  </form>
  <div class="pregunta">Para registrarse como un nuevo usuario y comenzar a sumar puntos haga click <a href="usuarios/registrarse.php">AQUI</a>.</div>
  <div class="pregunta">Para dar de alta sus locales en el sistema de puntos haga click <a href="clientes/registrarse.php">AQUI</a>.</div>
  <div class="pregunta">Olvid&oacute; su contrase&ntilde;a? Haga click <a href="reset-password.php">AQUI</a>.</div>
  </div>
  <div class="borrar"> </div>
</section>
