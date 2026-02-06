<?php

function main_favorite():string
{
    if(!isset($_SESSION['panier'])){
        $_SESSION['panier'] = [];
    }
    $action = $_GET["action"] ?? '';
    $id = $_GET["id"] ?? '';

    var_dump($_SESSION['panier']);
    if ($action == 'add' && $id) {
        if (!in_array($id,$_SESSION['panier'])) {
            $_SESSION['panier'][] = $id;
        }
    }
    if ($action === 'remove' && $id) {
        $key = array_search($id, $_SESSION['panier']);
        if ($key !== false){
            unset($_SESSION['panier'][$key]);
        }
    }
    if ($action === 'clear' && $id) {
        $_SESSION['panier'] = [];
    }


    $menu_a = get_menu();
    $articles_complets = [];

    if (!empty($_SESSION['panier'])) {
        $ids_string = implode(',', array_map('intval', $_SESSION['panier']));
        $sql = "SELECT id_art, title_art, readtime_art FROM t_article WHERE id_art IN ($ids_string)";

        // DEBUG : Copie ce qui s'affiche à l'écran et colle-le dans PhpMyAdmin SQL
        // echo $sql;

        $articles_complets = db_select($sql);
    }
    var_dump($articles_complets);


    return join( "\n", [
        html_head($menu_a),
        html_panier_contenu($articles_complets),
        html_panier_favorite(),
        html_foot(),
    ]);

}

