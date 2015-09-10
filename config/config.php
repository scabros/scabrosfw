<?php
require_once('enviroment.php');

if(ENV === 'LINUX'){
  define('URL', 'http://localscabros/');
  define('SYSROOT', '/home/beto/git/scabrosfw/');
  define('DOMAIN', 'http://localscabros/');
  define('DBHOST', 'localhost');
  define('DBUSER', 'root');
  define('DBPASS', '123456');
  define('DBNAME', 'test');
  define('TMP', '/tmp');
}

if(ENV === 'XAMPP'){
  define('URL', 'http://localhost/xampp/scabrosfw/');
  define('SYSROOT', 'C:\xampp\htdocs\xampp\scabrosfw\\');
  define('DOMAIN', 'http://localhost/');
  define('DBHOST', 'localhost');
  define('DBUSER', 'root');
  define('DBPASS', '');
  define('DBNAME', 'test');
  define('TMP', 'C:\Windows\TEMP\\');
}

define('COREROOT', SYSROOT.'core/');

// upload dirs... in filesystem and web...
define('DATAROOT', SYSROOT.'data\\');
define('UPLOADS', URL.'data/');

define('TITLE', 'ScabrosFW');

define('SYSTEM_LOG_FILE', SYSROOT.'file.log');
define('TRANSLATIONS_FILE', SYSROOT.'translations.json');

define('DEBUG', 'DEVEL');

