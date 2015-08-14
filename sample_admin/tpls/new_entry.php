<div id="iconoipad3"> </div>
<div id="tituloseccion1"><h2>Nuevo Posteo</h2></div>
<section id="caracteristicas">
<?php if (isset($msg)){ echo showMsg($msg); } ?>

<form action="" method="post" id="editar-datos" enctype="multipart/form-data">
  
Titulo (*): <input type="text" name="title" <?php if(isset($title)){ echo 'value="'.$title.'"'; }?> required />
Texto (*): <input type="text" name="text" <?php if(isset($text)){ echo 'value="'.$text.'"'; }?> required  />
<!-- Fecha (*): <input type="date" name="date" value="<?php if(isset($date)){ echo $date; } else { echo date('d-m-Y');}?>" /> -->
Tags (*): <input type="text" name="tags" <?php if(isset($tags)){ echo 'value="'.$tags.'"'; }?> />
Imagen (*): <input type="file" id="image" name="image" />

<input type="submit" name="enviar" value="Enviar" class="envio" />
</form>
<div class="borrar"> </div>
</section>
<script>
</script>
