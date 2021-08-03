<?php
require_once '../Models/PostManager.php';

class PostController extends CoreController
{
	private $postManager;

	public function __construct()
	{
		$this->postManager = new PostManager();	
	}

	public function show($params = [])
	{
		$dataPage = [
			"params" => $params,
			"pageDescription" => "Page d'affichage de l'Article n°" . $params['postId'],
			"pageTitle" => "Article " . $params['postId'],
			"view" => PATH_VIEW . "/post.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function showPosts()
	{
		$posts = $this->postManager->findAll();
		$dataPage = [
			"pageDescription" => "Page d'affichage de la liste des Articles",
			"pageTitle" => "Liste des Articles",
			"posts" => $posts,
			"view" => PATH_VIEW . "/posts.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}
}