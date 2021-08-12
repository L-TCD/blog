<h1><?= htmlentities($post->getTitle()) ?></h1>
<hr>
<p class="text-muted">Publié le <?= $post->getCreatedAt()->format('d/m/Y') ?> par <?= $post->getUsername() ?></p>
<p><?= nl2br(htmlentities($post->getContent())) ?></p>
<br>
<h2>Commentaires</h2>
<hr>
<?php foreach($comments as $comment): ?>
	<div>
		<p class="text-muted">Le <?= $comment->getCreatedAt()->format('d/m/Y à H:m') ?> par <?= $comment->getUsername() ?> :</p>
		<p><?= $comment->getContent() ?></p>
		<br>
	</div>
<?php endforeach ?>