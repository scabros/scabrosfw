<?php

class Pdo {
  static $pdobj = null;
  
  static function fetch($stmt, $params = null){
    # STH means "Statement Handle"
    $STH = self::$pdobj->prepare($stmt);
    $STH->setFetchMode(PDO::FETCH_ASSOC);
    $STH->execute($params) or self::error('DATA_SELECT|'.mysqli_error(self::$pdobj));;

    while($d = $STH->fetch()) {
      $data[] = $d;
    }

    return $data;
  }
  
  static function esc($data){
    return mysqli_real_escape_string(self::$pdobj, $data);
  }
  
  static function insert($stmt){
    $res = mysqli_query(self::$pdobj, $stmt) or self::error('DATA_INSERT|'.mysqli_error(self::$pdobj));
    return self::lastId();
  }

  static function update($stmt){
    mysqli_query(self::$pdobj, $stmt) or self::error('DATA_UPDATE|'.mysqli_error(self::$pdobj));
    return self::affectedRows();
  }

  static function delete($stmt){
    mysqli_query(self::$pdobj, $stmt) or self::error('DATA_DELETE|'.mysqli_error(self::$pdobj));
  }

  static function exec($stmt){
    //Logger::log($stmt);
    return mysqli_query(self::$pdobj, $stmt) or self::error('DATA_EXEC|'.mysqli_error(self::$pdobj));
  }
  
  static function lastId(){
    return mysqli_insert_id(self::$pdobj);
  }
  
  static function affectedRows(){
    return mysqli_affected_rows(self::$pdobj);
  }

  static function numRows($rs){
    return mysqli_num_rows($rs);
  }

  static function beginTransac(){
    mysqli_query(self::$pdobj, 'BEGIN') or self::error('BEGIN|'.mysqli_error(self::$pdobj));
  }
    
  static function commitTransac(){
    mysqli_query(self::$pdobj, 'COMMIT') or self::error('COMMIT|'.mysqli_error(self::$pdobj));
  }

  static function rollBack(){
    mysqli_query(self::$pdobj, 'ROLLBACK') or self::error('ROLLBACK|'.mysqli_error(self::$pdobj));
  }

  static function error($errstr){
    if(substr($errstr, 0, 5) == 'DATA_'){
      self::rollBack();
    }
    trigger_error($errstr);
  }
  
}
