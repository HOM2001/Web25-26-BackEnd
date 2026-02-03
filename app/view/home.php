<?php
/**
* Vue principale de la Home
* @param array|null $lead       L'article phare (un seul tableau)
* @param array      $features   Les 3 articles principaux (tableau de tableaux)
* @param array      $sidebar    Le reste des articles (tableau de tableaux)
*/
function html_home($lead, $features, $sidebar)
{
    $out = '<div class="container-home">';

    // --- 1. L'ARTICLE PHARE (LEAD) ---
    if ($lead) {
        $id_lead    = $lead['ident_art']   ?? $lead['id'];
        $title_lead = $lead['title_art']   ?? $lead['title'];
        $hook_lead  = $lead['hook_art']    ?? $lead['hook'] ?? "";
        $image_name = $lead['image_art']   ?? ""; // Corrigé : $lead au lieu de $art_a

        $media = "";
        if (!empty($image_name)){
            $media_path = MEDIA_PATH . $image_name;
            $media = "<div class='media-phare'><img src='{$media_path}' alt='{$title_lead}'></div>";
        }

        $out .= "
        <section class='section-lead'>
           <article class='article-phare'>
              {$media}
              <div class='phare-content'>
                 <span class='badge'>À la une</span>
                 <h1>{$title_lead}</h1>
                 <p>{$hook_lead}</p>
                 <a href='?page=article&ident_art=$id_lead' class='btn-phare'>Lire l'article complet</a>
              </div>
           </article>
        </section>";
    }

    $out .= '<div class="main-layout">';

    // --- 2. LES ARTICLES PRINCIPAUX (FEATURES) ---
    $out .= '<section class="section-features">';
    $out .= '<h2>À la une cette semaine</h2>';
    $out .= '<div class="grid-features">';
    foreach ($features as $art) {
        $id    = $art['ident_art'] ?? $art['id'];
        $title = $art['title_art'] ?? $art['title'];
        $hook  = $art['hook_art']  ?? $art['hook'] ?? "";
        $image_name = $art['image_art']   ?? ""; //

        $media = "";
        if (!empty($image_name)){
            $media_path = MEDIA_PATH . $image_name;
            $media = "<div class='media-phare'><img src='{$media_path}' alt='{$title}'></div>";
        }
        $out .= "
                 <article class='card-feature'>
                    <h3>{$title}</h3>
                    {$media}
                    <p>{$hook}</p>
                    <a href='?page=article&ident_art=$id' class='read-more'>En savoir plus →</a>
                 </article>";
    }
    $out .= '</div>';
    $out .= '</section>';

    // --- 3. LA SIDEBAR ---
    $out .= '<aside class="section-sidebar">';
    $out .= '<h3>Dernières minutes</h3>';
    $out .= '<ul>';
    foreach ($sidebar as $art) {
        $id    = $art['ident_art'] ?? $art['id'];
        $title = $art['title_art'] ?? $art['title'];
        $hook  = $art['hook_art']  ?? $art['hook'] ?? "";
        $hook_short = limit_words($hook, DEFAULT_LIMIT_SIDEBAR);
        $out .= "
                 <li>
                    <a href='?page=article&ident_art=$id'>
                       <h4>{$title}</h4>
                       <p>{$hook_short}</p>
                    </a>
                 </li>";
    }
    $out .= '</ul>';
    $out .= '</aside>';

    $out .= '</div>';
    $out .= '</div>';

    return $out;
}