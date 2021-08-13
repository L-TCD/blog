<h1>show-post-list</h1>

<div class="row">
	<?php foreach($posts as $post): ?>
	<div class="col-md-3">
		<div class="card mb-4">
			<div class="card-body">
				<h5 class="card-title"><?= htmlentities($post->getTitle()) ?></h5>
				<p><?= nl2br(htmlentities($post->getDescription())) ?></p>
				<p><a href="<?= $router->generate("show-post", ["id" => $post->getId()]) ?>" class="btn btn-primary">Voir l'article</a></p>
			</div>
		</div>
	</div>
	<?php endforeach ?>
</div>