<h1 class="text-center mt-3">Page d'ajout d'article</h1>

<form action="/admin/articles/ajout" method="POST">
	<div class="form-group">
		<label for="title" class="form-label">Titre :</label>
		<input type="text" class="form-control" id="title" name="title">
	</div>
	<div class="form-group">
		<label for="author" class="form-label">Auteur :</label>
		<input type="text" class="form-control" id="author" name="author">
	</div>
	<div class="form-group">
		<label for="description" class="form-label">Chapô :</label>
		<textarea name="description" id="description" class="form-control"></textarea>
	</div>
	<div class="form-group">
		<label for="content" class="form-label">Contenu :</label>
		<textarea name="content" id="content" class="form-control"></textarea>
	</div>
	<button type="submit" class="btn btn-success my-3">Valider</button>
</form>