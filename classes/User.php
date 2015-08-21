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

    Sql::$conn = connectDB();
    $user = Sql::esc($data['user']);
    $pass = Sql::esc($data['pass']);

    $u = Sql::fetch("SELECT id, adm from users where adm ='".$user. "' AND pass = MD5('".$pass."') AND active = 1");
    
    if(count($u) == 1){
      $_SESSION['userID']   = $u[0]['id'];
      $_SESSION['userNAME'] = $u[0]['adm'];
      
      return M::cr(true);
    } else {
      
      return M::cr(false, array('user' => $data['user']), 'Usuario o contraseña invalida');
      
    }
  }

  static function getData($id){
    Sql::$conn = connectDB();
    $query = "SELECT name, bg_image, subtitle FROM users WHERE id = '".Sql::esc($id). "'";
    
    $d = Sql::fetch($query);
    if(count($d) > 0){
    
      $data['name']     = $d[0]['name'];
      $data['bg_image'] = $d[0]['bg_image'];
      $data['subtitle'] = $d[0]['subtitle'];
      
      return array(
        'success' => true,
        'data' => $data
        );

    } else {
    
    return array(
      'success' => false,
      'data' => array('user' => array() ),
      'msg' => 'No se encontraron datos del usuario'
      );
    
    }
  }
}
