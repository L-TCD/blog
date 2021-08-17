<h1><?= htmlentities($post->getTitle()) ?></h1>
<hr>
<p class="text-muted">Publié le <?= $post->getCreatedAt()->format('d/m/Y') ?> par <?= $post->getAuthor() ?></p>
<p><?= nl2br(htmlentities($post->getContent())) ?></p>
<br>
<h2>Commentaires</h2>
<hr>
<?php foreach($comments as $comment): ?>
	<div>
		<div class="text-muted">Le <?= $comment->getCreatedAt()->format('d/m/Y à H:m') ?> par <?= $comment->getUsername() ?> :
			<form action="/comment/delete" method="POST" style="display:inline">
				<input type="hidden" name="post_id" value="<?= $post->getId() ?>">
				<input type="hidden" name="id" value="<?= $comment->getId() ?>">
				<button class="btn btn-danger ms-1">Supprimer</button>
			</form>
		</div>
		<p><?= $comment->getContent() ?></p>
		<br>
	</div>
<?php endforeach ?>
<form action="/articles/comment" method="POST">
	<div class="form-group">
		<label for="content" class="form-label">Votre message :</label>
		<textarea name="content" id="content" class="form-control" cols="auto" rows="2"></textarea>
	</div>
	<input type="hidden" name="post_id" value="<?= $post->getId() ?>">
	<button type="submit" class="btn btn-success my-3">Publier</button>
</form>