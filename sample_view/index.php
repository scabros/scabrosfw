<?php
require('../load.php');

$response = Entries::getAll('beto');
$tpl = new Layout();
$data = array();

if($response['success'] == true){
  $data['entries'] = $response['data'];
} else {
  $data['msg'] = $response['msg'];
}


echo $tpl->entriesLayout($tpl->loadTemplate('index', $data));
