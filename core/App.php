<?php
/**
 * Hook to call a method any time we call inaccesible
 * methods in object or static context
 * http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.methods
 */

class App {

  public function __call($name, $arguments){
    Utils::log("Calling object method '$name' ". implode(', ', $arguments));
    // check custom access rules
    self::checkPermissions(__CLASS__, $name);
    $this->$name($arguments);
  }

  /**  As of PHP 5.3.0  */
  public static function __callStatic($name, $arguments){
    Utils::log("Calling static method '$name' ". implode(', ', $arguments));
    // check custom access rules
    self::checkPermissions(__CLASS__, $name);
    __CLASS__::$name($arguments);
  }

  private static function checkPermissions($class, $method){
    checkSystemPermissions($class, $method);
  }
}
