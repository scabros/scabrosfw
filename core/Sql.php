<?php

class Sql {
  static $conn = null;
  
  static function fetch($stmt){
    $res = mysqli_query(self::$conn, $stmt) or self::error('DATA_SELECT|'.mysqli_error(self::$conn));
    /* $data = mysqli_fetch_all($res, MYSQLI_ASSOC); */
    $data = array();
    while ($d = mysqli_fetch_assoc($res)){
      $data[] = $d;
    }
    return $data;
  }
  
  static function esc($data){
    return mysqli_real_escape_string(self::$conn, $data);
  }
  
  static function insert($stmt){
    $res = mysqli_query(self::$conn, $stmt) or self::error('DATA_INSERT|'.mysqli_error(self::$conn));
    return self::lastId();
  }

  static function update($stmt){
    mysqli_query(self::$conn, $stmt) or self::error('DATA_UPDATE|'.mysqli_error(self::$conn));
    return self::affectedRows();
  }

  static function delete($stmt){
    mysqli_query(self::$conn, $stmt) or self::error('DATA_DELETE|'.mysqli_error(self::$conn));
  }

  static function exec($stmt){
    //Logger::log($stmt);
    return mysqli_query(self::$conn, $stmt) or self::error('DATA_EXEC|'.mysqli_error(self::$conn));
  }
  
  static function lastId(){
    return mysqli_insert_id(self::$conn);
  }
  
  static function affectedRows(){
    return mysqli_affected_rows(self::$conn);
  }

  static function numRows($rs){
    return mysqli_num_rows($rs);
  }

  static function beginTransac(){
    mysqli_query(self::$conn, 'BEGIN') or self::error('BEGIN|'.mysqli_error(self::$conn));
  }
    
  static function commitTransac(){
    mysqli_query(self::$conn, 'COMMIT') or self::error('COMMIT|'.mysqli_error(self::$conn));
  }

  static function rollBack(){
    mysqli_query(self::$conn, 'ROLLBACK') or self::error('ROLLBACK|'.mysqli_error(self::$conn));
  }

  static function error($errstr){
    if(substr($errstr, 0, 5) == 'DATA_'){
      self::rollBack();
    }
    trigger_error($errstr);
  }
  
}
