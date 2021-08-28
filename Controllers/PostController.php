<?php

namespace App\Controllers;

use App\Utils\Alert;
use App\Models\PostManager;
use App\Models\UserManager;
use App\Models\CommentManager;
use App\Controllers\CoreController;


final class PostController extends CoreController
{
	private $postManager;
	private $commentManager;

	public function __construct()
	{
		$this->postManager = new PostManager();	
		$this->commentManager = new CommentManager();
		$this->userManager = new UserManager();	
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
		$admin = $this->isAdmin();
		$dataPage = [
			"params" => $params,
			"pageDescription" => "Page d'affichage de l'Article n°" . $params['id'],
			"pageTitle" => "Article " . $params['id'],
			"post" => $post,
			"comments" => $comments,
			"commentToUpdateId" => null,
			"admin" => $admin,
			"view" => PATH_VIEW . "/post.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function adminShowAll()
	{
		if($this->isAdmin()){
			$posts = $this->postManager->findAll("id DESC");
			$arrayPostsId = $this->commentManager->findAllPostIdWithCommentNull();
			$arrayPostsIdInt = [];
			foreach($arrayPostsId as $item){
				$arrayPostsIdInt[] = (int)$item["post_id"];
			}
	
			foreach($posts as $post){
				if(in_array($post->getId(),$arrayPostsIdInt)){
					$post->setCommentToValid(true);
				}
			}
			$dataPage = [
				"pageDescription" => "Page d'affichage de la liste des Articles",
				"pageTitle" => "Liste des Articles",
				"posts" => $posts,
				"view" => PATH_VIEW . "/admin/posts.view.php",
				"template" => PATH_VIEW . "/common/template.php"
			];
			$this->generatePage($dataPage);
		} else {
			$this->redirect("main-home");
		}

	}

	public function updateForm($params = [])
	{
		if($this->isAdmin()){
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

		} else {
			$this->redirect("main-home");
		}
	}

	public function update()
	{
		if($this->isAdmin()){
			$this->postManager->update($_POST['title'], $_POST['slug'], $_POST['content'], $_POST['description'], $_POST['author'], (int)$_POST['id']);
			Alert::addAlert(Alert::GREEN, "Mise à jour de l'article ". (int)$_POST['id'] ." effectuée.");
			$this->redirect("admin-show-post-list");
		} else {
			$this->redirect("main-home");
		}
	}

	public function delete()
	{
		if($this->isAdmin()){
			$this->postManager->delete((int)$_POST['id']);
			Alert::addAlert(Alert::GREEN, "Suppression de l'article ". (int)$_POST['id'] ." effectuée.");
			$this->redirect("admin-show-post-list");
		} else {
			$this->redirect("main-home");
		}
	}

	public function insertForm()
	{
		if($this->isAdmin()){
			$dataPage = [
				"pageDescription" => "Page d'ajout d'un article",
				"pageTitle" => "Ajout d'un article ",
				"view" => PATH_VIEW . "/admin/postAddForm.view.php",
				"template" => PATH_VIEW . "/common/template.php"
			];
			$this->generatePage($dataPage);

		} else {
			$this->redirect("main-home");
		}
	}

	public function insert()
	{
		if($this->isAdmin()){
			$this->postManager->insert($_POST['title'], $_POST['slug'], $_POST['content'], $_POST['description'], $_POST['author']);
			Alert::addAlert(Alert::GREEN, "Enregistrement de l'article ". (int)$_POST['id'] ." effectué.");
			$this->redirect("admin-show-post-list");
		} else {
			$this->redirect("main-home");
		}
	}
}