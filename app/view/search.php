<?php
function html_search_form($reporters = [],$max_articles = 100)
{
    $author_select_html = "";

    if (DATABASE_TYPE == "MySql") {
        $options_reporters = '<option value="">Tous les auteurs</option>';
        foreach ($reporters as $rep) {
            $name = $rep['name_rep'] ?? $rep['name'] ?? 'Inconnu';
            $options_reporters .= "<option value='$name'>$name</option>";
        }

        $author_select_html = <<< HTML
            <div>
                <label>Auteur :</label>
                <select name="author">
                    $options_reporters
                </select>
            </div>
HTML;
    }
    return <<< HTML
    <div class="search-page-layout">
        <form method="post" action="?page=search" class="search-form">
            <h3>Filtres de recherche</h3>
            <div>
                <label>Mot-clé :</label>
                <input name="keyword" type="text" placeholder="Ex : France">
            </div> 
            {$author_select_html}
            <div>
                <label>Résultats max :</label>
                <input name="limit" type="number" value="10" min="1" max="$max_articles">
            </div>
            <button type="submit">Lancer la recherche</button>    
        </form>
HTML;
}

function html_result_search($press_a)
{
    $count = count($press_a);
    $url_param = (DATABASE_TYPE === "json") ? "id" : "ident_art";

    $out = <<< HTML
    <div class="result-column">
        <h2>Articles trouvés ($count)</h2>
        <ul class="result-list">
HTML;

    if (empty($press_a)) {
        $out .= "<li>Aucun article ne correspond à votre recherche.</li>";
    } else {
        foreach ($press_a as $item) {
            $title = $item['title_art'] ?? $item['title'] ?? 'Sans titre';
            $id_art = $item['ident_art'] ?? $item['id'] ?? 0;

            $out .= <<< HTML
            <li>
                <a href="?page=article&$url_param=$id_art">$title</a>
            </li>
HTML;
        }
    }

    $out .= <<< HTML
        </ul>
    </div>
</div> 
HTML;

    return $out;
}

