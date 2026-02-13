<?php
function html_readtimes_results($time, $articles)
{
    $out = "<div class='container'>";

    if ($time) {
        $out .= "<h1>Articles de $time minutes</h1>";

        if (!empty($articles)) {
            $out .= "<div class='article-list'>";
            foreach ($articles as $art) {
                $out .= "
                <article style='margin-bottom: 20px; border-bottom: 1px solid #ccc;'>
                    <h4>{$art['title_art']}</h4>
                    <p>{$art['hook_art']}</p>
                    <a href='?page=article&ident_art={$art['ident_art']}'>Lire l'article</a>
                </article>";
            }
            $out .= "</div>";
        } else {
            $out .= "<p>Aucun article trouvé pour cette durée.</p>";
        }
    } else {
        $out .= "<h1>Veuillez choisir un temps de lecture dans le menu ci-dessus.</h1>";
    }

    $out .= "</div>";
    return $out;
}