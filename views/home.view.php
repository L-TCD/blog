<h1>Accueil</h1>
<p>Paragraphe</p>

<?php if($_SESSION['auth']) : ?>
	Connecté en tant que user n° <?= $_SESSION['auth'] ?>
<?php endif ?>