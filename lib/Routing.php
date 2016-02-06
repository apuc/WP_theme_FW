<?php

namespace lib;

/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 01.02.2016
 * Time: 9:39
 */
class Routing
{

    public function start(){
        $classes = [];
        if ($handle = opendir(ROOT_DIR . DOP_DIR . '/controllers/')) {
            /* Именно этот способ чтения элементов каталога является правильным. */
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $classes[] = $file;
                    include (ROOT_DIR . DOP_DIR . "/controllers/" . $file);
                }
            }
            closedir($handle);
        }
        $url = explode('/', $_SERVER['REQUEST_URI']);

        /*Только для vk2*/
        $arr = [];
        foreach($url as $u){
            if($u != "vk2"){
                $arr[] = $u;
            }
        }
        $url = $arr;
        /*Только для vk2 (конец)*/

        $url2['controller'] = $url[1];
        $url2['action'] = $url[2];
        if(in_array(ucfirst($url2['controller']) . ".php", $classes)){
            return $url2;
        }
        else {
            return false;
        }
    }

    public function getUrl() {
        $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
        $url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
        $url .= $_SERVER["REQUEST_URI"];
        return $url;
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