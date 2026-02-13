<?php


function main_readtime(): string
{

    $time_selected = $_GET['time'] ?? null;

    $articles = [];

    if ($time_selected) {
        $articles = get_articles_by_time($time_selected);
    }

    return join("\n", [
        html_head(get_menu()),
        html_readtimes_results($time_selected, $articles),
        html_foot()
    ]);

}

