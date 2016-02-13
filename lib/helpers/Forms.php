<?php

namespace lib\helpers;

class Forms
{
    /**
     * ������ �����
     * @param bool|false $options array �����
     * @param $method string �����
     * @param $action string �����
     * @return string
     */
    public static function begin($options = false, $method = 'POST', $action = ''){
        $op = self::getOptions($options);
        return "<form action='$action' method='$method' $op>";
    }

    /**
     * ����� �����
     * @return string
     */
    public static function end(){
        return "</form>";
    }

    /**
     * ���������� ������
     * @param $name string
     * @param $selected integer
     * @param $data array
     * @param bool|false $options array
     * @return string
     */

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
        $op = self::getOptions($options);
        /*if($options){
            foreach($options as $k => $v){
                $op .= "$k = '$v' ";
            }
        }*/

        return "<select name='$name' $op>$d</select>";
    }

    /**
     * @param $type string
     * @param $name string
     * @param string $value
     * @param bool|false $options array
     * @return string
     */
    public static function input($type, $name, $value = '',$options = false){
        $op = self::getOptions($options);
        return "<input type='$type' name='$name' value='$value' $op>";
    }

    /**
     * @param $name
     * @param string $value
     * @param bool|false $options array
     * @return string
     */
    public static function inputHidden($name, $value = '', $options = false){
        $op = self::getOptions($options);
        return "<input type='hidden' name='$name' value='$value' $op>";
    }

    /**
     * @param $name
     * @param string $value
     * @param bool|false $options false
     * @return string
     */
    public static function inputText($name, $value = '', $options = false){
        $op = self::getOptions($options);
        return "<input type='text' name='$name' value='$value' $op>";
    }

    /**
     * @param $name
     * @param bool|integer|array $value
     * @param $data
     * @param bool|array $options
     * @return string
     */
    public static function checkboxList($name, $value = false, $data, $options = false){
        $op = self::getOptions($options);
        $html = '';
        //in_array()
        foreach ($data as $key => $val) {
            $ch = (in_array($key, $value)) ?  'checked' : '';
            $html .= "<input name='".$name."[]' $ch type='checkbox' value='$key' $op>$val";
        }
        return $html;

    }

    /**
     * @param $name string
     * @param string $value
     * @param bool|false $options array
     * @return string
     */
    public static function textarea($name,$value = '', $options = false){
        $op = self::getOptions($options);
        return "<textarea name='$name' $op>$value</textarea>";
    }

    public static function label($value, $for, $options = false){
        $op = self::getOptions($options);
        return "<label for='$for' $op>$value</label>";
    }

    /**
     * @param $options array
     * @return string
     */
    public static function getOptions($options){
        $op = '';
        if($options){
            foreach ($options as $key => $value) {
                $op .= "$key = '$value'";
            }
        }
        return $op;
    }

}