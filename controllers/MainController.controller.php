<?php
class MainController extends CoreController
{
	public function accueil()
	{
		$data_page = [
			"page_description" => "Description de la page d'accueil",
			"page_title" => "Titre de la page d'accueil",
			"view" => "views/accueil.view.php",
			"template" => "views/common/template.php"
		];
		$this->genererPage($data_page);
	}

	public function page1()
	{
		$data_page = [
			"page_description" => "Description de la page 1",
			"page_title" => "Titre de la page 1",
			"view" => "views/page1.view.php",
			"template" => "views/common/template.php"
		];
		$this->genererPage($data_page);
	}
}
