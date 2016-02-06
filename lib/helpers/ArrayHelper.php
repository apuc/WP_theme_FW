<?php

namespace lib\helpers;

class ArrayHelper
{
    public static function map($array, $key, $value){
        $result = [];
        foreach ($array as $ar) {
            $result[$ar[$key]] = $ar[$value];
        }
        return $result;
    }
}