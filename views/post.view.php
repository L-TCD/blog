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
			<form action="/comment/show" method="POST" style="display:inline">
				<input type="hidden" name="post_id" value="<?= $post->getId() ?>">
				<input type="hidden" name="id" value="<?= $comment->getId() ?>">
				<button class="btn btn-primary ms-1 <?= ($comment->getValid())?"disabled":"" ?>" type="submit">Afficher</button>
			</form>
			<form action="/comment/hide" method="POST" style="display:inline">
				<input type="hidden" name="post_id" value="<?= $post->getId() ?>">
				<input type="hidden" name="id" value="<?= $comment->getId() ?>">
				<button class="btn btn-secondary ms-1 <?= ($comment->getValid())?"":"disabled" ?>" type="submit">Masquer</button>
			</form>
			<form action="/comment/updateForm" method="POST" style="display:inline">
				<input type="hidden" name="post_id" value="<?= $post->getId() ?>">
				<input type="hidden" name="id" value="<?= $comment->getId() ?>">
				<button class="btn btn-warning ms-1" type="submit">Modifier</button>
			</form>
			<form action="/comment/delete" method="POST" onSubmit="return confirm('Voulez-vous vraiment supprimer le commentaire ?');" style="display:inline">
				<input type="hidden" name="post_id" value="<?= $post->getId() ?>">
				<input type="hidden" name="id" value="<?= $comment->getId() ?>">
				<button class="btn btn-danger ms-1">Supprimer</button>
			</form>
		</div>

		<?php if($comment->getValid()) : ?>
			<p class="text-primary">Public :</p>
		<?php else : ?>
			<p class="text-secondary">Privé :</p>
		<?php endif ?>
		<?php if($comment->getId() === $commentToUpdateId) : ?>
			<form action="/comment/update" method="POST">
				<div class="form-group">
					<label for="content" class="form-label">Message à modifier:</label>
					<textarea name="content" id="content" class="form-control" cols="auto" rows="auto"><?= $comment->getContent() ?></textarea>
				</div>
				<input type="hidden" name="id" value="<?= $comment->getId() ?>">
				<input type="hidden" name="post_id" value="<?= $post->getId() ?>">
				<button type="submit" class="btn btn-warning my-3">Enregistrer</button>
			</form>
		<?php else : ?>
		<p><?= $comment->getContent() ?></p>
		<?php endif ?>
	</div>
<?php endforeach ?>

<form action="/articles/comment" method="POST">
	<div class="form-group">
		<label for="content" class="form-label"><h3>Nouveau message :</h3></label>
		<textarea name="content" id="content" class="form-control" cols="auto" rows="2"></textarea>
	</div>
	<input type="hidden" name="post_id" value="<?= $post->getId() ?>">
	<button type="submit" class="btn btn-success my-3">Envoyer</button>
</form>