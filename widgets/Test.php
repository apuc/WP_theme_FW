<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 06.02.2016
 * Time: 13:26
 */

namespace widgets;


use lib\Widget;

class Test extends Widget
{

    public function start(){
        return $this->app->parser->renderW('test', [], false);
    }

}