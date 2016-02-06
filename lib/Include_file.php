<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 06.02.2016
 * Time: 11:24
 */

namespace lib;


class Include_file
{
    public function addModels(){
        if ($handle = opendir(ROOT_DIR . DOP_DIR . '/models/')) {
            /* Именно этот способ чтения элементов каталога является правильным. */
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $classes[] = $file;
                    require_once (ROOT_DIR . DOP_DIR . "/models/" . $file);
                }
            }
            closedir($handle);
        }
    }

    public function addWidgets(){
        if ($handle = opendir(ROOT_DIR . DOP_DIR . '/widgets/')) {
            /* Именно этот способ чтения элементов каталога является правильным. */
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && $file != "views") {
                    $classes[] = $file;
                    require_once (ROOT_DIR . DOP_DIR . "/widgets/" . $file);
                }
            }
            closedir($handle);
        }
    }
}