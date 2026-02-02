<?php
/*
 * Display articles of the home page
 */
function html_home_main($article_a	, array $bottom_article_a , array $secondary_article_a): string
{
	$title = htmlspecialchars($article_a['title'] ?? 'Titre inconnu');
	$hook = htmlspecialchars($article_a['hook'] ?? '');
	$art_id = (int)($article_a['id'] ?? 0);

	// Trouver l'article "Des films..."
	$featured_article = null;
	foreach ($bottom_article_a as $key => $article) {
		if (stripos($article['title'], 'Des films') === 0) {
			$featured_article = $article;
			unset($bottom_article_a[$key]); // Retirer de la liste principale
			break;
		}
	}

	ob_start();
	?>

	<br>
	<div class="container mb-4">
		<div class="card shadow-sm border-0">
			<a href="?page=article&art_id=<?= $art_id ?>" style="text-decoration: none; color: inherit;">
				<?php
				$img = !empty($article_a['image_name'])
					? '../public/media/' . $article_a['image_name']
					: '../public/media/default.jpg';
				?>
				<img src="<?= htmlspecialchars($img) ?>"
					 class="card-img-top"
					 alt="Image principale"
					 style="object-fit: cover; max-height: 260px; width: 100%;">
				<div class="card-body p-3">
					<h3 class="card-title mb-2" style="font-size: 1.5rem;"><?= htmlspecialchars($title) ?></h3>
					<p class="card-text mb-0" style="font-size: 1rem;"><?= htmlspecialchars($hook) ?></p>
				</div>
			</a>
		</div>
	</div>




	<!-- Début de la liste d'articles -->
	<div class="container">
		<div class="row">

			<!-- Article "Des films..." en premier (même style que les autres) -->
			<?php if ($featured_article): ?>
				<?php
				$title = htmlspecialchars($featured_article['title']);
				$img = htmlspecialchars($featured_article['image'] ?? 'default.jpg');
				$id = (int)($featured_article['id'] ?? 0);
				?>
				<div class="col-md-6 mb-4">
					<div class="card h-100">
						<a href="?page=article&art_id=<?= $id ?>" style="text-decoration: none; color: inherit;">
							<img src="<?= $img ?>" class="card-img-top" alt="Image" style="object-fit: cover; height: 200px;">
							<div class="card-body">
								<h5 class="card-title"><?= $title ?></h5>
								<p class="card-text"><?= strlen($featured_article['content']) ?> caractères</p>
							</div>
						</a>
					</div>
				</div>
			<?php endif; ?>

			<!-- Tous les autres articles -->
			<?php foreach ($bottom_article_a as $article): ?>
				<?php
				$title = htmlspecialchars($article['title']);
				$img = !empty($article['image_name'])
					? '../public/media/' . $article['image_name']
					: '../public/media/default.jpg';
				$id = (int)($article['id'] ?? 0);
				?>
				<div class="col-md-6 mb-4">
					<div class="card h-100">
						<a href="?page=article&art_id=<?= $id ?>" style="text-decoration: none; color: inherit;">
							<img src="<?= $img ?>" class="card-img-top" alt="Image" style="object-fit: cover; height: 200px;">
							<div class="card-body">
								<h5 class="card-title"><?= $title ?></h5>
								<p class="card-text"><?= strlen($article['content']) ?> caractères</p>
							</div>
						</a>
					</div>
				</div>
			<?php endforeach; ?>

		</div>
	</div>

	<?php
	return ob_get_clean();
}

