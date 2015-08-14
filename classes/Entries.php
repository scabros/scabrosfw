<?php 

class Entries {
  
  static function get($id = null){
    Sql::$conn = connectDB();
    if(!empty($id)){
      $where = ' WHERE id = '.Sql::esc($id);
    } else {
      $where = '';
    }

    $p = Sql::fetch("SELECT * FROM entries $where ORDER BY id DESC");
    
    if(count($p) == 0){
      return array(
        'success' => true, 
        'data' => array(),
        'msg' => "No se encontraron posteos"
        );
    } elseif(count($p) > 0) {
      return array(
        'success' => true,
        'data' => $p,
        );
    } else {
      return array(
        'success' => false,
        'data' => array(),
        'msg' => 'Hubo un error con la consulta'
        );
    }
  }
  
  static function getAll($author){
    Sql::$conn = connectDB();
    $author = Sql::esc($author);
    
    $p = Sql::fetch("SELECT * FROM entries WHERE author = '$author' ORDER BY date DESC");
    
    if(count($p) == 0){
      return array(
        'success' => true, 
        'data' => array(),
        'msg' => "No se encontraron posteos"
        );
    } elseif(count($p) > 0) {
      return array(
        'success' => true,
        'data' => $p,
        );
    } else {
      return array(
        'success' => false,
        'data' => array(),
        'msg' => 'Hubo un error con la consulta'
        );
    }
  }
  
  static function newEntry($data){
    $p = array(
      'title'  => array('required' => true, 'type' => 'string', 'maxlength' => 140, 'label' => 'Titulo'),
      //'author' => array('required' => true, 'type' => 'string', 'label' => 'Autor'),
      'text' => array('required' => true, 'type' => 'string', 'label' => 'Texto'),
      'image' => array('required' => false, 'type' => 'thumbnail', 'label' => 'Imagen'),
      //'date'  => array('required' => true, 'type' => 'date', 'label' => 'Fecha'),
      'tags'  => array('required' => false, 'type' => 'string', 'label' => 'Tags')
    );
    
    $v = new Validator();
    $response = $v->validate($data, $p);
    
    if(!$response['success']){
      return array(
        'success' => false,
        'data' => $data,
        'msg' => $response['msg']
      );
    }

    Sql::$conn = connectDB();

    $title  = Sql::esc($data['title']);
    $author = Sql::esc($_SESSION['adminNAME']);
    $text   = Sql::esc($data['text']);
    $tags   = Sql::esc($data['tags']);
    
    if(isset($_FILES['foto']['name'])){
      $image = Sql::esc($_FILES['foto']['name']);
    } else {
      $image = '';
    }
    
    Sql::beginTransac();
    
    $i = "INSERT INTO entries (title, author, text, date, image, tags) VALUES 
      ('".$title."', '".$author."', '".$text."', NOW(), '".$image."', '".$tags."')";
    
    $c = Sql::insert($i);

    Sql::commitTransac();
    
    if(isset($_FILES['foto']['tmp_name'])){
      move_uploaded_file($_FILES['foto']['tmp_name'], WEBROOT.'data/'.$c);
    }
    
    return array(
      'success' => true,
      'data' => $c,
      'msg' => 'Se ha creado el posteo'
    );
  }
  
  public static function edit($data){
    
    $p = array(
      'title'  => array('required' => true, 'type' => 'string', 'maxlength' => 140, 'label' => 'Titulo'),
      //'author' => array('required' => true, 'type' => 'string', 'label' => 'Autor'),
      'text' => array('required' => true, 'type' => 'string', 'label' => 'Texto'),
      'image' => array('required' => false, 'type' => 'thumbnail', 'label' => 'Imagen'),
      //'date'  => array('required' => true, 'type' => 'date', 'label' => 'Fecha'),
      'tags'  => array('required' => false, 'type' => 'string', 'label' => 'Tags')
    );
    
    $v = new Validator();
    $response = $v->validate($data, $p);
    
    if(!$response['success']){
      return array(
        'success' => false,
        'data' => $data,
        'msg' => $response['msg']
      );
    }
    
    Sql::$conn = connectDB();
    
    if(!empty($_FILES['image']["tmp_name"])){
      $imgData = " image = '".Sql::esc($_FILES['image']['name'])."', ";
      move_uploaded_file($_FILES['image']["tmp_name"], WEBROOT.'data/'.$data['id']);
    } else {
      $imgData = "";
    }
    
    $id = $data['id'];
    
    $query = "UPDATE entries SET title = '".Sql::esc($data['title']). "', author = '".Sql::esc($_SESSION['adminNAME']). "', text = '".Sql::esc($data['text']). "', $imgData tags = '".Sql::esc($data['tags']). "' WHERE id = '$id'"; 
    Sql::update($query);
    
    return array(
      'success' => true,
      'data' => array(),
      'msg' => 'Se han actualizado los datos correctamente'
    );
  }
}
