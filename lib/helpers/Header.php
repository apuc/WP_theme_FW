<?php
namespace lib\helpers;


class Header
{
    public static function redirect($location, $replace, $http_response_code=301){
        header( "Location: $location", $replace, $http_response_code );
    }

}