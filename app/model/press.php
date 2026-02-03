<?php

/**
 * requête avec les titres des articles
 * @return array
 */
function get_press_list( $order = DEFAULT_ORDER, $limit = DEFAULT_LIMIT)
{
    switch(DATABASE_TYPE) {
        case "json":
            $content_s = file_get_contents('../asset/database/article.json');
            $content_a = json_decode($content_s, true);


            return array_slice($content_a, 0, $limit);

        case "MySql":

            return get_sql($order, $limit);

        default:
            return [];
    }

}

function get_press_article($ident)
{
    if (DATABASE_TYPE === "json") {
        // Range JSON : 1001 à 1020
        if ($ident < 1001 || $ident > 1020) {
            return ["error" => "L'ID $ident est invalide pour le format JSON. Le range possible est [1001 - 1020]."];
        }

        $content_s = file_get_contents('../asset/database/article.json');
        $all_articles = json_decode($content_s, true);

        foreach ($all_articles as $art) {
            if ($art['id'] == $ident) {
                return $art;
            }
        }
    } else {
        // Range MySQL : 0 à 2924
        if ($ident < 0 || $ident > 2924) {
            return ["error" => "L'ID $ident est invalide pour MySQL. Le range possible est [0 - 2924]."];
        }

        $q = "SELECT * FROM `t_article` WHERE `ident_art` = :ident_art";
        $res = db_select_prepare($q, ['ident_art' => $ident]);

        if (empty($res)) {
            return ["error" => "L'article n°$ident n'existe pas dans la base de données (ID supprimé ou manquant)."];
        }

        return $res[0];
    }

    return ["error" => "Article introuvable."];
}
function get_sql($order = DEFAULT_ORDER, $limit = DEFAULT_LIMIT)
{
    $p = [];


    // 2. Logique de tri
    switch ($order) {
        case 'random':
            $orderBy = "ORDER BY RAND()";
            break;
        case 'first': // Les tout premiers créés (ID 0, 1, 2...)
            $orderBy = "ORDER BY ident_art ASC";
            break;
        case 'last':  // Les tout derniers créés (ID 2924, 2923...)
            $orderBy = "ORDER BY ident_art DESC";
            break;
        case 'old':   // Les plus anciens par date
            $orderBy = "ORDER BY date_art ASC";
            break;
        case 'recent':
        default:      // Les plus récents par date
            $orderBy = "ORDER BY date_art DESC";
            break;
    }

    $q = <<< SQL
        SELECT 
            title_art AS title,
            ident_art,
            hook_art AS hook
        FROM `t_article` 
        $orderBy
        LIMIT $limit;
SQL;

    return (!empty($p)) ? db_select_prepare($q, $p) : db_select($q);
}
function get_lead_article(){
    return get_press_article(1);
}
function get_feature_article()
{
    foreach ([2,3,4] as $art_a) {
        $art_aa [] = get_press_article($art_a);
    }
    return $art_aa;
}
function get_sidebar_article()
{
    foreach (range(5,DEFAULT_LIMIT) as $art_a) {
        $art_aa [] = get_press_article($art_a);
    }
    return $art_aa;
}

