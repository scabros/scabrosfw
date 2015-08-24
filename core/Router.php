<?php

class Router {

    public static function dispatch($routes){
        if(isset($_SERVER['PATH_INFO'])){
            $uri = $_SERVER['PATH_INFO'];
        } elseif(isset($_SERVER['REQUEST_URI'])){
            $uri = $_SERVER['REQUEST_URI'];

            if(strpos($uri, $_SERVER['SCRIPT_NAME']) === 0){
                $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));
            } elseif(strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0){
                $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
            }

            // This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
            // URI is found, and also fixes the QUERY_STRING server var and $_GET array.
            if(strncmp($uri, '?/', 2) === 0){
                $uri = substr($uri, 2);
            }

            $parts = preg_split('#\?#i', $uri, 2);
            $uri = $parts[0];

            if(isset($parts[1])){
                $_SERVER['QUERY_STRING'] = $parts[1];
                parse_str($_SERVER['QUERY_STRING'], $_GET);
            } else {
                $_SERVER['QUERY_STRING'] = '';
                $_GET = array();
            }
            $uri = parse_url($uri, PHP_URL_PATH);
        } else {
            $uri = false;
        }

       
        $uri = ltrim($uri, '/');
       
        //return $uri;
        if(count($routes) > 0){
            foreach($routes as $route){
                if(preg_match($route[0], $uri, $matches)){
                    // discard first 
                    array_shift($matches);
                    // load all matches in the corresponding GET keys...
                    foreach ($matches as $key => $value) {
                        $_GET[$route[2][$key]] = $value;
                    }
                    // all setted up, now require the micro-controller...
                    require($route[1]);
                } else {
                    trigger_error('PAGE_NOT_FOUND|Maybe wrong parameters?');
                }
            }
        } else {
            trigger_error('PAGE_NOT_FOUND|Empty routes?');
        }
    }
}
