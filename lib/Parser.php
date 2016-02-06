<?php

namespace lib;

class Parser {

    public $layout = 'main';
    public $controller = 'site';
    public $widget = false;
    public $title;
    public $app;

    public function parse ($tpl, $data = array(), $view = false) {
        $file = file_get_contents($tpl); // Получаем шаблон

        foreach ($data as $key => $value) {
            $key = "{".$key."}";
            $file = preg_replace("/$key/", $value, $file);
        }

        if ($view == true) {
            echo $file;
        }
        elseif($view == false) {
            return $file;
        }
    }

    public function render($tpl, $data = array(), $view = true){
        if(!empty($data)){
            foreach($data as $k => $v){
                ${$k} = $v;
            }
        }
        $app = $this->app;
        ob_start();
        include(ROOT_DIR . DOP_DIR . "/views/" . mb_strtolower($this->controller) . "/" . $tpl . ".php");
        $a = ob_get_contents();
        ob_end_clean();
        if($view){
            echo $this->get_layout($a);
        }
        else {
            return $this->get_layout($a);
        }
    }

    public function get_layout($content){
        $title = $this->title;
        ob_start();
        include(ROOT_DIR . DOP_DIR . "/layout/" .mb_strtolower($this->layout) . ".php");
        $a = ob_get_contents();
        ob_end_clean();
        return $a;
    }

    public function renderW($tpl, $data = array(), $view = true){
        if(!empty($data)){
            foreach($data as $k => $v){
                ${$k} = $v;
            }
        }

        ob_start();
        include(ROOT_DIR . DOP_DIR . "/widgets/views/"  . $tpl . ".php");
        $a = ob_get_contents();
        ob_end_clean();
        if($view){
            echo $a;
        }
        else {
            return $a;
        }
    }

    public function renderCode($tpl, $data = array(), $view = true){
        if(!empty($data)){
            foreach($data as $k => $v){
                ${$k} = $v;
            }
        }
        $app = $this->app;
        ob_start();
        include(ROOT_DIR . DOP_DIR . "/views/" . mb_strtolower($this->controller) . "/" . $tpl . ".php");
        $a = ob_get_contents();
        ob_end_clean();
        if($view){
            echo $a;
        }
        else {
            return $a;
        }
    }

} 