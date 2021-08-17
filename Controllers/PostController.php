<?php

namespace App\Controllers;

use App\Controllers\CoreController;
use App\Models\CommentManager;
use App\Models\PostManager;

final class PostController extends CoreController
{
	private $postManager;
	private $commentManager;

	public function __construct()
	{
		$this->postManager = new PostManager();	
		$this->commentManager = new CommentManager();
	}

	public function showAll()
	{
		$posts = $this->postManager->findAll("id DESC");
		$dataPage = [
			"pageDescription" => "Page d'affichage de la liste des Articles",
			"pageTitle" => "Liste des Articles",
			"posts" => $posts,
			"view" => PATH_VIEW . "/posts.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function show($params = [])
	{
		$post = $this->postManager->find($params['id']);
		$comments = $this->commentManager->findByPostId($params['id']);
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

	public function adminShowAll()
	{
		$posts = $this->postManager->findAll("id DESC");
		$dataPage = [
			"pageDescription" => "Page d'affichage de la liste des Articles",
			"pageTitle" => "Liste des Articles",
			"posts" => $posts,
			"view" => PATH_VIEW . "/admin/posts.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function updateForm($params = [])
	{
		$post = $this->postManager->find($params['id']);
		$dataPage = [
			"params" => $params,
			"pageDescription" => "Page d'affichage de l'Article n°" . $params['id'],
			"pageTitle" => "Edition de l'article " . $params['id'],
			"post" => $post,
			"view" => PATH_VIEW . "/admin/post.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function update()
	{
		$this->postManager->update($_POST['title'], $_POST['slug'], $_POST['content'], $_POST['description'], $_POST['author'], (int)$_POST['id']);
		// alerte success
		header('location: /admin/articles');
	}

	public function delete()
	{
		$this->postManager->delete((int)$_POST['id']);
		// alerte success
		header('location: /admin/articles');
	}

	public function insertForm()
	{
		$dataPage = [
			"pageDescription" => "Page d'ajout d'un article",
			"pageTitle" => "Ajout d'un article ",
			"view" => PATH_VIEW . "/admin/postAddForm.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function insert()
	{
		$this->postManager->insert($_POST['title'], $_POST['slug'], $_POST['content'], $_POST['description'], $_POST['author']);
		// alerte success
		header('location: /admin/articles');
	}
}