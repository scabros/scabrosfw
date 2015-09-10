<?php

class V {
  
  private static $vars = array();
  private static $trans = array();

  public static function set($vars){
    self::$vars = $vars;
  }

  public static function loadtrans($trans){
    self::$trans = $trans;
  }

  public static function show($varname){
    echo self::get($varname);
  }

  public static function get($varname){
    if(isset(self::$vars[$varname])){
      return self::$vars[$varname];
    } else {
      return '';
    }
  }

  public static function tr8n($str, $lang){
    if(isset(self::$trans[$lang][$str])){
      return self::$trans[$lang][$str];
    } else {
      return $str;
    }
  }

  public static function isAllowed($obj, $action){
    return false;
  }
}
