<?php

function main_home():string
{

    if (isset($_GET['action']) && $_GET['action'] == 'toggle_display') {
        $_SESSION['show_main_articles'] = !($_SESSION['show_main_articles'] ?? true);
        header('Location: index.php');
        exit();
    }

    $show_articles = $_SESSION['show_main_articles'] ?? true;

    $order = 'recent' ?? DEFAULT_ORDER;
    $limit = 10 ?? DEFAULT_LIMIT;
    $category = "on n'est pas des pigeons";
    $all_articles = get_sql($category,$order,$limit);
    $lead = get_lead_article($all_articles);
    $features = get_feature_article( $all_articles);
    $sidebar = get_sidebar_article( $all_articles,$limit);
	return join( "\n", [
		ctrl_head(),
		html_home($lead, $features, $sidebar,$show_articles),
		html_foot(),
	]);

}
