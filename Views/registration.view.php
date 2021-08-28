<h1>Inscription</h1>

<form action="/inscription/request" method="post">
	<div class="form-group">
		<label for="username" class="form-label">Nom d'utilisateur :</label>
		<input type="text" class="form-control" id= "username" name="username" required>
	</div>
	<div class="form-group">
		<label for="email" class="form-label">Email :</label>
		<input type="email" class="form-control" id= "email" name="email" required>
	</div>
	<div class="form-group">
		<label for="password" class="form-label">Mot de passe :</label>
		<input type="password" class="form-control" id= "password" name="password" required>
	</div>
	<button type="submit" class="btn btn-success my-3">Valider</button>
</form>