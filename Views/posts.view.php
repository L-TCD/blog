<h1 class="text-center my-5">Les articles</h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
	<?php foreach($posts as $post): ?>
	<div class="col">
		<div class="card text-center h-100">
			<div class="card-body">
				<h5 class="card-title"><?= filter_var($post->getTitle(), FILTER_SANITIZE_STRING) ?></h5>
				<p class="text-muted">Publié le <?= filter_var($post->getCreatedAt()->format('d/m/Y'), FILTER_SANITIZE_STRING) ?><br>par <?= filter_var($post->getAuthor(), FILTER_SANITIZE_STRING) ?></p>
				<p><?= nl2br(filter_var($post->getDescription(), FILTER_SANITIZE_STRING)) ?></p>
				<p><a href="<?= $router->generate("show-post", ["id" => filter_var($post->getId(), FILTER_VALIDATE_INT)]) ?>" class="btn btn-primary">Voir l'article</a></p>
			</div>
		</div>
	</div>
	<?php endforeach ?>
</div>