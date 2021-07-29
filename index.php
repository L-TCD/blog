<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/CoreController.php';
require __DIR__ . '/controllers/PostController.php';
require_once("./controllers/MainController.controller.php");

try {

	$router = new AltoRouter();

	// Page d'accueil
	$router->map(
		'GET',
		'/accueil',
		['controller' => 'MainController', 'method' => 'accueil'],
		'main-home'
	);


	// Page 1
	$router->map(
		'GET',
		'/page1',
		['controller' => 'MainController', 'method' => 'page1'],
		'main-page1'
	);

	// Page article
	$router->map(
		'GET',
		'/post/[i:postId]',
		['controller' => 'PostController', 'method' => 'show'],
		'post-show'
	);

	$match = $router->match();

	// Si l'URL saisie dans le navigateur correspond à l'une de nos routes...
	if ($match) {
		// alors on affiche la page demandée
		$controller = new $match['target']['controller']; // Ex : Si url = /post/2, alors $controller = new PostController
		$method = $match['target']['method'];  // Ex : Si url = /post/2, alors $method = show

		// Ex : Si url = /post/2 ==> $controller->show($match['params']), avec $match['params'] = ['postId' => 2]
		$params = $match['params'];
		$controller->$method($params);
	} else {
		// Sinon on affiche une page d'erreur
		$mainController = new MainController();
		$mainController->page404();
	}
} catch (Exception $e) {
	$mainController->pageErreur($e->getMessage());
}
