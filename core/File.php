<?php

class File {

  private static $supported_filetypes = array('image/jpeg', 'image/png');
  private static $MAX_FILE_SIZE = 1500000;

  private static function name($dir, $pref, $parts){
    $n = tempnam($dir, $pref).'.'.(isset($parts['extension'])?$parts['extension']:'');
    return str_replace($dir, '', $n);
  }

  private static function validate($img, $fname){
    $msg = array();
    
    // You should also check filesize here.
    if ($img['size'] > self::$MAX_FILE_SIZE) {
      $msg[] = 'Exceeded file size limit.';
    }

    // Check MIME Type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $img['tmp_name']);
    if (!in_array($mime_type, self::$supported_filetypes)){
      $msg[] = 'Invalid file format.';
    }

    // Check if file already exists
    if (file_exists($fname)) {
        $msg[] = "Sorry, file already exists.";
    }
    
    if(count($msg) > 0){
      return M::cr(false, array(), implode('<br/>', $msg));
    } else {
      return M::cr(true);
    }
  }

  public static function up2Web($img){
    $msg = array();

    $fname = self::name(DATAROOT, 'up_', pathinfo($img['name']));

    $valid = self::validate($img, $fname);
    
    if(!$valid->success){
      return M::cr(false, array(), $valid->msg);
    }

    // final move
    if (!move_uploaded_file($img['tmp_name'], DATAROOT.$fname)){
        $msg[] = 'Failed to move uploaded file '.$img['tmp_name'].' to '.$fname;
    }

    // Check if $uploadOk is set to 0 by an error
    if (count($msg) > 0) {
      return M::cr(false, array(), implode(',', $msg));
    } else {
      return M::cr(true, array($fname));
    }
  }

  public static function unlinkWeb($img){
    unlink(DATAROOT.$img);
  }
}
