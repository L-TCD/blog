<h1 class="text-center mt-3">Accueil</h1>

<h2 class="text-center mt-5">Formulaire de contact</h2>
<form action="/contact" method="POST">
	<div class="row g-3">
		<div class="col-md-6">
			<label for="firstName" class="form-label">Prénom</label>
			<input type="text" class="form-control" name="firstName" id="firstName" placeholder="" value="<?php if(!empty($firstName)){echo $firstName;} ?>" required>
		</div>
		<div class="col-md-6">
			<label for="lastName" class="form-label">Nom</label>
			<input type="text" class="form-control" name="lastName" id="lastName" placeholder="" value="<?php if(!empty($lastName)){echo $lastName;} ?>" required>
		</div>
		<div class="col-12">
			<label for="email" class="form-label">Votre Email</label>
			<input type="email" class="form-control" name="email" id="email" placeholder="votre_email@exemple.com" value="<?php if(!empty($email)){echo $email;} ?>" required>
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

