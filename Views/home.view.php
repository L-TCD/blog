<h1>Accueil</h1>
<p>Paragraphe</p>

<?php

use Faker\Provider\Base;

if(!empty($_SESSION['auth'])) : ?>
	Connecté en tant que user n° <?= $_SESSION['auth'] ?>
<?php endif ?>
