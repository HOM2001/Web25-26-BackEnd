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
    if (isset($art_a['error'])) {
        return <<< HTML
        <main>
            <div style="background: #fee; color: #b00; padding: 20px; border: 1px solid #b00; margin: 20px;">
                <strong>Erreur :</strong> {$art_a['error']}
                <br><br>
                <a href="?page=press">Retour à la liste</a>
            </div>
        </main>
HTML;
    }


    $title   = $art_a["title_art"]   ?? $art_a["title"]    ?? "Titre inconnu";


    $hook    = $art_a["hook_art"]    ?? $art_a["hook"]     ?? "";


    $content = $art_a["content_art"] ?? $art_a["contents"] ?? "";

    $image_name   = $art_a["image_art"]  ?? "";
    $media = "";
    if (!empty($image_name)){
        $media_path = MEDIA_PATH.$image_name;
        $media  = "<div><img src={$media_path} alt={$title}></div>";
    }
    $out = <<< HTML
<main>
    <article class="main_article">
      <nav class="breadcrumb">
        <a href="?page=home">Accueil</a> <span>&gt;</span> 
        <a href="?page=press">Articles</a> <span>&gt;</span> 
      </nav>
        <h2>{$title}</h2>
            {$media}
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

