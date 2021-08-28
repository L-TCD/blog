<h1 class="text-center mt-3">Gestion des articles</h1>

<form action="/admin/articles/formulaireAjout" method="POST">
	<button class="btn btn-success my-3 w-100" type="submit">Ajouter</button>
</form>

<table class="table text-center">
	<thead>
		<tr>
			<th scope="col">N°</th>
			<th scope="col">Titre</th>
			<th scope="col" colspan="3">Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($posts as $post): ?>
			<tr id="postId<?= $post->getId() ?>">
				<td scope="row" class="align-middle"><a href="/admin/articles/<?= $post->getId() ?>"><?= $post->getId() ?></a></td>
				<td class="align-middle">
					<a href="/admin/articles/<?= $post->getId() ?>"><?= $post->getTitle() ?></a>
				</td>
				<td>
					<?php if($post->getCommentToValid() === true) : ?>
						<form action="/articles/<?= $post->getId() ?>" method="POST" style="display:inline">
							<button class="btn btn-info" type="submit">
								Nouveau message
							</button>
						</form>
					<?php else : ?>
					<form action="/articles/<?= $post->getId() ?>" method="POST" style="display:inline">
							<button class="btn btn-secondary" type="submit">
								Afficher l'article
							</button>
						</form>
					<?php endif ?>
				</td>
				<td class="align-middle">
					<form action="/admin/articles/<?= $post->getId() ?>" method="POST" style="display:inline">
						<button class="btn btn-warning" type="submit">Modifier</button>
					</form>
				</td>
				<td>
					<form action="/admin/articles/suppression" method="POST" onSubmit="return confirm('Voulez-vous vraiment supprimer l\'article ?');" style="display:inline">
						<input type="hidden" name="id" value="<?= $post->getId() ?>">
            			<button class="btn btn-danger" type="submit">Supprimer</button>
					</form>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>