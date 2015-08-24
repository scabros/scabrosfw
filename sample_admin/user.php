<?php
require('../load.php');
require('../init.php');

$response = User::getData($_SESSION['userID']);
$data = $response->data;//var_dump($data);die();
$tpl = new Layout();

echo $tpl->mobiLayout($tpl->loadTemplate('user', $data));
