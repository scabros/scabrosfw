<?php 

class Entries extends App {
  
  public static function get($id = null){
    PDOSql::$pdobj = pdoConnect();

    $p = PDOSql::select("SELECT * FROM entries WHERE id = ? ORDER BY id DESC", array($id));
    
    if(count($p) == 0){

      return M::cr(false, array(), "No se encontro el post");

    } elseif(count($p) == 1) {

      return M::cr(true, $p[0]);

    } else {

      return M::cr(false, array(), 'Hubo un error con la consulta');

    }
  }
  
  static function getAll($author = null){
    PDOSql::$pdobj = pdoConnect();

    $sql = "SELECT * FROM entries {%WHERE%} ORDER BY date DESC";

    if(!empty($author)){
      $where = array('author = ?');
      $bind = array($author);
    } else {
      $where = '';
      $bind = array();
    }
    
    $p = PDOSql::select($sql, $bind, $where);
    
    if(count($p) == 0){

      return M::cr(true, array(), "No se encontraron posteos");

    } elseif(count($p) > 0) {

      return M::cr(true, $p);

    } else {

      return M::cr(false, array(), 'Hubo un error con la consulta');

    }
  }
  
  private static function create($data){
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

    PDOSql::$pdobj = pdoConnect();

    if(isset($_FILES['image']['name'])){
      $response = File::up2Web($_FILES['image']);
      if($response->success){
        $image = $response->data[0];
      } else {
        return M::cr(false, $data, $response->msg);
      }
    } else {
      $image = '';
    }

    $params = array($data['title'], $_SESSION['userNAME'], $data['text'], $image, $data['tags']);
    
    $i = "INSERT INTO entries (title, author, text, date, image, tags) VALUES (?, ?, ?, NOW(), ?, ?)";
    
    $c = PDOSql::insert($i, $params);
    
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
    
    PDOSql::$pdobj = pdoConnect();

    if(isset($_FILES['image']['name'])){
      $response = File::up2Web($_FILES['image']);
      if($response->success){
        // remove old image...
        if(isset($data['old_image'])){
          File::unlinkWeb($data['old_image']);
        }
        $image = $response->data[0];
      } else {
        return M::cr(false, $data, $response->msg);
      }
    } else {
      $image = '';
    }
    
    $params = array($data['title'], $data['text'], $image, $data['tags'], $data['id'], $_SESSION['userNAME']);
    $where = array(' id = ?', 'author = ?');
    
    $query = "UPDATE entries SET title = ?, text = ?, image = ?, tags = ? {%WHERE%}"; 
    PDOSql::update($query, $params, $where);
    
    return M::cr(true, array(), 'Se han actualizado los datos correctamente');
  }
}
