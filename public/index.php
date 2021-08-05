<?php
require_once '../vendor/autoload.php';
require_once '../Controllers/CoreController.php';
require_once '../Controllers/HomeController.php';
require_once '../Controllers/PostController.php';
require_once '../Models/CoreModel.php';
require_once '../Models/PostManager.php';
require_once '../Models/Post.php';
define('PATH_VIEW', dirname(__DIR__) . '/Views');

try {

	$router = new AltoRouter();

	$router->map(
		'GET',
		'/',
		['controller' => 'HomeController', 'method' => 'home'],
		'main-home'
	);
	$router->map(
		'GET',
		'/articles/[i:id]',
		['controller' => 'PostController', 'method' => 'show'],
		'posts-show'
	);
	$router->map(
		'GET',
		'/articles',
		['controller' => 'PostController', 'method' => 'showPosts'],
		'posts-list'
	);
	
	$match = $router->match();

	if ($match) {
		$controller = new $match['target']['controller'];
		$method = $match['target']['method'];
		$params = $match['params'];
		$controller->$method($params);
	} else {
		$controller = new CoreController();
		$controller->pageError("La page n'existe pas ! (404)");
	}
} catch (Exception $e) {
	$controller = new CoreController();
	$controller->pageError($e->getMessage());
}