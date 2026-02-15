<?php

function main_search():string {

    $reporters = get_reporter() ?? [];
    $menu = get_menu();
    $results = [];
    if (!empty($_POST)) {
        $keyword = $_POST['keyword'] ?? '';
        $author = $_POST['author'] ?? '';
        $limit = $_POST['limit'] ?? 10;
        $results = search($author, $keyword, $limit);
    }


    return join("\n", [
        html_head($menu),
        html_search_form($reporters),
        html_result_search($results),
        html_foot()
    ]);
}