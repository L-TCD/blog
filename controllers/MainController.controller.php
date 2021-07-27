<?php
class MainController {
	public function accueil(){
		$page_description = "Description de la page d'accueil";
		$page_title = "Titre de la page d'accueil";
		$page_content = "<h1>Accueil</h1>";
		require_once("views/common/template.php");
	}
	public function page1(){
		$page_description = "Description de la page 1";
		$page_title = "Titre de la page 1";
		$page_content = "<h1>Page 1</h1>";
		require_once("views/common/template.php");
	}
	public function page2(){
		$page_description = "Description de la page 2";
		$page_title = "Titre de la page 2";
		$page_content = "<h1>Page 2</h1>";
		require_once("views/common/template.php");
	}
	public function page3(){
		$page_description = "Description de la page 3";
		$page_title = "Titre de la page 3";
		$page_content = "<h1>Page 3</h1>";
		require_once("views/common/template.php");
	}
	public function pageErreur($msg){
		$page_description = "Page de gestion d'erreur";
		$page_title = "Page d'erreur";
		$page_content = $msg;
		require_once("views/common/template.php");
	}




}