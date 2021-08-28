<h1 class="text-center mt-3">Page d'édition d'article</h1>

<form action="/admin/articles/edition" method="POST">
	<div class="text-muted">Publié le <?= $post->getCreatedAt()->format('d/m/Y') ?></div>
	<?php if($post->getUpdateAt() !== NULL) : ?>
		<div class="text-muted">Dernière modification le <?= $post->getUpdateAt()->format('d/m/Y à H:i:s') ?></div>
	<?php endif ?>
	<div class="form-group">
		<label for="title" class="form-label">Titre :</label>
		<input type="text" class="form-control" id="title" name="title" value="<?= htmlentities($post->getTitle()) ?>">
	</div>
	<div class="form-group">
		<label for="slug" class="form-label">Slug :</label>
		<input type="text" class="form-control" id="slug" name="slug" value="<?= htmlentities($post->getSlug()) ?>">
	</div>
	<div class="form-group">
		<label for="author" class="form-label">Auteur :</label>
		<input type="text" class="form-control" id="author" name="author" value="<?= htmlentities($post->getAuthor()) ?>">
	</div>
	<div class="form-group">
		<label for="description" class="form-label">Chapô :</label>
		<textarea name="description" id="description" class="form-control"><?= htmlentities($post->getDescription()) ?></textarea>
	</div>
	<div class="form-group">
		<label for="content" class="form-label">Contenu :</label>
		<textarea name="content" id="content" class="form-control" cols="auto" rows="10"><?= htmlentities($post->getContent()) ?></textarea>
	</div>
	<input type="hidden" name="id" value="<?= $post->getId() ?>">
	<button type="submit" class="btn btn-warning my-3">Valider</button>
</form>