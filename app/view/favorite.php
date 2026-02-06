<?php
/*
 * Display a cart for add favorite article in the cart
 */
function html_panier_favorite() {
    $articles = get_sql();
    ob_start();
    ?>


    <section class="favorite">
        <h1>Catalogue</h1>
        <br>
        <?php
        if (!empty($articles) && is_array($articles)) {
            foreach($articles as $item)
            {

                $title = $item['title_art'] ?? $item['title'] ?? 'Sans titre';
                $art_id = $item['ident_art'] ?? $item['id'] ?? 0;


                echo <<<HTML
                   <div id="article{$art_id}">
         <h3> Article {$art_id} : {$title}</h3>
         <br>
         <a href="?page=favorite&action=add&id={$art_id}" class="btn add">Ajouter</a>
         <a href="?page=favorite&action=remove&id={$art_id}" class="btn delete">Retirer</a>
    </div>
    <hr>
HTML;
            }
        }
        ?>
   </section>
    <?php
    return ob_get_clean();

}
function html_panier_contenu($articles_selectionnes = [])
{
    ob_start();
    ?>
    <div id="panier" class="panier-style">
        <h2><i class="fas fa-shopping-cart"></i> Votre Liste de Lecture</h2>
        <ul id="panier_contenu">
            <?php if (empty($articles_selectionnes) || !is_array($articles_selectionnes)): ?>
                <li>Votre panier est vide.</li>
            <?php else: ?>
                <?php foreach($articles_selectionnes as $fav): ?>
                    <li>
                        <strong><?= htmlspecialchars($fav['title_art'] ?? 'Sans titre') ?></strong>

                        <span class="read-time-badge">
                            <?= $fav['readtime_art'] ?? 0 ?> min
                        </span>

                        <a href="?page=favorite&action=remove&id=<?= $fav['id_art'] ?>" class="btn-remove-fav">
                            [x]
                        </a>
                    </li>
                <?php endforeach; ?>

                <li class="total-pigeons">
                    <hr>
                    <a href="?page=favorite&action=clear" class="btn-delete">Tout effacer</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}
