<div id="iconoipad6"></div>
<div id="tituloseccion1">
  <h2> Administrador</h2>
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
  </div>
  <div class="borrar"> </div>
</section>
