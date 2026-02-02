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
	$id_lead = $lead['ident_art'] ?? $lead['id'];
	$out .= "
	<section class='section-lead'>
		<article class='article-phare'>
			<div class='phare-content'>
				<span class='badge'>À la une</span>
				<h1>{$lead['title_art']}</h1>
				<p>{$lead['hook_art']}</p>
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
				$id = $art['ident_art'] ?? $art['id'];
				$out .= "
				<article class='card-feature'>
					<h3>{$art['title']}</h3>
					<p>{$art['hook']}</p>
					<a href='?page=article&ident_art=$id'>En savoir plus →</a>
				</article>";
				}
				$out .= '</div>';
			$out .= '</section>';

		// --- 3. LA SIDEBAR ---
		$out .= '<aside class="section-sidebar">';
			$out .= '<h3>Dernières minutes</h3>';
			$out .= '<ul>';
				foreach ($sidebar as $art) {
				$id = $art['ident_art'] ?? $art['id'];
				$out .= "
				<li>
					<a href='?page=article&ident_art=$id'>
						<h4>{$art['title']}</h4>
					</a>
				</li>";
				}
				$out .= '</ul>';
			$out .= '</aside>';

		$out .= '</div>'; // Fin main-layout
	$out .= '</div>'; // Fin container-home

return $out;
}