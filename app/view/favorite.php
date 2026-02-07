<?php
/*
 * Display a cart for add favorite article in the cart
 */
function html_panier_favorite() : string{
    if(DATABASE_TYPE === 'MySql'){
        $articles = get_sql('',100);
    }elseif (DATABASE_TYPE === 'json') {
        $content_s = file_get_contents('../asset/database/article.json');
        $content_a = json_decode($content_s, true);

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
                $title = $item['title'];
                $image_name = $lead['image_art']   ?? "default.jpg"; // Corrigé : $lead au lieu de $art_a

                $media = "";
                if (!empty($image_name)){
                    $media_path = MEDIA_PATH . $image_name;
                    $media = " <img src='{$media_path}' alt='{$title}'>";
                }
                // On vérifie si l'article est déjà dans le panier
                $is_favorite = in_array($id, $_SESSION['panier']);

                // Si favori -> la classe est 'active' (jaune), sinon 'inactive' (transparent)
                // On change aussi l'action : si déjà là, le prochain clic l'enlève (remove)
                $class = $is_favorite ? 'active' : 'inactive';
                $action = $is_favorite ? 'remove' : 'add';
                echo <<<HTML
    <div class="article-container">
    <span class="article-number">{$display_id}</span>
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
        $all_articles = get_sql('',100);
    }elseif (DATABASE_TYPE === 'json') {
        $content_s = file_get_contents('../asset/database/article.json');
        $content_a = json_decode($content_s, true);

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
        <h2><i class="fas fa-shopping-cart"></i> Votre Liste de Lecture</h2>
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
                <li class="total-pigeons">
                    <hr>
                    <a href="?page=favorite&action=clear" class="btn-delete">Vider le panier</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}
