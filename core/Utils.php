<?php

class Utils {

  static function log($msg){
    file_put_contents(SYSTEM_LOG_FILE, "[".date("Y-m-d H:i:s")."] - ".$msg."\n", 8);
  }

}
