<?php

namespace App\Controllers;

use App\Models\CommentManager;
use App\Controllers\CoreController;
use App\Models\PostManager;

final class CommentController extends CoreController
{
	private $commentManager;
	private $postManager;

	public function __construct()
	{
		$this->commentManager = new CommentManager();
		$this->postManager = new PostManager();
	}

	public function insert()
	{
		$this->commentManager->insert((string)$_POST['content'], (int)$_POST['post_id']);
		header('location: /articles/'.(int)$_POST['post_id']);
	}
	
	public function delete()
	{
		$this->commentManager->delete((int)$_POST['id']);
		header('location: /articles/'.(int)$_POST['post_id']);
	}
	
	public function hide()
	{
		$this->commentManager->hide((int)$_POST['id']);
		header('location: /articles/'.(int)$_POST['post_id']);
	}
	
	public function show()
	{
		$this->commentManager->show((int)$_POST['id']);
		header('location: /articles/'.(int)$_POST['post_id']);
	}
	
	public function updateForm()
	{
		//copie de PostController->show()
		$post_id = (int)$_POST['post_id'];
		$commentToUpdateId = (int)$_POST['id']; // nouveau
		$post = $this->postManager->find($post_id);
		$comments = $this->commentManager->findByPostId($post_id);
		$dataPage = [
			"pageDescription" => "Page d'affichage de l'Article n°" . $post_id,
			"pageTitle" => "Article " . $post_id,
			"post" => $post,
			"comments" => $comments,
			"commentToUpdateId" => $commentToUpdateId, //nouveau
			"view" => PATH_VIEW . "/post.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);

	}

	public function update()
	{
		$this->commentManager->update((string)$_POST['content'], (int)$_POST['id']);
		header('location: /articles/'.(int)$_POST['post_id']);
	}

}