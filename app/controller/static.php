<?php

function main_static()
{
    $static_name = $_GET['subpage'] ;
    $page_data = get_static_contents($static_name);
    if ($page_data) {
        $title = $page_data['title_static'];
        $content = $page_data['content_static'];
    } else {
        $title = "404";
        $content = "Page non trouvée.";
    }

    return join( "\n", [
        html_head(get_menu()),
        $title,
        $content,
        html_foot(),
    ]);

}

