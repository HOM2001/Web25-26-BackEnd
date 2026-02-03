<?php

function main_press()
{
    $menu_a = get_menu();
    $press_a = get_press_list(DEFAULT_ORDER,DEFAULT_LIMIT);

    return join( "\n", [
        html_head($menu_a),
        html_press_list_titles($press_a),
        html_foot(),
    ]);

}