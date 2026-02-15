<?php

function main_search():string {

    $reporters = get_reporter() ?? [];

    $results = [];
    if (!empty($_POST)) {
        $keyword = $_POST['keyword'] ?? '';
        $author = $_POST['author'] ?? '';
        $limit = $_POST['limit'] ?? 10;
        $results = search($author, $keyword, $limit);
    }


    return join("\n", [
       ctrl_head(),
        html_search_form($reporters),
        html_result_search($results),
        html_foot()
    ]);
}