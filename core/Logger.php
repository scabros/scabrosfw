<?php

class Logger {

  static function log($msg){
    file_put_contents(SYSTEM_LOG_FILE, "LOGGER at ".date("Y-m-d H:i:s").":".$msg."\n", 8);
  }
}
