<?php
function get_panier(){
    $articles_complets = [];

    if (!empty($_SESSION['panier'])) {

        if (DATABASE_TYPE === "MySql") {

            $ids_string = implode(',', array_map('intval', $_SESSION['panier']));
            $sql = "SELECT ident_art, title_art, readtime_art, image_art FROM t_article WHERE ident_art IN ($ids_string)";
            $articles_complets = db_select($sql);

        } elseif (DATABASE_TYPE === "json") {

            $content_s = file_get_contents('../asset/database/article.json');
            $all_articles = json_decode($content_s, true);


            $articles_complets = array_filter($all_articles, function($item) {
                return in_array($item['id'], $_SESSION['panier']);
            });


            $articles_complets = array_values($articles_complets);
        }
    }
    return $articles_complets;
}