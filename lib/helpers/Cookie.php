<?php

namespace lib\helpers;

class Cookie
{

    public static function set($name, $value, $time = false) {
        $time = ($time) ? $time : 3600;
        setcookie ($name, $value, time() + $time, "/", $_SERVER['HTTP_HOST']);
    }

    public static function get($name) {
        if(isset($_COOKIE[$name])){
            return $_COOKIE[$name];
        }
        else {
            return false;
        }
    }

}