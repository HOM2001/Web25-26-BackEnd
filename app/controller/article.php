<?php

function main_article():string
{
    // model
    // http://4ipw3-aww/?page=article&ident_art=4
    // $_GET["ident_art"]  => 4
    $id = $_GET["ident_art"] ?? $_GET["id"] ?? 0;
    $article_a = get_press_article($id);

    // view
	return join( "\n", [
		ctrl_head(),
		html_press_article($article_a),
		html_foot(),
	]);

}

