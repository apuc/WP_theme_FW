<?php

namespace lib;


class App
{
    public $crud;
    public $routing;
    public $parser;
    public $include_file;



    public function __construct(){
        $this->parser = new Parser();
        $this->crud = new CRUD();
        $this->routing = new Routing();
        $this->include_file = new Include_file();
    }


    public function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}