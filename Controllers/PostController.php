<?php
namespace App\Controllers;

use App\Controllers\CoreController;
use App\Models\CommentManager;
use App\Models\PostManager;

class PostController extends CoreController
{
	private $postManager;
	private $commentManager;

	public function __construct()
	{
		$this->postManager = new PostManager();	
		$this->commentManager = new CommentManager();
	}

	public function show($params = [])
	{
		$post = $this->postManager->find($params['id']);
		$comments = $this->commentManager->findAllByPostId($params['id']);
		$dataPage = [
			"params" => $params,
			"pageDescription" => "Page d'affichage de l'Article n°" . $params['id'],
			"pageTitle" => "Article " . $params['id'],
			"post" => $post,
			"comments" => $comments,
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