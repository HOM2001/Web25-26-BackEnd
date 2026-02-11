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

            return get_sql('',$order, $limit);

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
function get_sql($category = null, $order = DEFAULT_ORDER, $limit = DEFAULT_LIMIT)
{
    $p = [];
    $where = "";

    if (!empty($category)) {
        $where = "WHERE c.name_cat LIKE :cat";
        $p['cat'] = "%" . $category . "%";
    }

    switch ($order) {
        case 'random': $orderBy = "ORDER BY RAND()"; break;
        case 'first':  $orderBy = "ORDER BY a.ident_art ASC"; break;
        case 'last':   $orderBy = "ORDER BY a.ident_art DESC"; break;
        case 'old':    $orderBy = "ORDER BY a.date_art ASC"; break;
        case 'recent':
        default:       $orderBy = "ORDER BY a.date_art DESC"; break;
    }

    $q = <<< SQL
        SELECT 
            a.title_art AS title_art,
            a.ident_art AS ident_art,
            a.hook_art AS hook,
            a.image_art AS image_art,
            c.name_cat AS name_cat
        FROM `t_article` a
        JOIN `t_category` c ON c.id_cat = a.fk_category_art
        $where
        $orderBy
        LIMIT $limit;
SQL;

    return (!empty($p)) ? db_select_prepare($q, $p) : db_select($q);
}

function get_lead_article($all_articles) {
    return $all_articles[0] ?? null;
}

//
function get_feature_article($all_articles) {
    return array_slice($all_articles, 1, 3);
}


function get_sidebar_article($all_articles,$limit) {
    return array_slice($all_articles, 4, $limit-4);
}



