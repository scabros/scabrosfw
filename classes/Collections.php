<?php

class Collections {

  static function races(){
    Sql::$conn = connectDB();
    $races = Sql::fetch("SELECT * from races ORDER BY id ASC");
    $r = array();
    foreach($races as $race){
        $r[] = $race['name'];
    }
    return $r;
  }

  static function attributes(){
    $r = array('energy', 'ST', 'DX', 'HP', 'KI', 'RE', 'RX',);
    return $r;
  }

  static function subcategorias($client){
    if(self::tieneCatCustom($client)){
      $cats = self::categoriasCustom($client);
      $c = array();
      foreach($cats['data'] as $cat){
        if($cat['activo'] == 1 && !in_array_r($cat['subcategoria'], $c)){
          $c[] = array('categoria' => $cat['categoria'], 'subcategoria' => $cat['subcategoria'] );
        }
      }
      return $c;
    } else {
      Sql::$conn = connectDB();
      $cats = Sql::fetch("SELECT categoria, subcategoria from cats ORDER BY id ASC");
      $c = array();
      foreach($cats as $cat){
        if(!in_array_r($cat['subcategoria'], $c)){
          $c[] = array('categoria' => $cat['categoria'], 'subcategoria' => $cat['subcategoria'] );
        }
      }
      return $c;
    }
  }

  static function subcategoriasOLD($categoria = ''){
    
    Sql::$conn = connectDB();
    
    $q = "SELECT id, clave, valor, padre from subcategorias ORDER BY id ASC";

    /*if ($categoria != ''){
      $q.= " WHERE padre = '".Sql::esc($categoria). "'";
    }    
    $q.=  " ORDER BY padre, id ASC";*/
    
    $s = Sql::fetch($q);
    
    return $s;
  }

  static function createCatTbl($clientID){

    $tbl_name = "custom_cats_".$clientID;
    $creaT = "CREATE TABLE $tbl_name AS SELECT * FROM cats";
    /*
    $create = "CREATE TABLE IF NOT EXISTS $tbl_name (
      id serial primary key,
      categoria varchar(50) not null,
      subcategoria varchar(50) unique not null,
      activo tinyint not null default 1)";
    */
    Sql::exec($creaT);
    $alter = "ALTER TABLE $tbl_name MODIFY id serial primary key";
    Sql::exec($alter);
    
  }
  
  static function categoriasCustom($clientID){
    if(self::tieneCatCustom($clientID)){
      $tbl_name = "custom_cats_".$clientID;
      $s = Sql::fetch("SELECT id, categoria, subcategoria, activo from $tbl_name ORDER BY id ASC");
      return array(
        'success' => true,
        'data' => $s
      );
    } else {
      return array(
        'success' => false,
        'data' => array(),
        'msg' => 'No tiene categor&iacute;as personalizadas'
      );
    }
  }

    static function categoriaCustom($clientID, $categoriaID){

      if(self::tieneCatCustom($clientID)){
        $tbl_name = "custom_cats_".$clientID;
        $s = Sql::fetch("SELECT id, categoria, subcategoria, activo from $tbl_name WHERE id = '$categoriaID'");
        return array(
          'success' => true,
          'data' => $s[0]
        );
      } else {
        return array(
          'success' => false,
          'data' => array(),
          'msg' => 'No tiene categor&iacute;as personalizadas'
        );
      }
  }

  static function tieneCatCustom($clientID){
    
    Sql::$conn = connectDB();
    $tbl_name = "custom_cats_".$clientID;

    //$s = Sql::numRows($res) > 0;
    $s = Sql::fetch("SELECT * FROM information_schema.tables WHERE TABLE_NAME = '$tbl_name'");
    
    if(count($s) > 0){
      $s = Sql::fetch("SELECT count(*) from $tbl_name");
      if($s > 0){
        return true;
      }
    }
    return false;
  }

  static function altaCategoria($data){
    
    if(!self::tieneCatCustom($_SESSION['clientID'])){
      self::createCatTbl($_SESSION['clientID']);
    }

    $tbl_name = "custom_cats_".$_SESSION['clientID'];

    Sql::$conn = connectDB();
    
    $categoria = Sql::esc($data['categoria']);
    $subcat = Sql::esc($data['subcategoria']);
    
    $i = Sql::insert("INSERT INTO $tbl_name (categoria, subcategoria) values ('".$categoria."', '".$subcat."')");
    
    if($i > 0){

      return array(
        'success' => true,
        'data' => array(),
        'msg' => 'Se cre&oacute; la categor&iacute;a personalizada'
      );

    }
  }

