<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="/">Accueil</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= $router->generate("show-post-list") ?>">Articles</a>
				</li>
			</ul>
			<?php if(!empty($_SESSION['adminNav']) && $_SESSION['adminNav'] == true): ?>
				<ul class="navbar-nav mx-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="<?= $router->generate("admin-show-post-list") ?>">Gestion articles</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= $router->generate("admin-users") ?>">Gestion utilisateurs</a>
					</li>
				</ul>
			<?php endif ?>
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
				<?php if(empty($_SESSION['auth'])): ?>
					<li class="nav-item">
						<a class="nav-link" href="<?= $router->generate("log-in-form") ?>">Connexion</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= $router->generate("user-insert-form") ?>">Inscription</a>
					</li>
				<?php else: ?>
					<li class="nav-item">
						<form action="<?= $router->generate("log-out") ?>" method="post" style="display:inline">
							<button type="submit" class="nav-link" style="background:transparent; border:none;">Deconnexion</button>
						</form>
					</li>
				<?php endif ?>
			</ul>
		</div>
	</div>
</nav>