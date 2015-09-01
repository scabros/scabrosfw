<?php
/**
 * Hook to call a method any time we call inaccesible
 * methods in object or static context
 * http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.methods
 */

class App {

  public function __call($name, $arguments){
    // Note: value of $name is case sensitive.
    echo "Calling object method '$name' "
     . implode(', ', $arguments). "\n";
  }

  /**  As of PHP 5.3.0  */
  public static function __callStatic($name, $arguments){
    self::checkPermissions(__CLASS__, $name);
    // Note: value of $name is case sensitive.
    echo "Calling static method '$name' "
    . implode(', ', $arguments). "\n";
  }

  private static function checkPermissions($class, $method){
    checkSystemPermissions($class, $method);
  }
}
