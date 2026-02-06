<?php
/*
 * Display a cart for add favorite article in the cart
 */
function html_panier_favorite() {
    $articles = get_sql();
    ob_start();
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <section class="favorite">
        <h1>Catalogue</h1>
        <br>
        <?php
        if (!empty($articles) && is_array($articles)) {
            foreach($articles as $item)
            {

                $title = $item['title_art'] ?? $item['title'] ?? 'Sans titre';
                $art_id = $item['ident_art'] ?? $item['id'] ?? 0;
                $image_name = $item['image_art']   ?? "";

                $media = "";
                if (!empty($image_name)){
                    $media_path = MEDIA_PATH . $image_name;
                    $media = "<img src='{$media_path}' alt='{$title}'>";
                }
                echo <<<HTML
                    <div id="article{$art_id}">
                         {$title}
                         <br>
                         {$media}
                    </div>
                    <br>
                    <button class="add" data-id="{$art_id}">Ajouter au panier</button>
                    <button class="delete" data-id="{$art_id}">Retirer du panier</button>
                    <hr>
HTML;
            }
        }
        ?>
        <div id="panier">
            <h2>Dans votre panier :</h2>
            <ul id="panier_contenu"></ul>
        </div>
        <button class="delete_cart">Effacer tout le panier</button>
    </section>
    <?php
    return ob_get_clean();

}