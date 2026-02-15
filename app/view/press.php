<?php

function html_press_list_titles($press_a)
{
    if (empty($press_a)) {
        return <<< HTML
            <div class="empty-state">
                <p>Aucun article disponible pour le moment.</p>
            </div>
HTML;
    }

    $nb = count($press_a);

    $out = <<< HTML
    <section class="press-section">
        <div class="press-header">
            <h2 class="section-title">Tous nos articles</h2>
            <span class="count-badge">$nb articles disponibles</span>
        </div>
        <div class="press-grid">
HTML;
    foreach ($press_a as $item) {
        $visual = $item['title_art'] ?? $item['title'] ?? 'Sans titre';
        $ident_art = $item['ident_art'] ?? $item['id'] ?? 0;
        $param = (isset($item['ident_art'])) ? 'ident_art' : 'id';

        $out .= <<< HTML
            <article class="press-card">
                <a href="?page=article&$param=$ident_art">
                    <div class="card-content">
                        <h3>$visual</h3>
                    </div>
                </a>
            </article>
HTML;
    }

    $out .= <<< HTML
        </div>
    </section>
HTML;

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
     
        <h2>{$title}</h2>
            {$media}
        <p><strong>{$hook}</strong></p>     
        <div class="article-content">
            {$content}
        </div>
        <div class="navigation-back">
    <button onclick="history.back()" class="btn-back">
         Retour
    </button>
</div>
    </article>
</main>
HTML;

    return $out;
}



