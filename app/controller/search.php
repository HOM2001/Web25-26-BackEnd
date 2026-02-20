<?php

function main_search():string {

    $reporters = get_reporter() ?? [];
    $max_articles = get_top_reporter()?? 100;
    if (!empty($max_articles)) {
        $max_val = $max_articles[0]['nb_articles'];
    } else {
        $max_val = 100;
    }
    $results = [];
    if (!empty($_POST)) {
        $keyword = $_POST['keyword'] ?? '';
        $author = $_POST['author'] ?? '';
        $limit = $_POST['limit'] ?? 10;
        $results = search($author, $keyword, $limit);
    }


    return join("\n", [
       ctrl_head(),
        html_search_form($reporters, $max_val),
        html_result_search($results),
        html_foot()
    ]);
}