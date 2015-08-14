<?php
require('../load.php');
require('../init.php');

if(!isset($_POST['enviar'])){
  $data = array();
  $error = array();
} else {
  $response = Entries::newEntry($_POST);
  if($response['success']){
  	setNotification('success', $response['msg']);
    redirect('entries.php');
  } else {
    $data = $response['data'];
    $data['msg'] = $response['msg'];
  }
  
}

$tpl = new Layout();
echo $tpl->mobiLayout($tpl->loadTemplate('new_entry', $data));
