<ul>
  <?php if(isset($_SESSION['userID']) && !empty($_SESSION['userID'])){ ?>
  <li>
    <a href="user.php">Mis datos</a> 
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
