<?php
class MainController {
	private function genererPage($data){
		extract($data);
		ob_start();
		require_once($view);
		$page_content = ob_get_clean();
		require_once($template);
	}

	public function accueil(){
		$data_page = [
			"page_description" => "Description de la page d'accueil",
			"page_title" => "Titre de la page d'accueil",
			"view" => "views/accueil.view.php",
			"template" => "views/common/template.php"
		];
		$this->genererPage($data_page);
	}
	public function page1(){
		$data_page = [
			"page_description" => "Description de la page 1",
			"page_title" => "Titre de la page 1",
			"view" => "views/page1.view.php",
			"template" => "views/common/template.php"
		];
		$this->genererPage($data_page);
	}
	public function page2(){
		$data_page = [
			"page_description" => "Description de la page 2",
			"page_title" => "Titre de la page 2",
			"view" => "views/page1.view.php",
			"template" => "views/common/template.php"
		];
		$this->genererPage($data_page);
	}
	public function page3(){
		$data_page = [
			"page_description" => "Description de la page 3",
			"page_title" => "Titre de la page 3",
			"view" => "views/page1.view.php",
			"template" => "views/common/template.php"
		];
		$this->genererPage($data_page);
	}
	public function pageErreur($msg){
		$data_page = [
			"page_description" => "Page de gestion d'erreur",
			"page_title" => "Page d'erreur",
			"msg" => $msg,
			"view" => "views/erreur.view.php",
			"template" => "views/common/template.php"
		];
		$this->genererPage($data_page);
	}




}