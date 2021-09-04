<h1 class="text-center mt-3">Page d'édition d'article</h1>

<form action="/admin/articles/edition" method="POST">
	<div class="row g-3">
		<div class="text-muted">Publié le <?= filter_var($post->getCreatedAt()->format('d/m/Y'), FILTER_SANITIZE_STRING) ?></div>
		<?php if($post->getUpdateAt() !== NULL) : ?>
			<div class="text-muted">Dernière modification le <?= filter_var($post->getUpdateAt()->format('d/m/Y à H:i:s'), FILTER_SANITIZE_STRING) ?></div>
		<?php endif ?>
		<div class="form-group">
			<label for="title" class="form-label">Titre :</label>
			<input type="text" class="form-control" id="title" name="title" value="<?= filter_var($post->getTitle(), FILTER_SANITIZE_STRING) ?>" required>
		</div>
		<div class="form-group">
			<label for="author" class="form-label">Auteur :</label>
			<input type="text" class="form-control" id="author" name="author" value="<?= filter_var($post->getAuthor(), FILTER_SANITIZE_STRING) ?>" required>
		</div>
		<div class="form-group">
			<label for="description" class="form-label">Chapô :</label>
			<textarea name="description" id="description" class="form-control" required><?= filter_var($post->getDescription(), FILTER_SANITIZE_STRING) ?></textarea>
		</div>
		<div class="form-group">
			<label for="content" class="form-label">Contenu :</label>
			<textarea name="content" id="content" class="form-control" cols="auto" rows="10" required><?= filter_var($post->getContent(), FILTER_SANITIZE_STRING) ?></textarea>
		</div>
		<input type="hidden" name="id" value="<?= filter_var($post->getId(), FILTER_VALIDATE_INT) ?>">
	</div>
	<hr class="my-4">
	<button type="submit" class="w-100 btn btn-warning btn-lg">Valider</button>
</form>