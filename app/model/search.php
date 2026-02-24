<?php
/**
 * Recherche flexible : Mot-clé OU Auteur OU Les deux
 */
function search($author='', $keyword = '', $limit = 10)
{

    if (DATABASE_TYPE === "json") {
       $content_a = get_all_json_data();
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
    $q = "SELECT DISTINCT name_rep FROM t_reporter ORDER BY name_rep ASC";

    return db_select($q);
}
function get_top_reporter(){
    $q = "SELECT r.id_rep, r.name_rep, COUNT(a.id_art) as nb_articles
          FROM t_reporter r
          LEFT JOIN t_article a ON r.id_rep = a.reporter_art
          GROUP BY r.id_rep
          ORDER BY nb_articles DESC
          LIMIT 1";

    return db_select($q);
}

