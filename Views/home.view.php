<h1 class="text-center mt-3">Accueil</h1>
<?php

if(!empty($_SESSION['auth'])) : ?>
	Connecté en tant que user n° <?= $_SESSION['auth'] ?>
<?php endif ?>
