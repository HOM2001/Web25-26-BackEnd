<?php
/**
 * Recherche flexible : Mot-clé OU Auteur OU Les deux
 */
function search($author='', $keyword = '', $limit = 10)
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
            $where_clauses[] = "a.content_art LIKE :keyword";
            $params['keyword'] = "%$keyword%";
        }
        if (!empty($author)) {
            $where_clauses[] = "r.name_rep LIKE :author";
            $params['author'] = "%$author%";
        }

        $where_sql = !empty($where_clauses) ? "WHERE " . implode(" AND ", $where_clauses) : "";

        $q = <<< SQL
            SELECT 
                a.title_art AS title_art,
                a.ident_art AS ident_art,
                a.hook_art AS hook,
                a.image_art AS image_art
            FROM t_article a
            JOIN t_reporter r ON r.id_rep = a.reporter_art
            $where_sql
            ORDER BY a.date_art DESC
            LIMIT $limit
SQL;

        return db_select_prepare($q, $params);
    }
    else {

        return [];
    }
}
function get_reporter(){
// On récupère les noms uniques pour éviter les doublons dans la liste
    $q = "SELECT DISTINCT name_rep FROM t_reporter ORDER BY name_rep ASC";

    return db_select($q);
}
