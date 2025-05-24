<?php

class Route {

    public static function __callStatic($name, $arguments) {
        if(strtoupper($name) != strtoupper($_SERVER['REQUEST_METHOD'])) return;

        $url = $arguments[0];
        if($url != $_SERVER['REQUEST_URI']) return;

        list($class, $method) = $arguments[1]; 
        $controller = new $class();
        $controller->$method();
    }
}