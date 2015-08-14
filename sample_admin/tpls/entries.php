<div id="iconoipad3"> </div>
<div id="tituloseccion1"><h2>Posteos</h2></div>
<section id="caracteristicas3">
<form action="new_entry.php">
  <input type="submit" name="enviar" value="Nuevo Posteo" class="envio btn" /><br/>
</form>	
<?php if (isset($msg)){ echo showMsg($msg); } ?>
<table class="table">
  <tr class="ocultarmob">
    <th>Titulo</th>
    <th class="ocultar">Fecha</th>
    <th class="ocultar">Tags</th>
    <th>Acciones</th>
  </tr>
<?php foreach($entries as $e){ ?>
  <tr>
    <td><?php echo $e['title']; ?></td>
    <td class="ocultar"><?php echo $e['date']; ?></td>
    <td class="ocultar"><?php echo $e['tags']; ?></td>
    <td class="actions">
      <img src="../img/editar.png" class="edit" alt="Editar" title="editar" data-id="<?php echo $e['id']; ?>" />
    </td>
  </tr>
<?php } ?>
</table>
<div class="borrar"> </div>
</section>
<form action="" id="form_entries" class="edit-form" method="POST">
  <input type="hidden" id="id" name="id" value="" /> 
</form>
<script>
function editarPosteo(post){
  $('#form_entries').attr('action', 'edit_entries.php');
  $('#id').val(post);
  $('#form_entries').submit();
}

$( document ).ready(function() {
    $(".edit").on('click', function(){
      post = $(this).data('id');
      editarPosteo(post);
    });
});
</script>
