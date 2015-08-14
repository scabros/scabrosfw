  <?php if (isset($msg)){ ?>
  <script>
    showNotif(<?php echo "'".$msgType."'"; ?>, <?php echo "'".$msg."'"; ?>);
  </script>
  <?php } ?>