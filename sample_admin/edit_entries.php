<?php
require('../load.php');
require('../init.php');

if(isset($_POST)){

  $tpl = new Layout();
  
  if(!isset($_POST['accion'])){

    $response = Entries::get($_POST['id']);
    $data = $response['data'][0];
    echo $tpl->mobiLayout($tpl->loadTemplate('edit_entries', $data));
    
  } else {
  
    $response = Entries::edit($_POST);
    
    if($response['success']){
      
      setNotification('success', $response['msg']);
      redirect('entries.php');
      
    } else {
      
      $data = $response['data'];
      $data['error'] = $response['msg'];
      echo $tpl->mobiLayout($tpl->loadTemplate('edit_entries', $data));
    }
  }
  
}else{
  
  redirect('entries.php');
  
}