  static function editarCategoria($data){

    $tbl_name = "custom_cats_".$_SESSION['clientID'];

    Sql::$conn = connectDB();
    
    $categoria = Sql::esc($data['categoria']);
    $subcat = Sql::esc($data['subcategoria']);
    $id = Sql::esc($data['id']);
    $user = Sql::esc($_SESSION['clientID']);

    Sql::beginTransac();

    $q = "SELECT categoria, subcategoria FROM $tbl_name WHERE id = '".$id."'";
    $s = Sql::fetch($q);
    
    $oldname_cat = $s[0]['categoria'];
    $oldname_subcat = $s[0]['subcategoria'];

    Sql::update("UPDATE $tbl_name SET categoria = '".$categoria."', subcategoria = '".$subcat."' WHERE id = '".$id."'");
    
    Sql::update("UPDATE menu_platos SET categoria = '".$categoria."', subcategoria = '".$subcat."' WHERE categoria = '".$oldname_cat."' AND subcategoria = '".$oldname_subcat."' AND user = '".$user."'");

    Sql::commitTransac();

      return array(
        'success' => true,
        'data' => array(),
        'msg' => 'Se actualiz&oacute; la categor&iacute;a personalizada'
      );
  }

  static function habilitarCategoria($id){

    $tbl_name = "custom_cats_".$_SESSION['clientID'];

    Sql::$conn = connectDB();
    
    $id = Sql::esc($id);
    
    $u = Sql::update("UPDATE $tbl_name SET activo = 1 WHERE id = '".$id."'");
    
    if($u > 0){
      return array(
        'success' => true,
        'data' => array(),
        'msg' => 'Se habilit&oacute; la categor&iacute;a personalizada'
      );
    }
  }

    static function deshabilitarCategoria($id){

    $tbl_name = "custom_cats_".$_SESSION['clientID'];

    Sql::$conn = connectDB();
    
    $id = Sql::esc($id);
    
    $u = Sql::update("UPDATE $tbl_name SET activo = 0 WHERE id = '".$id."'");
    
    if($u > 0){
      return array(
        'success' => true,
        'data' => array(),
        'msg' => 'Se deshabilit&oacute; la categor&iacute;a personalizada'
      );
    }
  }

  static function borrarCategoria($id){

    $tbl_name = "custom_cats_".$_SESSION['clientID'];

    Sql::$conn = connectDB();
    
    $id = Sql::esc($id);
    
    Sql::exec("DELETE FROM $tbl_name WHERE id = '".$id."'");
    
    return array(
        'success' => true,
        'data' => array(),
        'msg' => 'Se borr&oacute; la categor&iacute;a personalizada'
      );
  }

  static function provincias(){

      Sql::$conn = connectDB();
      $provs = Sql::fetch("SELECT * from provincia ORDER BY provincia_nombre ASC");
      $p = array();
      foreach($provs as $prov){
          $p[] = array('id' => $prov['id'], 'nombre' => $prov['provincia_nombre']);
      }
      return $p;
  }

  static function getNombreProvincia($provincia){
    $s = Sql::fetch("SELECT provincia_nombre from provincia WHERE id = '".Sql::esc($provincia)."'");
    return $s[0]['provincia_nombre'];
  }

  static function localidades($provincia = null){

    Sql::$conn = connectDB();

    if(!empty($provincia)){
      $where = " WHERE provincia_id ='".Sql::esc($provincia)."'";
    } else {
      $where = '';
    }
    $locs = Sql::fetch("SELECT * from ciudad $where ORDER BY ciudad_nombre ASC");
    $l = array();
    foreach($locs as $loc){
      $l[] = array('id' => $loc['id'], 'nombre' => $loc['ciudad_nombre'], 'provincia_id' => $loc['provincia_id']);
    }
    return $l;
  }

  static function getNombreLocalidad($localidad){
    $s = Sql::fetch("SELECT ciudad_nombre from ciudad WHERE id = '".Sql::esc($localidad)."'");
    return $s[0]['ciudad_nombre'];
  }

  static function rubros(){
    Sql::$conn = connectDB();
    $rubs = Sql::fetch("SELECT rubro from rubros_generales ORDER BY id");
    $r = array();
    foreach($rubs as $rub){
      $r[] = array('rubro' => $rub['rubro']);
    }
    return $r;
  }

}
