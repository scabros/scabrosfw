<ul>
  <?php if(isset($_SESSION['adminID']) && !empty($_SESSION['adminID'])){ ?>
  <li>
    <a href="admin.php">Mis datos</a> 
  </li>
  <li>
    <a href="entries.php">Posteos</a> 
  </li>
  <li>
    <a href="logout.php">Salir</a> 
  </li>
  <?php } else { ?>
  <li>
    <a href="login.php">Entrar</a> 
  </li>
  <?php } ?>
</ul>
