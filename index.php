<?php
require('load.php');

$entries = Entries::getAll();

$tpl = new Layout();
echo $tpl->blogLayout($tpl->loadTemplate('index', array('posts' => $entries->data)));
