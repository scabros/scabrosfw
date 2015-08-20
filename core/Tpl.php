<?php
 
class Tpl {
  private static $baseDir = '.';
  private static $tplExt  = '.php';

  private static function getPath($template){

    if(file_exists(getcwd().'/tpls/'.$template.'.php')){
      $dir = getcwd().'/tpls/';
    } elseif(file_exists(SYSROOT.'/tpls/'.$template.'.php')){
      $dir = SYSROOT.'/tpls/';
    } else {
      //die("TPL_NOT_FOUND|NO SE ENCUENTRA EL ARCHIVO ".$template." en ".getcwd().'/tpls/'.$template.'.php ni en '.SYSROOT.'/tpls/'.$template.'.php');
      trigger_error("TPL_NOT_FOUND|NO SE ENCUENTRA EL ARCHIVO ".$template." en ".getcwd().'/tpls/'.$template.'.php ni en '.SYSROOT.'/tpls/'.$template.'.php');
    }
    //die('aca llegamos barrrrbaro4'.$dir);
    return $dir;
  }

  public static function loadTemplate($template, $vars = array(), $baseDir=null){
    if($baseDir == null){
      $baseDir = self::getPath($template);
    }
     
    $templatePath = $baseDir.'/'.$template.''.self::$tplExt;

    return self::loadTemplateFile($templatePath, $vars);
  }

  private static function loadTemplateFile($_tpl_, $_vars_){
    try {

      // load vars in T
      require_once(COREROOT.'T.php');
      T::set($_vars_);

      // TODO: remove and work only with T?
      extract($_vars_, EXTR_OVERWRITE);

      // save output...
      $_ret_ = '';
      ob_start();
      require $_tpl_;
      $_ret_ = ob_get_contents();
      ob_end_clean();

      return $_ret_;
    } catch (Exception $e){
      trigger_error("TPL_PROBLEM|NO SE QUE ONDA...".$e->getMessage());
    }
  }
}
