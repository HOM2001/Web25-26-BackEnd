<?php

function html_press_list_titles($press_a)
{
    if(empty($press_a))
    {
        return '<p>Aucun article disponible.</p>';
    }

    $out = "<h2>Tous nos articles de presse</h2>";
    $out .= "<ul>";

    foreach($press_a as $item)
    {

        $visual = $item['title'] ?? 'Sans titre';


        $ident_art = $item['ident_art'] ?? $item['id'] ?? 0;

        $out .= <<< HTML
            <li>
                <a href="?page=article&ident_art=$ident_art">$visual</a>
            </li>
HTML;
    }

    $out .= "</ul>";

    return $out;
}

function html_press_article($art_a)
{


    $title   = $art_a["title_art"]   ?? $art_a["title"]    ?? "Titre inconnu";


    $hook    = $art_a["hook_art"]    ?? $art_a["hook"]     ?? "";


    $content = $art_a["content_art"] ?? $art_a["contents"] ?? "";

    $out = <<< HTML
<main>
    <article class="main_article">
        <h2>{$title}</h2>
        <p><strong>{$hook}</strong></p>     
        <div class="article-content">
            {$content}
        </div>
    </article>
</main>
HTML;

    return $out;
}

function html_search_form()
{
    $out = <<< HTML
<main>
    <form method="post">
        <label>Introduisez ici un mot-clé :</label>
        <input name="keyword" type="text">
        <button>search</button>    
    </form>
</main>
HTML;
    return $out;

}

