<h1 class="text-center mt-3">Connexion</h1>

<div class="col-md-9 mx-auto">
	<form action="/connexion/request" method="post">
		<div class="row g-3">
			<div class="col-12">
				<label for="username" class="form-label">Nom d'utilisateur :</label>
				<input type="text" class="form-control" id= "username" name="username" required>
			</div>
			<div class="col-12">
				<label for="password" class="form-label">Mot de passe :</label>
				<input type="password" class="form-control" id= "password" name="password" required>
			</div>
		</div>
		<hr class="my-4">
		<button type="submit" class="w-100 btn btn-success btn-lg">Valider</button>
	</form>
</div>

