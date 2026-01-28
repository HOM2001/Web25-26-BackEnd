<?php

function main_favorite()
{
    // model
    $menu_a = get_menu();

    // view
    return join( "\n", [
        html_head($menu_a),
        html_foot(),
    ]);

}

