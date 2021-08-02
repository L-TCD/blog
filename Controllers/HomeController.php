<?php
class HomeController extends CoreController
{
	public function home()
	{
		$dataPage = [
			"pageDescription" => "Description de la page d'accueil",
			"pageTitle" => "Titre de la page d'accueil",
			"view" => PATH_VIEW . "/home.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}
}