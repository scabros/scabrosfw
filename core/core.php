<?php

function redirect($location){
  header('Location: '.$location);
  die();
}

function connectDB(){
  $link = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Error ".mysqli_error($link));
  return $link;
}

function pdoConnect(){
  try {
    // connect to the database
    $DBH = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
    $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
  } catch(PDOException $e) {
    trigger_error('PDOERROR|'.$e->getMessage());
  }
  return $DBH;
}

function sys_error($errno, $errstr, $errfile, $errline){
  
  // limpiamos el error de la sesion
  unset($_SESSION['sys_err']);
  
  // chequeamos errores
  if (!($errno & error_reporting())) return;

  // detectamos el tipo de error
  $rType = (strpos($_SERVER['PHP_SELF'], 'ajx_') === false) ? 'GUI' : 'AJAX';
  
  if($errno != E_CORE_ERROR){
    
    // obtener backtrace
    $data = debug_backtrace();

    // incializar log
    $debug_log = "########\nError [$errno] en el archivo: $errfile (linea $errline) \n$errstr\n";

    // armar debug compacto
    foreach ($data as $bt) {

      if(isset($bt['file']))
        $debug_log .= $bt['file'];

      if(isset($bt['line']))
        $debug_log .= " @ ".$bt['line'];

      if(isset($bt['function']))
        $debug_log .= " -> ".$bt['function'];

      if(isset($bt['args']) && is_array($bt['args']))
        $debug_log .= "(".print_r($bt['args'], true).")\n";

    }

  } else {
    
    $debug_log = "########\nError [$errno] en el archivo: $errfile (linea $errline) $errstr \n";
    
  }

  // log to file
  file_put_contents(SYSTEM_LOG_FILE, $debug_log, 8);

  // redirect based on error type & ENV
  if($rType === 'GUI'){
    
    if( ENV == 'DEVEL'){
      $_SESSION['sys_err'] = $debug_log;
    }
    
    redirect(URL.'error.php');
    
  } elseif( $rType == 'AJAX') {
    die("{'success': false, 'msg': 'Hubo un error al procesar el pedido'}");
  } else {
    die('UNKNOWN REQUEST ERROR');
  }
  //die('Houston, tenemos este error: ('.$errno.') '.$errstr.'<pre>'.print_r($data, true).'</pre>');
} 


function fatal_handler() {
  $errfile = "unknown file";
  $errstr  = "shutdown";
  $errno   = E_CORE_ERROR;
  $errline = 0;

  $error = error_get_last();
  //var_dump($error);die();

  if( $error !== NULL) {
    $errno   = $error["type"];
    $errfile = $error["file"];
    $errline = $error["line"];
    $errstr  = $error["message"];
    sys_error($errno, $errstr, $errfile, $errline);
  }
}

function setNotification($type, $msg){
  $_SESSION['sessMSG'] = array('msg' => $msg, 'type' => $type);
}

function getNotification(){
  if(isset($_SESSION['sessMSG'])){
    $tpl = new Layout();
    $data = array(
      'msgType' => $_SESSION['sessMSG']['type'],
      'msg' => $_SESSION['sessMSG']['msg']
      );
    echo $tpl->loadTemplate('notif', $data);
    unset($_SESSION['sessMSG']);
  }
}

function showMsg($msg){
  return '<div id="error"><p>'.$msg.'</p></div>';
}

function showVar($name){
  if(isset(Tpl::$vars[$name])){
    echo Tpl::$vars[$name];
  } else {
    echo '';
  }
}

function in_array_r($needle, $haystack, $strict = false) {
  foreach ($haystack as $item) {
    if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
      return true;
    }
  }
  return false;
}

if (!function_exists('array_column')) {

    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();

        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }

        if (!is_array($params[0])) {
            trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
            return null;
        }

        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;

        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }

        $resultArray = array();

        foreach ($paramsInput as $row) {

            $key = $value = null;
            $keySet = $valueSet = false;

            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }

            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }

            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }

        }

        return $resultArray;
    }

}

function autoloader($className) {
  $filename = COREROOT . $className . ".php";
  if (is_readable($filename)) {
    require $filename;
  } elseif(defined('SYSROOT')){
    $filename = SYSROOT .'classes/'. $className . ".php";
    if (is_readable($filename)) {
      require $filename;
    }
  } else {
    trigger_error('CLASSES: Class Not Found ('.$filename.')');
  }
}

// autoloader classes
spl_autoload_register("autoloader");

// manejo custom de errores
set_error_handler('sys_error'); // common errors
register_shutdown_function( "fatal_handler" ); // fatal errors
