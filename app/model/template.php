<?php

function get_menu()
{
    $menu_aa = [];

    if (MENU_TYPE == "csv") {
        $menu_s = file_get_contents('../asset/database/menu.csv');
        $menu_a = explode("\n", $menu_s);

        foreach ($menu_a as $menu_item_s) {
            $menu_aa[] = explode('|', $menu_item_s);
        }
    } else if (MENU_TYPE == "database") {
        $sql = "SELECT label_menu, url_name_menu FROM t_menu ORDER BY num_menu ASC";

        $menu_db = db_select($sql);

        if ($menu_db) {
            foreach ($menu_db as $item) {
                $menu_aa[] = [$item['label_menu'], $item['url_name_menu']];
            }
        }
    }
return $menu_aa;

}


function limit_words($text, $limit) {
    $words = explode(' ', $text);
    if (count($words) > $limit) {
        return implode(' ', array_slice($words, 0, $limit)) . '...';
    }
    return $text;
}

