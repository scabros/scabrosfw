<?php

function checkLogin(){
  if(isset($_SESSION['adminID']) && $_SESSION['adminID'] != '' &&
    isset($_SESSION['adminNAME']) && $_SESSION['adminNAME'] != ''){
      return true;
  }
	if(isset($_SESSION['userID']) && $_SESSION['userID'] != '' &&
    isset($_SESSION['userNAME']) && $_SESSION['userNAME'] != ''){
      return true;
  }
   else {
    $_SESSION['goto'] = $_SERVER['REQUEST_URI'];
    if(!strpos($_SERVER['REQUEST_URI'], 'login.php')){
      redirect('login.php');
    }
    return false;
  }
}

function getHash(){
	//if(isset($_SESSION['pedidoHash']))
	//  return $_SESSION['pedidoHash'];
	
	$pedidoHash = $_SESSION['local']."-".$_SESSION['mesa']."-".time()."-".$_SERVER['REMOTE_ADDR'];
	return $pedidoHash;
}

