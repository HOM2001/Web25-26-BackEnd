<?php

function main_favorite():string
{
    // model
    $menu_a = get_menu();
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; //
    }

    if (isset($_POST['action'])) {
        if ($_POST['action'] == "delete_cart") {
            $_SESSION['cart'] = [];
        }
        if ($_POST['action'] == "add" && !empty($_POST['article_id'])) {
            $_SESSION['cart'][] = $_POST['article_id']; // Ajoute l'article au tableau
            $_SESSION['cart'] = array_unique($_SESSION['cart']); // Évite les doublons
        }
        if ($_POST['action'] == "del" && !empty($_POST['article_id'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($id) {
                return $id != $_POST['article_id'];
            });
        }
    }

    echo json_encode($_SESSION['cart']);

    // view
    return join( "\n", [
        html_head($menu_a),
        html_panier_favorite(),
        html_foot(),
    ]);

}

