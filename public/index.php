<?php
require_once '../vendor/autoload.php';

use App\Controllers\CoreController;

define('PATH_VIEW', dirname(__DIR__) . '/Views');

try {

	$router = new AltoRouter();

	$router->map(
		'GET',
		'/',
		['controller' => 'App\Controllers\HomeController', 'method' => 'home'],
		'main-home'
	);
	$router->map(
		'GET',
		'/articles/[i:id]',
		['controller' => 'App\Controllers\PostController', 'method' => 'showPost'],
		'show-post'
	);
	$router->map(
		'GET',
		'/articles',
		['controller' => 'App\Controllers\PostController', 'method' => 'showPostList'],
		'show-post-list'
	);
	
	//Admin
	$router->map(
		'GET',
		'/admin/articles',
		['controller' => 'App\Controllers\PostController', 'method' => 'adminShowPostList'],
		'admin-show-post-list'
	);
	$router->map(
		'GET|POST',
		'/admin/articles/[i:id]',
		['controller' => 'App\Controllers\PostController', 'method' => 'adminShowPost'],
		'admin-show-post'
	);
	$router->map(
		'POST',
		'/admin/articles/edition',
		['controller' => 'App\Controllers\PostController', 'method' => 'updatePost'],
		'admin-update-post'
	);
	$router->map(
		'POST',
		'/admin/articles/suppression',
		['controller' => 'App\Controllers\PostController', 'method' => 'deletePost'],
		'admin-delete-post'
	);
	$router->map(
		'POST',
		'/admin/articles/formulaireAjout',
		['controller' => 'App\Controllers\PostController', 'method' => 'adminAddPost'],
		'admin-add-post-form'
	);
	$router->map(
		'POST',
		'/admin/articles/ajout',
		['controller' => 'App\Controllers\PostController', 'method' => 'addPost'],
		'admin-add-post'
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