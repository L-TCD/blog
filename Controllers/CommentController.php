<?php

namespace App\Controllers;

use App\Utils\SessionAuth;
use App\Models\PostManager;
use App\Models\UserManager;
use App\Utils\SessionAlert;
use App\Models\CommentManager;
use App\Controllers\CoreController;

final class CommentController extends CoreController
{
	private $commentManager;
	private $postManager;
	private $sessionAlert;

	public function __construct()
	{
		$this->commentManager = new CommentManager();
		$this->postManager = new PostManager();
		$this->userManager = new UserManager();	
		$this->sessionAlert = new SessionAlert;
		$this->sessionAuth = new SessionAuth;
	}

	public function insert()
	{
		$postId = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
		$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
		$userId = filter_var($this->sessionAuth->getFirst(),FILTER_VALIDATE_INT);

		if($this->isLogged()){
			$this->commentManager->insert($content, $userId, $postId);
			$this->sessionAlert->addAlert(sessionAlert::GREEN, 'Enregistrement du commentaire effectué. En attente de validation par un administrateur.');
			$this->redirect("show-post", ["id" => $postId]);
		} else {
			$this->redirect("main-home");
		}
	}
	
	public function delete()
	{
		$commentId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		$postId = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
		if($this->isAdmin()){
			$this->commentManager->delete($commentId);
			$this->sessionAlert->addAlert(sessionAlert::GREEN, 'Suppression du commentaire effectuée.');
			$this->redirect("show-post", ["id" => $postId]);
		} else {
			$this->redirect("main-home");
		}
	}
	
	public function hide()
	{
		$commentId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		$postId = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
		if($this->isAdmin()){
			$this->commentManager->hide($commentId);
			$this->redirect("show-post", ["id" => $postId]);
		} else {
			$this->redirect("main-home");
		}
	}
	
	public function show()
	{
		$commentId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		$postId = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
		if($this->isAdmin()){
			$this->commentManager->show($commentId);
			$this->redirect("show-post", ["id" => $postId]);
		} else {
			$this->redirect("main-home");
		}
	}
	
	public function updateForm()
	{
		if($this->isAdmin()){
			$postId = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
			$commentToUpdateId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
			$post = $this->postManager->find($postId);
			$comments = $this->commentManager->findByPostId($postId);
			$dataPage = [
				"pageDescription" => "Page d'affichage de l'Article n°" . $postId,
				"pageTitle" => "Article " . $postId,
				"post" => $post,
				"comments" => $comments,
				"commentToUpdateId" => $commentToUpdateId,
				"admin" => true,
				"view" => PATH_VIEW . "/post.view.php",
				"template" => PATH_VIEW . "/common/template.php"
			];
			$this->generatePage($dataPage);
		} else {
			$this->redirect("main-home");
		}
	}

	public function update()
	{
		$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
		$commentId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		$postId = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
		if($this->isAdmin()){
			$this->commentManager->update($content, $commentId);
			$this->sessionAlert->addAlert(sessionAlert::GREEN, 'Modification du commentaire effectuée.');
		    $this->redirect("show-post", ["id" => $postId]);
		} else {
			$this->redirect("main-home");
		}
	}

}