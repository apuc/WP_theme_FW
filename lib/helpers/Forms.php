<?php

namespace lib\helpers;

class Forms
{

    public static function dropDownList($name, $selected, $data, $options = false){
        $d = '';
        if($options['prompt']){
            $d .= "<option>".$options['prompt']."</option>";
        }
        foreach($data as $k => $v){

            if($k == $selected && $selected != 0){
                $d .= "<option selected value='$k'>$v</option>";
            }
            else {
                $d .= "<option value='$k'>$v</option>";
            }
        }
        unset ($options['prompt']);
        $op = '';
        if($options){
            foreach($options as $k => $v){
                $op .= "$k = '$v' ";
            }
        }

        return "<select name='$name' $op>$d</select>";
    }

}