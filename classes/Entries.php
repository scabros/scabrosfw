<?php 

class Entries {
  
  static function get($id = null){
    Sql::$conn = connectDB();

    $sql = "SELECT * FROM entries WHERE id = ".Sql::esc($id)." ORDER BY id DESC";
    $p = Sql::fetch($sql);
    
    if(count($p) == 0){

      return M::cr(false, array(), "No se encontro el post");

    } elseif(count($p) == 1) {

      return M::cr(true, $p[0]);

    } else {

      return M::cr(false, array(), 'Hubo un error con la consulta');

    }
  }
  
  static function getAll($author = null){
    Sql::$conn = connectDB();

    if(!empty($author)){
      $filter =  "WHERE author = '".Sql::esc($author)."'";
    } else {
      $filter = '';
    }
    
    $p = Sql::fetch("SELECT * FROM entries $filter ORDER BY date DESC");
    
    if(count($p) == 0){

      return M::cr(true, array(), "No se encontraron posteos");

    } elseif(count($p) > 0) {

      return M::cr(true, $p);

    } else {

      return M::cr(false, array(), 'Hubo un error con la consulta');

    }
  }
  
  static function newEntry($data){
    $p = array(
      'title'  => array('required' => true, 'type' => 'string', 'maxlength' => 140, 'label' => 'Titulo'),
      'text' => array('required' => true, 'type' => 'string', 'label' => 'Texto'),
      'image' => array('required' => false, 'type' => 'thumbnail', 'label' => 'Imagen'),
      'tags'  => array('required' => false, 'type' => 'string', 'label' => 'Tags')
    );
    
    $v = new Validator();
    $response = $v->validate($data, $p);
    
    if(!$response['success']){
      return M::cr(false, $data, $response['msg']);
    }

    Sql::$conn = connectDB();

    $title  = Sql::esc($data['title']);
    $author = Sql::esc($_SESSION['userNAME']);
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
      move_uploaded_file($_FILES['foto']['tmp_name'], WEBROOT."data/".$c);
    }
    
    return M::cr(true, array($c), 'Se ha creado el posteo');
  }
  
  public static function edit($data){
    
    $p = array(
      'title'  => array('required' => true, 'type' => 'string', 'maxlength' => 140, 'label' => 'Titulo'),
      'text' => array('required' => true, 'type' => 'string', 'label' => 'Texto'),
      'image' => array('required' => false, 'type' => 'thumbnail', 'label' => 'Imagen'),
      'tags'  => array('required' => false, 'type' => 'string', 'label' => 'Tags')
    );
    
    $v = new Validator();
    $response = $v->validate($data, $p);
    
    if(!$response['success']){
      return M::cr(false, $data, $response['msg']);
    }
    
    Sql::$conn = connectDB();
    
    if(!empty($_FILES['image']["tmp_name"])){
      $imgData = " image = '".Sql::esc($_FILES['image']['name'])."', ";
      move_uploaded_file($_FILES['image']["tmp_name"], WEBROOT.'data/'.$data['id']);
    } else {
      $imgData = "";
    }
    
    $id = $data['id'];
    
    $query = "UPDATE entries SET title = '".Sql::esc($data['title']). "', 
      author = '".Sql::esc($_SESSION['userNAME']). "', 
      text = '".Sql::esc($data['text']). "', 
      $imgData 
      tags = '".Sql::esc($data['tags']). "' 
      WHERE id = '$id'"; 
    Sql::update($query);
    
    return M::cr(true, array(), 'Se han actualizado los datos correctamente');
  }
}
