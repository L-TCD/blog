<h1>Connection</h1>

<form action="/connexion/request" method="post">
	<div class="form-group">
		<label for="username" class="form-label">Nom d'utilisateur :</label>
		<input type="text" class="form-control" id= "username" name="username" required>
	</div>
	<div class="form-group">
		<label for="password" class="form-label">Mot de passe :</label>
		<input type="password" class="form-control" id= "password" name="password" required>
	</div>
	<button type="submit" class="btn btn-success my-3">Valider</button>
</form>