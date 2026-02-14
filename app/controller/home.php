<?php

function main_home():string
{

    if (isset($_GET['action']) && $_GET['action'] == 'toggle_display') {
        $_SESSION['show_main_articles'] = !($_SESSION['show_main_articles'] ?? true);
        header('Location: index.php');
        exit();
    }

    $show_articles = $_SESSION['show_main_articles'] ?? true;

    $ordre = 'recent' ?? DEFAULT_ORDER;
    $limit = 10 ?? DEFAULT_LIMIT;
    $category = "on n'est pas des pigeons";
    $menu_a = get_menu();
    $all_articles = get_sql($category,$ordre,$limit);
    $lead = get_lead_article($all_articles);
    $features = get_feature_article( $all_articles);
    $sidebar = get_sidebar_article( $all_articles,$limit);
	return join( "\n", [
		html_head($menu_a),
		html_home($lead, $features, $sidebar,$show_articles),
		html_foot(),
	]);

}

