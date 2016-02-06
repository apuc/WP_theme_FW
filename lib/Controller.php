<?php

namespace lib;

class Controller
{

    public $app;
    public $title;

    public function __construct(){
        $app = new App();
        $this->app = $app;
        $this->app->parser->controller = $this->className();
        $this->app->parser->app = $this->app;
    }

    public function className(){
        return get_class($this);
    }

}