<?php

function main_home():string
{
    // model
    $ordre = 'recent' ?? DEFAULT_ORDER;
    $limit = 10 ?? DEFAULT_LIMIT;
    $menu_a = get_menu();
    $all_articles = get_press_list($ordre , $limit);
    $lead = get_lead_article($all_articles);
    $features = get_feature_article( $all_articles);
    $sidebar = get_sidebar_article( $all_articles,$limit);
    // view
	return join( "\n", [
		html_head($menu_a),
		html_home($lead, $features, $sidebar),
		html_foot(),
	]);

}

