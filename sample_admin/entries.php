<?php
require('../load.php');
require('../init.php');

$response = Entries::getAll($_SESSION['userNAME']);
$tpl = new Layout();
$data = array();

if($response->success == true){
	$data['entries'] = $response->data;
} else {
	$data['msg'] = $response->msg;
}


echo $tpl->mobiLayout($tpl->loadTemplate('entries', $data));
