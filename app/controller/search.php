<?php

function main_search():string
{

    $keyword = $_GET['keyword'] ?? "";
    $author  = $_POST['author']  ?? "";
    $limit   = $_GET['limit']   ?? 10;

    $results = search($keyword , $limit);

    var_dump($keyword);
    var_dump($results);


	return join( "\n", [
		html_head(get_menu()),
		html_search_form(),
        html_press_list_titles($results),
		html_foot(),
	]);

}

