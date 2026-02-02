<?php

/**
 * requête avec les titres des articles
 * @return array
 */
function get_press_list_titles($keyword='')
{
    $content_a = [];
    switch(DATABASE_TYPE) {
        case "json":
            $content_s = file_get_contents('../asset/database/article.json');
            $content_a = json_decode($content_s, true);
            break;

        case "MySql":
            if( ! empty($keyword))
            {
                // requête préparée, avec un mot-clé
                $q = <<< SQL
                SELECT 
                    title_art AS title,
                    ident_art
                FROM `t_article` 
                WHERE 
                    title_art LIKE :keyword
                ORDER BY `date_art` DESC
                LIMIT 10;
SQL;
                $p = [
                    'keyword'   => "%$keyword%",
                ];
                $content_a = db_select_prepare($q, $p);
                // var_dump($content_a);
            }
            else
            {
                // requête non préparée, pas de mot clé
                $q = <<< SQL
                SELECT 
                    title_art AS title,
                    ident_art
                FROM `t_article` 
                ORDER BY `date_art` DESC
                LIMIT 10;
SQL;
                $content_a = db_select($q);
            }
            break;
    };
    return $content_a;
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