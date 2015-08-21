<?php

class M {

  public static function create($s, $d = array(), $m = null){
    
    if (is_bool($s) === false) {
      trigger_error('M class incorrect success property type. must be boolean');
    }
    if (is_array($d) === false) {
      trigger_error('M class incorrect data property type. must be array');
    }
    if (!is_null($m) && is_string($m) === false) {
      trigger_error('M class incorrect msg property type. must be string');
    }

    // empty object
    $scm = new StdClass;

    $scm->success = $s;
    $scm->data    = $d;
    $scm->msg     = $m;

    return $scm;
  }
}

//$m = M::create(true, array('data'), 'message');
//var_dump($m);
//$m = M::create(true, array('data2'));
//var_dump($m);
