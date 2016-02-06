<?php

namespace config;

/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 05.02.2016
 * Time: 12:21
 */
class Config
{

    public $db = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'db' => 'wp',
        'charset' => 'utf8',
    ];

    public static $use_wp = true;

    public static $wp = [
        'type' => 'theme', // может быть plugin
        'name' => 'test'
    ];

}