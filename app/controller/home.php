<?php

function main_home():string
{
    // model
    $menu_a = get_menu();
    $article_a = get_press_article(236);

    // view
	return join( "\n", [
		html_head($menu_a),
		html_press_article($article_a),
		html_foot(),
	]);

}

