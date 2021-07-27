<?php
try{


	if(empty($_GET['page'])){
		$page = "accueil";
	} else {
		$url = explode("/", filter_var($_GET['page'],FILTER_SANITIZE_URL));
		$page = $url[0];
	}

	switch($page){
		case "accueil" : 
			$page_description = "Description de la page d'accueil";
			$page_title = "Titre de la page d'accueil";
			$page_content = "<h1>Accueil</h1>";
		break;
		case "page1" : 
			$page_description = "Description de la page 1";
			$page_title = "Titre de la page 1";
			$page_content = "<h1>Page 1</h1>";
		break;
		case "page2" : 
			$page_description = "Description de la page 2";
			$page_title = "Titre de la page 2";
			$page_content = "<h1>Page 2</h1>";
		break;
		case "page3" : 
			$page_description = "Description de la page 3";
			$page_title = "Titre de la page 3";
			$page_content = "<h1>Page 3</h1>";
		break;
		default : throw new Exception("La page n'existe pas.");
	}
} catch (Exception $e){
	$page_description = "Page de gestion d'erreur";
	$page_title = "Page d'erreur";
	$page_content = $e->getMessage();
}

require_once("views/common/template.php");

//index.php?page=accueil
//index.php?page=page1
//index.php?page=contact