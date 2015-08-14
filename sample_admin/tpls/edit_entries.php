<div id="iconoipad2"> </div>
<div id="tituloseccion1"><h2>Editar Posteo</h2></div>
<section id="caracteristicas3">
<?php if (isset($msg)){ echo showMsg($msg); } ?>
<div id="datosclientes">
<form action="" method="post" id="editar-datos" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
Titulo (*): <input type="text" name="title" required value="<?php echo $title; ?>" />
Texto (*): <textarea style="width:100%" name="text" required><?php echo $text; ?></textarea>
Tags (*): <input type="text" name="tags" value="<?php echo $tags; ?>" />
Imagen (*): <input type="file" id="image" name="image" />
<input type="submit" name="accion" value="Guardar" class="envio" />
</form>
</div>
<div class="borrar"> </div>
</section>
<script type="text/javascript" src="<?php echo URL.'js/';?>tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    //menubar : false,
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
