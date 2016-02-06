<?php

namespace lib;

/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 05.02.2016
 * Time: 11:59
 */
class Widget
{
    public $app;

    public function __construct(){
        $app = new App();
        $this->app = $app;
        $this->app->parser->widget = $this->className();
    }

    public function className(){
        return get_class($this);
    }

    public static function classNameStatic(){
        return get_called_class();
    }

    public static function run($arr = []){
        $class = self::classNameStatic();
        $widget = new $class();
        foreach($arr as $k => $v){
            $widget->$k = $v;
        }
        return $widget->start();

    }

    public function start(){
        return '';
    }

}