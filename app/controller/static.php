<?php

function main_static()
{
    $static_name = $_GET['subpage'] ;
    $page_data = get_static_contents($static_name);
    if ($page_data) {
        $title = '';
        $content = $page_data['content_static'];
    } else {
        $title = "404";
        $content = "Page non trouvée.";
    }

    return join( "\n", [
        ctrl_head(),
        $title,
        $content,
        html_foot(),
    ]);

}

