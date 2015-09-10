#ScabrosFW - PHP micro-framework

## Features:

These are the main features present in the framework by now...

- native PHP templates support
- supports translations
- class autoloading
- error detection and handling
- simple to learn application organization
- simple SQL abstraction layer
- simple data validation
- simple response messages convention
- decoupled components

## The Idea:

The main ideas behind this frawmework are:

- evade fat MVC frameworks, with complex routing, slow models, etc.
- simplify to allow rapid development, focused on what should be done

So, we have no "Models". We have no "Controllers". We encourage the developer 
to organize his work in a collection of _micro-controllers_ to manage the 
application *FLOW* and a collection of classes to solve the application *LOGIC*.
The "templating" is handled with three simple classes: Layout for screen 
organization and layout; Tpl to parse native php templates with custom data;
and T to simplify some tedious tasks (check/show vars and translate tpl *DATA*).

## By Example:

So, if you want a login page, you create a "micro-controller" in the desired
folder, anywhere. This login page should check if there is any data submitted
and then call the login METHOD of the corresponding class. In THAT login METHOD
you can validate the data, connect to database, escape the data, execute the 
appropiate SQL statement, check the returned data, and finally, if everything
is OK, return a Response with the success flag on it. In this case you could 
also write a "$_SESSION" var, to initialize the user session. In the case of an
error, in the data validation step or in any other, the login METHOD should 
return a Response with the success flag property set to FALSE. The msg property
of the response should contain info about the failure (messages about data 
validation, user not found, etc). Then, back in the micro-controller, the 
developer must decide how to handle the action response. If it was successfull,
maybe can redirect to a new page with the standard redirect function. If it had
an error, maybe he should re-populate the form with the data (or not) and show 
the error msg with the appropiate function.
As you see, the flow of the application is in total control of the developer,
but he is encouraged to follow some key concepts.

### login.php "micro-controller":
```
<?php
require('../load.php');

if(!isset($_POST['entrar'])){
  
  $data = array('user' => '');
  $error = array();
  
} else {
  
  $response = User::login($_POST);
  if($response->success){
    redirect('user.php');
  } else {
    $data = $response->data;
    $data['msg'] = $response->msg;
  }
  
}

$tpl = new Layout();
echo $tpl->mobiLayout($tpl->loadTemplate('login', $data));
```

### Admin class, login static method:

```
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
```

## Low Level classes:

We have two key classes that act at the most "deep" level of the frawmework. 
These are the M and T classes. 

- T class is for managing the template variables. Basically showing vars and 
translating them.
- M class is the core messaging of the frawmework. it has only one static method 
that returns an StdClass Object with three properties: succes, data and msg. All 
classes should return one of this to leave the developer know the status of the 
performed action.

## Showing notifications

When you perform any action, you can use the msg attribute of the M response object 
to show a notification in the screen. This notification is implemented via a Jquery
plugin "NotifyIt", and the php function setNotification in core.php. In all the
Layouts should be included a call to getNotification that triggers the notification.
An example of use is when you create a new record succesfully, maybe you want to 
redirect to the listing directly. Then you could use this notification system to show
the user the result of the action.

## Routing:

This is not something i like but any modern FW must include this feature.
So i implemented it in a very _homemade_ way... The webserver should check
the existence of any requested resource (an url) and if it does not exists,
it should "redirect" (or in this case, include) a matching micro-controller.
We define the special class *Router* and and special php file in the root of 
the framework folder route.php that contains the regular expressions to match
against the URI. it must include the micro-controller to be included and an 
array of the custom URI segments that should be passed as $_GET vars...

### In apache:
You should use the .htaccess file with some minor modifications to make it match
your current setup.

```
# If requested resource exists as a file or directory, skip next two rules
RewriteEngine On
RewriteCond %{DOCUMENT_ROOT}/$1 -f [OR]
RewriteCond %{DOCUMENT_ROOT}/$1 -d
# Else rewrite requests for non-existent resources to /index.php
RewriteRule (.*) /route.php?q=$1 [L]
```

### In nginx:
The same logic applies here, but it is applied in the server config snippet. 
in this case the magic is in the _try_files_ expression.

```
server {
  root /some/folder/scabrosfw;
  server_name scabrostest;
  index index.php;

  location / {
    try_files $uri $uri/ /route.php?$args;
  }

  location ~ \.php$ {
    gzip  on;
    gzip_min_length  1000;
    gzip_proxied     expired no-cache no-store private auth;
    gzip_types       text/plain application/xml;
    gzip_disable     "MSIE [1-6]\.";

    fastcgi_pass 127.0.0.1:9000;
    fastcgi_intercept_errors on;
    fastcgi_index index.php;
    include fastcgi_params;
  }
}

```

## Conventions:
- All of your custom classes should be in the classes folder of the framework
- All your micro-controllers should load the framework requiring the file 
"load.php" in the first line
- All your templates should be in a directory called "tpls" in the same folder
of the micro-controller, or, if it's a common tpl used widely in the app, it
should be in the tpls directory in the system root.
- all the code you want to run in some pages, but not all (like session 
validation), should be in another file named "init.php"
- All of your custom classes should return an object response with succes, msg
and data properties
- All your third party libs should be in lib/ folder

## Third Party Software

Currently the framework includes some other work or projects:

- NotifyIt
- TinyMCE
- ... 

## Future additions
- Routing class
- PhpMailer for emails
- SQL with prepared statements
- File uploading class with validation
- Some kind of permission management
- Composer integration?

## Final Words

This is a work in progress, any advice or help is welcome. I dont believe i am 
a genius, this CAN have problems so check it out.
I am concious that using static functions inside classes is a "bad practice". 
We can discuss for a while about complexity/normalization vs simplicity/sloppiness.
I think we should try to respect and follow what is called "good practices". But i 
also believe that we should search some techniques that make our work easier. That's 
the reason behind some "regretable" decisions i made. Just to name a few i am aware of:

- PDOSql is a static class because i dont have Models. So any script might need
direct database access. But, i left the connection logic outside to explicitly force
the developer to do it manually (also enabling the possibility to connect to another BD)
-trigger_error use: i dont use exceptions because a generic error page and good 
logging seems enough for me. 