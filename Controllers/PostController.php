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

	public function showPost($params = [])
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

	public function showPostList()
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

	public function adminShowPostList()
	{
		$posts = $this->postManager->findAll();
		$dataPage = [
			"pageDescription" => "Page d'affichage de la liste des Articles",
			"pageTitle" => "Liste des Articles",
			"posts" => $posts,
			"view" => PATH_VIEW . "/admin/posts.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function adminShowPost($params = [])
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

	public function updatePost()
	{
		$this->postManager->updatePost($_POST['title'], $_POST['slug'], $_POST['content'], $_POST['description'], (int)$_POST['id']);
		// alerte success
		header('location: /admin/articles');
	}

	public function deletePost()
	{
		$this->postManager->deletePost((int)$_POST['id']);
		// alerte success
		header('location: /admin/articles');
	}

	public function adminAddPost()
	{
		$dataPage = [
			"pageDescription" => "Page d'ajout d'un article",
			"pageTitle" => "Ajout d'un article ",
			"view" => PATH_VIEW . "/admin/postAddForm.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function addPost()
	{
		$this->postManager->addPost($_POST['title'], $_POST['slug'], $_POST['content'], $_POST['description']);
		// alerte success
		header('location: /admin/articles');
	}
}