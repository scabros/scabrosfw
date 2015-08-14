<?php
require('../load.php');

session_unset();
if(!session_destroy()){
  die("no se pudo cerrar la sesion ...");
}

header("Location: ".DOMAIN);
