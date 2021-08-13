<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/">Accueil</a>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="<?= $router->generate("show-post-list") ?>">show-post-list</a>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="<?= $router->generate("admin-show-post-list") ?>">admin-show-post-list</a>
        </li>
      </ul>
    </div>
  </div>
</nav>