<?php
require_once('core/Router.php');

$routes = array(
  array("#view/posts/([0-9]+)#i", 'post.php', array('id')),
);

$path = Router::dispatch($routes);


/*if(preg_match('#view/posts/([0-9]+)$#i', $path, $matches)){
  $_GET['id'] = $matches[1];
  require('post.php');
}*/
