<?php
session_start();
require_once '../vendor/autoload.php';

use App\Controllers\HomeController;

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
		'/articles',
		['controller' => 'App\Controllers\PostController', 'method' => 'showAll'],
		'show-post-list'
	);

	$router->map(
		'GET|POST',
		'/articles/[i:id]',
		['controller' => 'App\Controllers\PostController', 'method' => 'show'],
		'show-post'
	);
	$router->map(
		'POST',
		'/articles/comment',
		['controller' => 'App\Controllers\CommentController', 'method' => 'insert'],
		'insert-comment'
	);
	$router->map(
		'POST',
		'/comment/delete',
		['controller' => 'App\Controllers\CommentController', 'method' => 'delete'],
		'delete-comment'
	);
	$router->map(
		'POST',
		'/comment/hide',
		['controller' => 'App\Controllers\CommentController', 'method' => 'hide'],
		'hide-comment'
	);
	$router->map(
		'POST',
		'/comment/show',
		['controller' => 'App\Controllers\CommentController', 'method' => 'show'],
		'show-comment'
	);
	$router->map(
		'POST',
		'/comment/updateForm',
		['controller' => 'App\Controllers\CommentController', 'method' => 'updateForm'],
		'updateForm-comment'
	);
	$router->map(
		'POST',
		'/comment/update',
		['controller' => 'App\Controllers\CommentController', 'method' => 'update'],
		'update-comment'
	);
	
	
	//Admin
	$router->map(
		'GET',
		'/admin/articles',
		['controller' => 'App\Controllers\PostController', 'method' => 'adminShowAll'],
		'admin-show-post-list'
	);
	$router->map(
		'GET|POST',
		'/admin/articles/[i:id]',
		['controller' => 'App\Controllers\PostController', 'method' => 'updateForm'],
		'admin-show-post'
	);
	$router->map(
		'POST',
		'/admin/articles/edition',
		['controller' => 'App\Controllers\PostController', 'method' => 'update'],
		'admin-update-post'
	);
	$router->map(
		'POST',
		'/admin/articles/suppression',
		['controller' => 'App\Controllers\PostController', 'method' => 'delete'],
		'admin-delete-post'
	);
	$router->map(
		'POST',
		'/admin/articles/formulaireAjout',
		['controller' => 'App\Controllers\PostController', 'method' => 'insertForm'],
		'admin-add-post-form'
	);
	$router->map(
		'POST',
		'/admin/articles/ajout',
		['controller' => 'App\Controllers\PostController', 'method' => 'insert'],
		'admin-add-post'
	);
	
	$match = $router->match();

	if ($match) {
		$controller = new $match['target']['controller'];
		$method = $match['target']['method'];
		$params = $match['params'];
		$controller->$method($params);
	} else {
		$controller = new HomeController();
		$controller->pageError("La page n'existe pas ! (404)");
	}
} catch (Exception $e) {
	$controller = new HomeController();
	$controller->pageError($e->getMessage());
}