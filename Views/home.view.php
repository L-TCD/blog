<h1 class="text-center mt-3">Bienvenue !</h1>
<hr>
<div class="d-flex row">
	<div class="col-12 col-md-6 text-center my-auto">
		<img src="./src/images/logo.jpg" class="img-fluid px-auto" width="400" height="400" alt="image représentant un joli petit chien">
	</div>
	<div class="col-12 col-md-6 text-center my-auto">
		<br>
		<p>Je m'appelle Cookie et vous serai ravi de vous servir de guide.</p>
		<p>Aventurier en herbe, je raconte ma (belle) vie de chien au travers des articles de ce blog.</p>
		<p>Bonne lecture !</p>
		<br>
		<div class="d-flex justify-content-around">
			<a href="./src/pdf/CV.pdf" target="_blank"><button class="btn btn-outline-dark"><i class="bi bi-file-person-fill"></i> Mon CV</button></a>
			<a href="https://github.com/L-TCD/blog" class="mx-1" target="_blank"><button class="btn btn-outline-dark"><i class="bi bi-github"></i> GitHub</button></a>
			<a href="https://fr.linkedin.com/" target="_blank"><button class="btn btn-outline-dark"><i class="bi bi-linkedin"></i> Linkedin</button></a>
		</div>
	</div>
</div>




<h2 class="text-center mt-5">Me contacter</h2>
<hr>
<form action="/contact" method="POST">
	<div class="row g-3">
		<div class="col-md-6">
			<label for="firstName" class="form-label">Votre Prénom</label>
			<input type="text" class="form-control" name="firstName" id="firstName" placeholder="" value="<?php if(!empty($firstName)){echo $firstName;} ?>" required>
		</div>
		<div class="col-md-6">
			<label for="lastName" class="form-label">Votre Nom</label>
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
	<button class="w-100 btn btn-primary btn-lg my-4" type="submit">Envoyer</button>
</form>

