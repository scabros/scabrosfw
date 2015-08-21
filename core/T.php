<?php

class T {
  
  private static $vars = array();
  private static $trans = array();

  public static function set($vars){
    self::$vars = $vars;
  }

  public static function sh($varname){
    if(isset(self::$vars[$varname])){
      return self::$vars[$varname];
    } else {
      return '';
    }
  }

  public static function tr($str, $lang){
    if(isset(self::$trans[$lang][$str])){
      return self::$trans[$lang][$str];
    } else {
      return $str;
    }
  }
}
