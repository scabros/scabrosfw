<?php
 
class Tpl {
   private static $baseDir = '.';
   private static $tplExt  = '.php';

   public static function loadTemplate($template, $vars = array(), $baseDir=null){
    if($baseDir == null){
      $baseDir = self::$baseDir;
    }
     
    $templatePath = $baseDir.'/'.$template.''.self::$tplExt;

    if(!file_exists($templatePath)){
      throw new Exception('Could not include template '.$templatePath);
    }

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
