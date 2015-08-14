<?php

class Notifications {

  static function send($pj, $msg){
    $pj = Characters::get($pj);
    if(!$pj['success']){
      return array('success' => false, 'msg' => $pj['msg']);
    } else {
      $pj = $pj['data'];
    }
    
    Sql::$conn = connectDB();

    $iduser = Sql::esc($pj['iduser']);
    $msg = Sql::esc(str_replace('{%NAME%}', $pj['name'], $msg));

    return Sql::insert("INSERT INTO notifications (iduser, msg, status) VALUES ('$iduser', '$msg', '0')");
  }

  static function getAll(){
    Sql::$conn = connectDB();

    $iduser = Sql::esc($_SESSION['userID']);
    $res = Sql::fetch("SELECT * FROM notifications WHERE iduser = '$iduser' ORDER BY sent_date DESC");
    return array(
      'success' => true,
      'data' => $res,
      'msg' => ''
    );
  }

  static function markAsRead($id){
    Sql::$conn = connectDB();

    $id = Sql::esc($id);
    $iduser = Sql::esc($_SESSION['userID']);

    $res = Sql::fetch("UPDATE notifications set status = '1', view_date = NOW() WHERE id = '$id' AND iduser = '$iduser'");
    return array(
      'success' => true,
      'data' => $res,
      'msg' => ''
    );
  }

  static function deleteOld(){
    Sql::$conn = connectDB();

    $id = Sql::esc($id);
    $iduser = Sql::esc($_SESSION['userID']);

    $res = Sql::delete("DELETE from notifications WHERE  status = '1' AND view_date < NOW() - INTERVAL 1 month");
    return array(
      'success' => true,
      'data' => $res,
      'msg' => ''
    );
  }
}
