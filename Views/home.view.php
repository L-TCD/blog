<h1 class="text-center mt-3">Accueil</h1>

<?php if(!empty($_SESSION['auth'])) : ?>
	Connecté en tant que user n° <?= $_SESSION['auth'] ?>
<?php endif ?>



<div class="col-md-9 mx-auto">
	<h2 class="text-center mt-5">Formulaire de contact</h2>
	<form action="/contact" method="POST">
		<div class="row g-3">
			<div class="col-12">
				<label for="email" class="form-label">Votre Email</label>
				<input type="email" class="form-control" name="email" id="email" placeholder="votreEmail@exemple.com" value="<?php if(!empty($email)){echo $email;} ?>" required>
			</div>
			<div class="col-12">
				<label for="object" class="form-label">Objet</label>
				<input type="text" class="form-control" name="object" id="object" placeholder="" value="<?php if(!empty($object)){echo $object;} ?>" required>
			</div>
			<div class="col-12">
				<label for="message" class="form-label">Message</label>
				<textarea class="form-control" name="message" id="message" placeholder="" rows="3" required><?php if(!empty($message)){echo $message;} ?></textarea>
			</div>
		</div>
		<hr class="my-4">
		<button class="w-100 btn btn-primary btn-lg" type="submit">Envoyer</button>
	</form>
</div>

