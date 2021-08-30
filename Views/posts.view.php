<h1 class="text-center my-5">Les articles</h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
	<?php foreach($posts as $post): ?>
	<div class="col">
		<div class="card text-center h-100">
			<div class="card-body">
				<h5 class="card-title"><?= htmlentities($post->getTitle()) ?></h5>
				<p class="text-muted">Publié le <?= $post->getCreatedAt()->format('d/m/Y') ?><br>par <?= htmlentities($post->getAuthor()) ?></p>
				<p><?= nl2br(htmlentities($post->getDescription())) ?></p>
				<p><a href="<?= $router->generate("show-post", ["id" => $post->getId()]) ?>" class="btn btn-primary">Voir l'article</a></p>
			</div>
		</div>
	</div>
	<?php endforeach ?>
</div>