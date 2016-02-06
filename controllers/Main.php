<?php

use lib\Controller;

class Main extends Controller
{

    public function actionIndex($params){
        return "Ehf " . $params['test'];
    }

}