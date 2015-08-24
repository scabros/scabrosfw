<?php

/**
 *
 * @author Orkhan Z. Maharramli (orkhan.maharramli@gmail.com)
 *
 */

class Router
{
    public $path;
    public $config;
    public $routes = array();
   
    private static $instance;
   
    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
   
    public function __construct()
    {
        $this->config = Config::getInstance();
        $this->routes = $this->_getRoutes();
        $this->path = $this->_getPath();
        header("HTTP/1.0 404 Not Found");
        return;
    }
   
    public function __destruct()
    {
        $this->routes = array();
        $this->config = null;
        $this->path = null;
    }
   
    public function __get($name)
    {
        return $this->{$name};
    }
   
    /**
     *
     * Get routes from XML
     *
     * @return array Router Configs
     *
     */
    protected function _getRoutes()
    {
        if(count($this->config->routes->route) > 0)
        {
            foreach($this->config->routes->route as $routes)
            {
                $routes_array[(string)$routes->attributes()->pattern] = (string)$routes->attributes()->route;
            }
        }
        else
        {
            $routes_array = array();
        }
       
        return $routes_array;
    }
   
    /**
     *
     * Get path from $_SERVER
     *
     * @return string URL
     *
     */
    public static function _getPath()
    {
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
       
        return $uri;
        if(count($this->routes) > 0){
            foreach($this->routes as $pattern => $route){
                if(preg_match("~$pattern~", $uri)){
                    $uri = preg_replace("~$pattern~", $route, $uri);
                    $uri = str_replace(array('//', '../'), '/', trim($uri, '/'));
                    $uri = explode('/', $uri);
                }
            }
        } else {
            $uri = str_replace(array('//', '../'), '/', trim($uri, '/'));
            $uri = explode('/', $uri);
        }
       
        return $uri;
    }
} 
