<?php
/**
 * Recherche flexible : Mot-clé OU Auteur OU Les deux
 */
function search($keyword = '', $limit = 10)
{

    $params = [];
    $where_clauses = [];

    if (!empty($keyword)) {
        $where_clauses[] = "content_art LIKE :keyword";
        $params['keyword'] = "%$keyword%";
    }




    $where_sql = !empty($where_clauses) ? "WHERE " . implode(" AND ", $where_clauses) : "";

    $q = <<< SQL
        SELECT 
            title_art AS title,
            ident_art,
            hook_art AS hook,
            image_art,
            author_art AS author
        FROM `t_article`
        $where_sql
        ORDER BY date_art DESC
        LIMIT $limit
SQL;

    return db_select_prepare($q, $params);
}