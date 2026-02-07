<?php

function main_favorite():string
{
    if(!isset($_SESSION['panier'])){
        $_SESSION['panier'] = [];
    }
    $action = $_GET["action"] ?? '';
    $id = $_GET["id"] ?? '';

    if ($action == 'add' && $id) {
        if (!in_array($id,$_SESSION['panier'])) {
            $_SESSION['panier'][] = $id;
            header("Location: ?page=favorite");
            exit;
        }
    }
    if ($action === 'remove' && $id) {
        $key = array_search($id, $_SESSION['panier']);
        if ($key !== false){
            unset($_SESSION['panier'][$key]);
            header("Location: ?page=favorite");
            exit;
        }
    }
    if ($action === 'clear') {
        $_SESSION['panier'] = [];
        header("Location: ?page=favorite");
        exit;
    }


    $menu_a = get_menu();


    $articles_complets = [];

    if (!empty($_SESSION['panier'])) {

        if (DATABASE_TYPE === "MySql") {
            $ids_string = implode(',', array_map('intval', $_SESSION['panier']));
            $sql = "SELECT ident_art, title_art, readtime_art, image_art FROM t_article WHERE ident_art IN ($ids_string)";
            $articles_complets = db_select($sql);

        } elseif (DATABASE_TYPE === "json") {
            $content_s = file_get_contents('../asset/database/article.json');
            $all_articles = json_decode($content_s, true);

            $articles_filtres = array_filter($all_articles, function($item) {

                return in_array($item['id'], $_SESSION['panier']);
            });

            $articles_complets = [];
            foreach ($articles_filtres as $item) {
                $articles_complets[] = [
                    'ident_art'    => $item['id'],
                    'title_art'    => $item['title'],
                    'readtime_art' => 5,
                    'image_art'    => "default.jpg"
                ];
            }
        }
    }



    return join( "\n", [
        html_head($menu_a),
        html_panier_contenu($articles_complets),
        html_panier_favorite(),
        html_foot(),
    ]);

}

