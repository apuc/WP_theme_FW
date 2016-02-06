<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 06.02.2016
 * Time: 12:48
 */

namespace lib\helpers;

class WP
{

    public $controller;

    public static function addShortCode($name, $controller, $action){
        add_shortcode($name, function($atts) use($controller, $action){

            $params = shortcode_atts( array(
                'test' => 1
            ), $atts );

            $res = new $controller();
            return $res->$action($params);
        });
    }

}