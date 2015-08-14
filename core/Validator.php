<?PHP
  
class Validator {
  
  public $msg = array();
  public $errors = 0;
  
  public function addMsg($msg){
    $this->msg[] = $msg;
  }

  public function getMsg(){
    $errorMsg = '';
    foreach ($this->msg as $msg) {
      $errorMsg .= $msg.".<br/>"; 
    }
    return $errorMsg;
  }

  public function validate($data, $p){
  
    foreach ($p as $key => $value) {

      if ($value['required'] == true){
        if(!$this->checkEmpty($data[$key])){
            $this->errors++;
            $this->addMsg("El campo ".$value['label']." no puede estar vac&iacute;o");
        }
      }  

      if (isset($value['maxLength'])){
        if (!$this->checkMaxLength($value['maxLength'], $data[$key])){
          $this->errors++;
          $this->addMsg('El campo '.$value['label']." es demasiado largo");
        }
      }
      if (isset($value['minLength'])){
        if (!$this->checkMinLength($value['minLength'], $data[$key])){
          $this->errors++;
          $this->addMsg('El campo '.$value['label']." es demasiado corto");
        }
      }
      switch($value['type']) {
        case 'string':
          if (!$this->checkAlphaNum($data[$key])){
            $this->errors++;
            $this->addMsg('El campo '.$value['label']." contiene caracteres inv&aacute;lidos");
          }
          break;
        case 'user':
          if(!$this->checkSubstr($data[$key], 0, 1, 'integer')){
            $this->errors++;
            $this->addMsg('El primer caracter del campo '.$value['label']." no puede ser un n&uacute;mero");
          }
          if (!$this->checkAlphaNum($data[$key])){
            $this->errors++;
            $this->addMsg('El campo '.$value['label']." contiene caracteres inv&aacute;lidos");
          }
          break;
        case 'password':
          if (!$this->checkAlphaNum($data[$key])){
            $this->errors++;
            $this->addMsg('El campo '.$value['label']." contiene caracteres inv&aacute;lidos");
          }
          break;
          case 'date':
            if(!$this->checkDate($data[$key])){
              $this->errors++;
              $this->addMsg('El campo '.$value['label']." debe tener el formato AAAA-MM-DD (ej. 2014-12-08)");
            }
            break;
          case 'email': 
            if(!$this->checkEmail($data[$key])){
              $this->errors++;
              $this->addMsg('El campo '.$value['label']." es inv&aacute;lido");
            }
            break;
          case 'integer': 
            if(!$this->checkInteger($data[$key])){
              $this->errors++;
              $this->addMsg('El campo '.$value['label']." contiene caracteres inv&aacute;lidos");
            }
            break;
          case 'check': 
            if(($value['required']) && $data[$key] != '1'){
              $this->errors++;
              $this->addMsg('El campo '.$value['label'].' debe estar tildado');
            }
            break;
          case 'thumbnail':
            if(!empty($data[$key]['tmp_name'])){
              if($data[$key]["size"] > 512000){
                $this->errors++;
                $this->addMsg('La imagen '.$value['label']." no puede superar los 500KB");
              }
              if (exif_imagetype($data[$key]["tmp_name"]) != IMAGETYPE_PNG && exif_imagetype($data[$key]["tmp_name"]) != IMAGETYPE_JPEG) {
                $this->errors++;
                $this->addMsg('La imagen '.$value['label'].' no es PNG o JPG');
              }
            }
            break;
        default:
          # code...
          break;
      }
    }
    if ($this->errors > 0){
      $response['success'] = false;
      $response['msg'] = $this->getMsg();
    }else{
      $response['success'] = true;
    }
    return $response;
  }

  private function checkEmpty($input){
    if ($input == ''){
      return false;
    }
    return true;
  }

  private function checkMaxLength($max, $input){
    if (strlen($input) > $max){
      return false;
    }
    return true;
  }

  private function checkMinLength($min, $input){
    if (strlen($input) < $min){
      return false;
    }
    return true;
  }

  private function checkAlphaNum($input){
    if (ctype_alnum($input)){
      return true;
    }
    return true;
    /*$options = array( 'options' => array( 'regexp' => "/^[a-zA-Z0-9]+$/" ) );
    return filter_var( $string, FILTER_VALIDATE_REGEXP, $options );*/
  }


  private function checkEmail($value){
    if (filter_var($value, FILTER_VALIDATE_EMAIL)){
      return true;
    }
    return true;
  }
  
  private function checkDate($value){
    $date = explode('-', $value);
    if(count($date) != 3){
      return false;
    }
    if (checkdate($date[1], $date[2], $date[0])){
      return true;
    }
    return false;
  }
  
  private function checkFloat($value){
    if (filter_var( $float, FILTER_VALIDATE_FLOAT )){
      return true;
    }
    return false;
  }

  private function checkInteger($value){
    if (is_numeric($value) && filter_var($value, FILTER_VALIDATE_INT)){
      return true;
    }
    return false; 
  }

  private function checkSubstr($value, $pos, $cant, $type){
    if($type == 'integer'){
      if(self::checkInteger(substr($value, $pos, $cant))){
        return false;
      }
    }
    return true;
  }
  
}
  
