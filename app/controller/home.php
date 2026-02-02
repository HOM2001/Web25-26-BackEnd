<?php

function main_home():string
{
    // model
    $menu_a = get_menu();
    $lead = get_lead_article();
    $features = get_feature_article();
    $sidebar = get_sidebar_article();
    // view
	return join( "\n", [
		html_head($menu_a),
		html_home($lead, $features, $sidebar),
		html_foot(),
	]);

}

