<?php
require('../load.php');
require('../init.php');

$response = Admin::getData($_SESSION['adminID']);
$data = $response['data'];
$tpl = new Layout();

echo $tpl->mobiLayout($tpl->loadTemplate('admin', $data));
