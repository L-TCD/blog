<h1 class="text-center mt-3"><?= filter_var($post->getTitle(), FILTER_SANITIZE_STRING) ?></h1>
<hr>
<p class="text-muted">Publié le <?= filter_var($post->getCreatedAt()->format('d/m/Y'), FILTER_SANITIZE_STRING) ?> par <?= filter_var($post->getAuthor()) ?>.
<?php if(!empty($post->getUpdateAt())) : ?>
	(Dernière modification le <?= filter_var($post->getUpdateAt()->format('d/m/Y à H:i:s'), FILTER_SANITIZE_STRING) ?>)</p>
<?php endif ?>
<p class="text-muted"><?= nl2br(filter_var($post->getDescription(), FILTER_SANITIZE_STRING)) ?></p><br>
<p><?= nl2br(filter_var($post->getContent(), FILTER_SANITIZE_STRING)) ?></p>
<br>

<h2 class="text-center">Commentaires</h2>
<hr>

<?php foreach($comments as $comment): ?>
	<?php if($admin) : ?>
		<div class="mb-5">
			<div class="text-muted mb-2">
				Le <?= filter_var($comment->getCreatedAt()->format('d/m/Y à H:i:s'), FILTER_SANITIZE_STRING) ?> par <?= filter_var($comment->getUsername(), FILTER_SANITIZE_STRING) ?>
				<form action="/comment/show" method="POST" style="display:inline">
					<input type="hidden" name="post_id" value="<?= filter_var($post->getId(), FILTER_VALIDATE_INT) ?>">
					<input type="hidden" name="id" value="<?= filter_var($comment->getId(), FILTER_VALIDATE_INT) ?>">
					<button class="btn btn-primary ms-1 <?= ($comment->getValid())?"disabled":"" ?>" type="submit">Afficher</button>
				</form>

				<form action="/comment/hide" method="POST" style="display:inline">
					<input type="hidden" name="post_id" value="<?= filter_var($post->getId(), FILTER_VALIDATE_INT) ?>">
					<input type="hidden" name="id" value="<?= filter_var($comment->getId(), FILTER_VALIDATE_INT) ?>">
					<button class="btn btn-secondary ms-1 <?= ($comment->getValid())?"":"disabled" ?>" type="submit">Masquer</button>
				</form>

				<form action="/comment/updateForm" method="POST" style="display:inline">
					<input type="hidden" name="post_id" value="<?= filter_var($post->getId(), FILTER_VALIDATE_INT) ?>">
					<input type="hidden" name="id" value="<?= filter_var($comment->getId(), FILTER_VALIDATE_INT) ?>">
					<button class="btn btn-warning ms-1" type="submit">Modifier</button>
				</form>

				<form action="/comment/delete" method="POST" onSubmit="return confirm('Voulez-vous vraiment supprimer le commentaire ?');" style="display:inline">
					<input type="hidden" name="post_id" value="<?= filter_var($post->getId(), FILTER_VALIDATE_INT) ?>">
					<input type="hidden" name="id" value="<?= filter_var($comment->getId(), FILTER_VALIDATE_INT) ?>">
					<button class="btn btn-danger ms-1">Supprimer</button>
				</form>

			</div>
			<div class="mx-3">
				<?php if($comment->getValid() === true) : ?>
					<span class="badge rounded-pill bg-primary">Message affiché :</span>
				<?php elseif($comment->getValid() === false) : ?>
					<span class="badge rounded-pill bg-secondary">Message masqué :</span>
				<?php else : ?>
					<span class="badge rounded-pill bg-info">Nouveau message :</span>
				<?php endif ?>
				<?php if($comment->getId() === $commentToUpdateId) : ?>
					<form action="/comment/update" method="POST">
						<div class="form-group">
							<label for="content" class="form-label">Message à modifier:</label>
							<textarea name="content" id="content" class="form-control" cols="auto" rows="auto"><?= nl2br(filter_var($comment->getContent(), FILTER_SANITIZE_STRING)) ?></textarea>
						</div>
						<input type="hidden" name="id" value="<?= filter_var($comment->getId(), FILTER_VALIDATE_INT) ?>">
						<input type="hidden" name="post_id" value="<?= filter_var($post->getId(), FILTER_VALIDATE_INT) ?>">
						<button type="submit" class="btn btn-warning my-3">Enregistrer</button>
					</form>
				<?php else : ?>
				<?= nl2br(filter_var($comment->getContent(), FILTER_SANITIZE_STRING)) ?></p>
				<?php endif ?>
			</div>
		</div>
	<?php else : ?>
		<?php if($comment->getValid() === true) : ?>
			<div class="mb-5">
				<div class="text-muted mb-2">
					Le <?= filter_var($comment->getCreatedAt()->format('d/m/Y à H:i:s'), FILTER_SANITIZE_STRING) ?> par <?= filter_var($comment->getUsername(), FILTER_SANITIZE_STRING) ?> :
				</div>
				<div class="mx-3">
					<?= nl2br(filter_var($comment->getContent(), FILTER_SANITIZE_STRING)) ?></p>
				</div>
			</div>
		<?php endif ?>
	<?php endif ?>
<?php endforeach ?>

<h2 class="text-center">Nouveau message</h2>
<hr>

<?php if(!empty($_SESSION['auth'])) : ?>
	<div class="mx-3">
		<form action="/articles/comment" method="POST">
			<div class="form-group">
				<textarea name="content" id="content" class="form-control" cols="auto" rows="2"></textarea>
			</div>
			<input type="hidden" name="post_id" value="<?= filter_var($post->getId(), FILTER_VALIDATE_INT) ?>">
			<button type="submit" class="btn btn-success my-3">Envoyer</button>
		</form>
	</div>
<?php else : ?>
	<p>Pour participer il faut <a href="<?= $router->generate("log-in-form") ?>">se connecter</a> !</p>
<?php endif ?>