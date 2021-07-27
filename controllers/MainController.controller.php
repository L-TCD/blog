<?php
class MainController {
	public function accueil(){
		$page_description = "Description de la page d'accueil";
		$page_title = "Titre de la page d'accueil";
		ob_start();
		require_once("./views/accueil.view.php");
		$page_content = ob_get_clean();
		require_once("views/common/template.php");
	}
	public function page1(){
		$page_description = "Description de la page 1";
		$page_title = "Titre de la page 1";
		$page_content = "<h1>Page 1</h1>";
		ob_start();
		require_once("./views/page1.view.php");
		$page_content = ob_get_clean();
		require_once("views/common/template.php");
	}
	public function page2(){
		$page_description = "Description de la page 2";
		$page_title = "Titre de la page 2";
		ob_start();
		require_once("./views/page2.view.php");
		$page_content = ob_get_clean();
		require_once("views/common/template.php");
	}
	public function page3(){
		$page_description = "Description de la page 3";
		$page_title = "Titre de la page 3";
		ob_start();
		require_once("./views/page3.view.php");
		$page_content = ob_get_clean();
		require_once("views/common/template.php");
	}
	public function pageErreur($msg){
		$page_description = "Page de gestion d'erreur";
		$page_title = "Page d'erreur";
		ob_start();
		require_once("./views/erreur.view.php");
		$page_content = ob_get_clean();
		require_once("views/common/template.php");
	}




}