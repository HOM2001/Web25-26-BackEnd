<?php

function html_press_list_titles($press_a)
{
    if(empty($press_a))
    {
        return '';
    }

    $out = <<< HTML
        <h2>Tous nos articles de presse</h2>
HTML;

    $out .= <<< HTML
        <ul class="">
HTML;
    foreach( $press_a as $item)
    {
        $visual = $item['title'] ?? 'Sans titre';


        $ident_art = $item['ident_art'] ?? $item['id'];
        $out .= <<< HTML
            <li><a href="?page=article&ident_art=$ident_art">$visual</a></li>
HTML;

    }
    $out .= "</ul>";
    
    return $out;
}

function html_press_article($art_a)
{
    // On extrait les valeurs en gérant les deux formats possibles
    // Format MySQL : title_art | Format JSON : title
    $title   = $art_a["title_art"]   ?? $art_a["title"]    ?? "Titre inconnu";

    // Format MySQL : hook_art | Format JSON : hook
    $hook    = $art_a["hook_art"]    ?? $art_a["hook"]     ?? "";

    // Format MySQL : content_art | Format JSON : contents (avec un s)
    $content = $art_a["content_art"] ?? $art_a["contents"] ?? "";
    var_dump($art_a);

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

