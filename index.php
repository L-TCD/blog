<?php
require_once("./controllers/MainController.controller.php");
$mainController = new MainController();

try{
	if(empty($_GET['page'])){
		$page = "home";
	} else {
		$url = explode("/", filter_var($_GET['page'],FILTER_SANITIZE_URL));
		$page = $url[0];
	}
	switch($page){
		case "home" : 
			$mainController->home();
		break;
		case "page1" : 
			$mainController->page1();
		break;
		case "page2" : 
			$mainController->page2();
		break;
		case "page3" : 
			$mainController->page3();
		break;
		default : throw new Exception("La page n'existe pas.");
	}
} catch (Exception $e){
	$mainController->pageError($e->getMessage());
}