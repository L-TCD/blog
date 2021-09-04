<?php

namespace App\Controllers;

use App\Utils\Validator;
use App\Models\PostManager;
use App\Models\UserManager;
use App\Utils\SessionAlert;
use App\Models\CommentManager;
use App\Controllers\CoreController;


final class PostController extends CoreController
{
	private $postManager;
	private $commentManager;
	private $validator;
	private $sessionAlert;

	public function __construct()
	{
		$this->postManager = new PostManager();	
		$this->commentManager = new CommentManager();
		$this->userManager = new UserManager();
		$this->validator = new Validator;
		$this->sessionAlert = new SessionAlert;
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
			$this->sessionAlert->addAlert(sessionAlert::RED, "Fonctionnalités de gestion des articles réservées aux administrateurs");
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
			$this->sessionAlert->addAlert(sessionAlert::RED, "Fonctionnalités de gestion des articles réservées aux administrateurs");
			$this->redirect("main-home");
		}
	}

	public function update()
	{
		$title = filter_input(INPUT_POST, 'title',FILTER_SANITIZE_STRING);
		$content = filter_input(INPUT_POST, 'content',FILTER_SANITIZE_STRING);
		$description = filter_input(INPUT_POST, 'description',FILTER_SANITIZE_STRING);
		$author = filter_input(INPUT_POST, 'author',FILTER_SANITIZE_STRING);
		$postId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		if(
			$this->isAdmin() &&
			$this->validator->checkInputText($title, "du chapô", 3,  100) &&
			$this->validator->checkInputText($author, "du chapô", 3,  50) &&
			$this->validator->checkInputText($description, "du chapô", 3,  300) &&
			$this->validator->checkInputText($content, "du contenu", 3,  3000)
		){
			$this->postManager->update($title, $content, $description, $author, $postId);
			$this->sessionAlert->addAlert(sessionAlert::GREEN, "Mise à jour de l'article ". $postId ." effectuée.");
			$this->redirect("admin-show-post-list");
		} else {
			$this->sessionAlert->addAlert(sessionAlert::RED, "Mise à jour de l'article ". $postId ." abandonnée.");
			$this->redirect("admin-show-post-list");
		}
	}

	public function delete()
	{
		$postId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		if(
			$this->isAdmin() &&
			$this->postManager->find($postId)
		){
			$this->postManager->delete($postId);
			$this->sessionAlert->addAlert(sessionAlert::GREEN, "Suppression de l'article ". $postId ." effectuée.");
			$this->redirect("admin-show-post-list");
		} else {
			$this->sessionAlert->addAlert(sessionAlert::RED, "Suppression de l'article ". $postId ." abandonnée.");
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
			$this->sessionAlert->addAlert(sessionAlert::RED, "Fonctionnalités de gestion des articles réservées aux administrateurs");
			$this->redirect("main-home");
		}
	}

	public function insert()
	{
		$title = filter_input(INPUT_POST, 'title',FILTER_SANITIZE_STRING);
		$content = filter_input(INPUT_POST, 'content',FILTER_SANITIZE_STRING);
		$description = filter_input(INPUT_POST, 'description',FILTER_SANITIZE_STRING);
		$author = filter_input(INPUT_POST, 'author',FILTER_SANITIZE_STRING);
		if(
			$this->isAdmin() &&
			$this->validator->checkInputText($title, "du chapô", 3,  100) &&
			$this->validator->checkInputText($author, "du chapô", 3,  50) &&
			$this->validator->checkInputText($description, "du chapô", 3,  300) &&
			$this->validator->checkInputText($content, "du contenu", 3,  3000)
			){
			$this->postManager->insert($title, $content, $description, $author);
			$this->sessionAlert->addAlert(sessionAlert::GREEN, "Enregistrement de l'article effectué.");
			$this->redirect("admin-show-post-list");
		} else {
			$this->sessionAlert->addAlert(sessionAlert::RED, "Enregistrement de l'article abandonné.");
			$this->redirect("admin-show-post-list");
		}
	}
}