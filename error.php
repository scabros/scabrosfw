<?php
require('load.php');

$tpl = new Layout();
$data = array();
if(isset($_SESSION['sys_err'])){
  if(ENV == 'DEVEL'){
    $data['error'] = $_SESSION['sys_err'];
    unset($_SESSION['sys_err']);
  }
}
echo $tpl->loadTemplate('error', $data);
