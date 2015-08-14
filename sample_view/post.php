<?php
require('../load.php');

$response = Entries::get($_GET['id']);

$tpl = new Layout();
$data = array();

if($response['success'] == true){
  $data['entries'] = $response['data'];
} else {
  $data['msg'] = $response['msg'];
}


echo $tpl->entriesLayout($tpl->loadTemplate('post', $data));
