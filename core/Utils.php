<?php

class Utils {
	
  static function sendResetPassword($data){

    // generar hash
    //$resetHash = generateResetHash();
    $resetHash = chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)). chr(rand(65,90)). chr(rand(65,90)). chr(rand(65,90));

    $p = array(
      'email' => array('required' => true, 'type' => 'email', 'label' => 'Email', 'maxLength' => 50)
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

    PDOSql::$pdobj = pdoConnect();

    $email = Sql::esc($data['email']);
    
    $u = Sql::fetch("SELECT id, email, user from usuarios where email ='".$email. "'");
    
    if(count($u) == 1){

      $type  = 'USER';
      $email = $u[0]['email'];
      $id    = $u[0]['id'];
      $user  = $u[0]['user'];

      // guardar hash en la tabla correspondiente
      $u = Sql::update("UPDATE usuarios set resetHash = '".$resetHash."' where id ='".$id. "'");

    } else {

      $c = Sql::fetch("SELECT id, user, email from clientes where email ='".$email. "'");

      if(count($c) == 1){

		  	$type  = 'CLIENT';
		   	$email = $c[0]['email'];
		   	$id    = $c[0]['id'];
		   	$user  = $c[0]['user'];

				// guardar hash en la tabla correspondiente
		   	$u = Sql::update("UPDATE clientes set resetHash = '".$resetHash."' where id ='".$id. "'");

		    } else {
		      return array(
		        'success' => false,
		        'data' => array('email' => $email),
		        'msg' => 'No se encuentra el email en nuestra base de datos'
		        );
		    }
    }

		// envial email con el hash en el body
		$from = "info@todosmispuntos.com";
		$subject = "Reseteo de contrase&ntilde;a - TMP";
		$body = "Hola, 
		\r\nEstas recibiendo este email porque se ha generado un pedido de reseteo de contraseña en el sistema de TodosMisPuntos.
		\r\nSi estas intentando resetear la contraseña de tu cuenta de TodosMisPuntos, haz click en (o copia y pega) el siguiente enlace:\r\n
		\r\n".URL."/pw-reset-landing.php?t=".substr($type, 0, 1)."&q=".$email."&h=".$resetHash."\r\n
		\r\nPor las dudas, te recordamos que tu nombre de usuario es: ".$user.".\r\n
		\r\nSi no deseas resetear tu contraseña simplemente ignora este email.\r\n
		\r\n--
		\r\nEl equipo de TodosMisPuntos.";
		
		$headers = "From: $from" . "\r\n";

		mail($email, $subject, $body, $headers);

		return array(
        'success' => true,
        'data' => array(),
        'msg' => 'Se ha enviado el link de reseteo a la cuenta solicitada'
      );
	}

	static function resetPassword($data){
		PDOSql::$pdobj = pdoConnect();
		$hash = Sql::esc($data['h']);
		$type = Sql::esc($data['t']);
		$email = Sql::esc($data['q']);
		$pass1 = Sql::esc($data['pass1']);
		$pass2 = Sql::esc($data['pass2']);
		
		if($pass1 !== $pass2){
			return array(
				'success' => false,
				'data' => '',
				'msg' => 'Las contraseñas no coinciden'
			);
		}

		if($type == 'C'){
			$get_hash = "SELECT id, email, resetHash from clientes where email ='".$email. "' AND resetHash = '".$hash."'";
			$delete_hash = "UPDATE clientes set password = MD5('".$pass1."'), resetHash = null where email ='".$email."' AND resetHash = '".$hash."'";
		} elseif($type == 'U') {
			$get_hash = "SELECT id, email, resetHash from usuarios where email ='".$email. "' AND resetHash = '".$hash."'";
			$delete_hash = "UPDATE usuarios set password = MD5('".$pass1."'), resetHash = null where email ='".$email. "' AND resetHash = '".$hash."'";
		} else {
			return array(
				'success' => false,
				'data' => '',
				'msg' => 'Problema con el reseteo'
			);
		}

		$h = Sql::fetch($get_hash);

		if(count($h) == 1){
			$u = Sql::update($delete_hash);
			return array(
				'success' => true,
				'data' => array('id' => $h[0]['id']),
				'msg' => 'Se realizo la operacion con exito.'
			);
		} else {
			return array(
				'success' => false,
				'data' => '',
				'msg' => 'Codigo invalido'
			);
		}
	}

	static function sendWelcomeMail($data){

		$subject = "Bienvenido";
		$name    = $data['nombre'];
		$email   = $data['email'];
		$from    = "info@todosmispuntos.com";
		
		if(isset($data['sexo']) && $data['sexo'] == 'm'){
	  		$subject = "Bienvenida";
	    	}
	  
	  	$subject .=' a Todos mis puntos!';
		$body = file_get_contents(WEBROOT.'bienvenida.txt');
		$body = str_replace('%name%', $name, $body);
	  
		$headers = "From: $from" . "\r\n";

		mail($email, $subject, $body, $headers);
	}
}
