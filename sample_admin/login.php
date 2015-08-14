<?php
require('../load.php');

if(!isset($_POST['entrar'])){
  
  $data = array('user' => '');
  $error = array();
  
} else {
  
  $response = Admin::login($_POST);
  if($response['success']){
    redirect('admin.php');
  } else {
    $data = $response['data'];
    $data['msg'] = $response['msg'];
  }
  
}

$tpl = new Layout();
echo $tpl->mobiLayout($tpl->loadTemplate('login', $data));
