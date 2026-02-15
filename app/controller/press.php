<?php

function main_press()
{
    $order = DEFAULT_ORDER;
    $limit = get_article_count() ?? DEFAULT_LIMIT;
    $menu_a = get_menu();
    $press_a = get_press_list($order,$limit);

    return join( "\n", [
        html_head($menu_a),
        html_press_list_titles($press_a),
        html_foot(),
    ]);

}