<?php

function checkLogin(){
	if(isset($_SESSION['userID']) && $_SESSION['userID'] != '' &&
    isset($_SESSION['userNAME']) && $_SESSION['userNAME'] != ''){
      return true;
  } else {
    $_SESSION['goto'] = $_SERVER['REQUEST_URI'];
    if(!strpos($_SERVER['REQUEST_URI'], 'login.php')){
      redirect('login.php');
    }
    return false;
  }
}
