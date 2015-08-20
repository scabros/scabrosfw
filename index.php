<?php
require('load.php');

$tpl = new Layout();
echo $tpl->blogLayout($tpl->loadTemplate('index', array() ));
