<h1 class="text-center mt-3">Liste des articles</h1>

<div class="row">
	<?php foreach($posts as $post): ?>
	<div class="col-md-3">
		<div class="card mb-4">
			<div class="card-body">
				<h5 class="card-title"><?= htmlentities($post->getTitle()) ?></h5>
				<p class="text-muted">Publié le <?= $post->getCreatedAt()->format('d/m/Y') ?> par <?= htmlentities($post->getAuthor()) ?></p>
				<p><?= nl2br(htmlentities($post->getDescription())) ?></p>
				<p><a href="<?= $router->generate("show-post", ["id" => $post->getId()]) ?>" class="btn btn-primary">Voir l'article</a></p>
			</div>
		</div>
	</div>
	<?php endforeach ?>
</div>