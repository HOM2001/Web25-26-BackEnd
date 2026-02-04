<?php

function main_search():string
{

    $keyword = $_POST['keyword'] ?? "";
    $limit   = $_POST['limit']   ?? 10;

    $results = search($keyword , $limit);




	return join( "\n", [
		html_head(get_menu()),
		html_search_form(),
        html_result_search($results),
		html_foot(),
	]);

}

