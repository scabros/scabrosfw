<?php
require('load.php');

$entry = Entries::get($_GET['id']);

if(!$entry->success){

  setNotification('error', $entry->msg);
  redirect('index.php');

}

$tpl = new Layout();
echo $tpl->entriesLayout($tpl->loadTemplate('post', array('post' => $entry->data)));
