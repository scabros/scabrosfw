<?php

class PDOSql {
  
  public static $pdobj = null;

  public static function select($stmt, $bind=array(), $where=''){
    $stmt = self::parseWhere($stmt, $where);

    $s = self::$pdobj->prepare($stmt);
    $s->setFetchMode(PDO::FETCH_ASSOC);
    $s->execute($bind) or self::error('SELECT');

    while($d = $s->fetch()) {
      $data[] = $d;
    }

    return $data;
  }
  
  public static function insert($stmt, $bind=array()){
    $s = self::$pdobj->prepare($stmt);
    $s->execute($bind) or self::error('DATA_INSERT');
    return self::lastId();
  }

  public static function update($stmt, $bind, $where=''){
    $stmt = self::parseWhere($stmt, $where);

    $s = self::$pdobj->prepare($stmt);
    $s->execute($bind) or self::error('DATA_UPDATE');
    return self::affectedRows();
  }

  public static function delete($stmt, $bind, $where=''){
     $stmt = self::parseWhere($stmt, $where);

    $s = self::$pdobj->prepare($stmt);
    $s->execute($bind) or self::error('DATA_DELETE');
    return self::affectedRows();
  }

  public static function exec($stmt){
    $s = self::$pdobj->prepare($stmt);
    return $s->execute() or self::error('DATA_EXEC');
  }
  
  private static function lastId(){
    return self::$pdobj->lastInsertId();
  }
  
  private static function affectedRows(){
    return self::$pdobj->rowCount();
  }
  
  private static function parseWhere($stmt, $where){
    if(!empty($where)){
      $where = ' WHERE '.implode(' AND ', $where);
    }

    return str_replace('{%WHERE%}', $where, $stmt);
  }

  public static function esc($data){
    return self::$pdobj->quote($data);
  }

  public static function beginTransac(){
    self::$pdobj->beginTransaction() or self::error('BEGIN');
  }
    
  public static function commitTransac(){
    self::$pdobj->commit() or self::error('COMMIT');
  }

  private static function rollBack(){
    self::$pdobj->rollBack() or self::error('ROLLBACK');
  }

  private static function error($errstr){
    if(substr($errstr, 0, 5) == 'DATA_'){
      self::rollBack();
    }
    trigger_error($errstr.'|'.print_r(self::$pdobj->errorInfo()));
  }
}
