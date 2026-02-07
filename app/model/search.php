<?php
/**
 * Recherche flexible : Mot-clé OU Auteur OU Les deux
 */
function search($keyword = '', $limit = 10)
{

    if (DATABASE_TYPE === "json") {
        $path = '../asset/database/article.json';
        if (!file_exists($path)) return [];

        $content_s = file_get_contents($path);
        $content_a = json_decode($content_s, true);

        if (!empty($keyword)) {
            $content_a = array_filter($content_a, function($article) use ($keyword) {

                return mb_stripos($article['contents'], $keyword) !== false;
            });
        }

        return array_slice(array_values($content_a), 0, $limit);
    }
    elseif (DATABASE_TYPE === "MySql") {
        $params = [];
        $where_clauses = [];

        if (!empty($keyword)) {
            $where_clauses[] = "content_art LIKE :keyword";
            $params['keyword'] = "%$keyword%";
        }

        $where_sql = !empty($where_clauses) ? "WHERE " . implode(" AND ", $where_clauses) : "";

        $q = <<< SQL
            SELECT 
                title_art ,
                ident_art,
                hook_art AS hook,
                image_art
            FROM `t_article`
            $where_sql
            ORDER BY date_art DESC
            LIMIT $limit
SQL;

        return db_select_prepare($q, $params);
    }
    else {

        return [];
    }
}
