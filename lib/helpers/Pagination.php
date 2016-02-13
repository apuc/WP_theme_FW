<?php
namespace lib\helpers;

class Pagination {
    public static function pag($kol,$num,$base_url,$current,$total)
    {
        if ($num < $kol ) {
            if ($current == '0') {
                $current = 1;
            }
            $end = ceil($kol / $num);
            if ($current != $end) {
                $next = '<li><a href = "'.$base_url.'/?page=' . ($current + 1) . '"> Далее</a></li>';
                $kon = ' <li><a href = "'.$base_url.'/?page=' . $end . '">В конец</a></li>';
            }

            if ($current != 1) {
                $back = '<li><a href = "'.$base_url.'?page=' . ($current - 1) . '">Назад </a></li>';
                $nach = '<li><a href = "'.$base_url.'?page=1">В начало</a> </li>';
            }


            if ($current - 2 > 0) $page2left = ' <li><a href= '.$base_url.'/?page=' . ($current - 2) . '>' . ($current - 2) . '</a> </li> ';
            if ($current - 1 > 0) $page1left = '<li><a href= '.$base_url.'/?page=' . ($current - 1) . '>' . ($current - 1) . '</a></li>  ';
            if ($current + 2 <= $total) $page2right = ' <li> <a href= '.$base_url.'/?page=' . ($current + 2) . '>' . ($current + 2) . '</a></li>';
            if ($current + 1 <= $total) $page1right = ' <li> <a href= '.$base_url.'/?page=' . ($current + 1) . '>' . ($current + 1) . '</a></li>';

            return "<ul class = 'pagination'>" . $nach . $back . $page2left . $page1left . '<li><a href="">' . $current . '</a></li>' . $page1right . $page2right . $next . $kon . "</ul>";
        }
    }
}