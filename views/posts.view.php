<h1>Liste des Articles</h1>

<div class="row">
	<?php foreach($posts as $post): ?>
	<div class="col-md-3">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title"><?= htmlentities($post->title) ?></h5>
				<p><?= nl2br(htmlentities($post->description)) ?></p>
				<p><a href="#" class="btn btn-primary">Voir l'article</a></p>
			</div>
		</div>
	</div>
	<?php endforeach ?>
</div>