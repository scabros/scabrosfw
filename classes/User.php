<?php

class User {
  
  static function login($data){
    
    $p = array(
      'user' => array('required' => true, 'type' => 'string', 'label' => 'Usuario', 'maxLength' => 30)
    );

    $v = new Validator();
    $response = $v->validate($data, $p);
    
    if(!$response['success']){
      return M::cr(false, $data, $response['msg']);
    }

    PDOSql::$pdobj = pdoConnect();

    $params = array($data['user'], $data['pass']);
    $u = PDOSql::select("SELECT id, adm from users where adm = ? AND pass = MD5(?) AND active = 1", $params);
    
    if(count($u) == 1){
      $_SESSION['userID']   = $u[0]['id'];
      $_SESSION['userNAME'] = $u[0]['adm'];
      
      return M::cr(true);

    } else {
      
      return M::cr(false, array('user' => $data['user']), 'Usuario o contraseña invalida');
      
    }
  }

  static function getData($id){
    PDOSql::$pdobj = pdoConnect();
    
    $d = PDOSql::select("SELECT name, bg_image, subtitle FROM users WHERE id = ?", array($id));

    if(count($d) > 0){
    
      $data['name']     = $d[0]['name'];
      $data['bg_image'] = $d[0]['bg_image'];
      $data['subtitle'] = $d[0]['subtitle'];
      
      return M::cr(true, $data);

    } else {

      return M::cr(false, array('user' => array() ), 'No se encontraron datos del usuario');
      
    }
  }
}
