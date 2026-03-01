<?php
/*
 * Display a cart for add favorite article in the cart
 */
function html_panier_favorite() : string{
    $total_articles = get_article_count();
    if(DATABASE_TYPE === 'MySql'){
        $articles = get_sql('','recent',100);
    }elseif (DATABASE_TYPE === 'json') {
        $content_a = get_all_json_data();

        $articles  = array_slice($content_a, 0, 20);

    }


    ob_start();
    ?>


    <section class="favorite">
        <h1>Catalogue</h1>
        <div class="favorite-grid">
        <br>
        <?php
        if (!empty($articles) && is_array($articles)) {
            foreach($articles as $key => $item) {
                $display_id = $key+1;
                $id = $item['ident_art'] ?? $item['id'];
                $title = $item['title_art'] ?? $item['title'];
                $image_name = $item['image_art']   ?? "default.jpg";

                $media = "";
                if (!empty($image_name)){
                    $media_path = MEDIA_PATH . $image_name;
                    $media = " <img src='{$media_path}' alt='{$title}'>";
                }
                // On vérifie si l'article est déjà dans le panier
                $is_favorite = in_array($id, $_SESSION['panier']);

                // Si favori -> la classe est active (jaune) sinon transparent
                $class = $is_favorite ? 'active' : 'inactive';
                // changement de la classe premier click add second click remove
                $action = $is_favorite ? 'remove' : 'add';
                echo <<<HTML
    <div class="article-container">
    <span class="article-number">#{$display_id}</span>
        <a href="?page=favorite&action={$action}&id={$id}" class="btn-star-toggle {$class}">
            ★
        </a>
        <div class="article-content">
            {$media}
            <h3>{$title}</h3>
        </div>
    </div>
HTML;

            }
        }
        ?>
        </div>
   </section>
    <?php
    return ob_get_clean();

}
function html_panier_contenu($articles_selectionnes = []) {
    if(DATABASE_TYPE === 'MySql'){
        $all_articles = get_sql('', 'recent',100);
    }elseif (DATABASE_TYPE === 'json') {
        $content_a = get_all_json_data();

        $all_articles  = array_slice($content_a, 0, 20);

    }
    $id_to_pos = [];
    foreach ($all_articles as $key => $a) {
        $id = (DATABASE_TYPE === 'MySql') ? $a['ident_art'] : $a['id'];
        $id_to_pos[$id] = $key + 1;
    }

    ob_start();
    ?>
    <div id="panier" class="panier-style">
        <h2> Votre Liste de favoris </h2>
        <ul id="panier_contenu">
            <?php if (empty($articles_selectionnes)): ?>
                <li>Votre panier est vide.</li>
            <?php else: ?>
                <?php foreach($articles_selectionnes as $fav): ?>
                    <?php $original_number = $id_to_pos[$fav['ident_art']] ?? '?'; ?>
                    <li>
                        <div>
                            <span class="read-time-badge">#<?= $original_number ?></span>
                            <strong><?= htmlspecialchars($fav['title_art'] ?? 'Sans titre') ?></strong>
                        </div>

                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="read-time-badge"><?= $fav['readtime_art'] ?? 0 ?> min</span>
                            <a href="?page=favorite&action=remove&id=<?= $fav['ident_art'] ?>" class="btn-remove-fav"></a>
                        </div>
                    </li>
                <?php endforeach; ?>
                <div class="">
                    <hr>
                    <a href="?page=favorite&action=clear" class="btn-delete">Vider le panier</a>
                </div>
            <?php endif; ?>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}
