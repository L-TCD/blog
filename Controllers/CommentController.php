<?php

namespace App\Controllers;

use App\Utils\Alert;
use App\Models\PostManager;
use App\Models\UserManager;
use App\Models\CommentManager;
use App\Controllers\CoreController;

final class CommentController extends CoreController
{
	private $commentManager;
	private $postManager;

	public function __construct()
	{
		$this->commentManager = new CommentManager();
		$this->postManager = new PostManager();
		$this->userManager = new UserManager();	
	}

	public function insert()
	{
		if($this->isLogged()){
			$this->commentManager->insert((string)$_POST['content'], (int)$_POST['post_id']);
			Alert::addAlert(Alert::GREEN, 'Enregistrement du commentaire effectué.');
			$this->redirect("show-post", ["id" => $_POST['post_id']]);
		} else {
			$this->redirect("main-home");
		}
	}
	
	public function delete()
	{
		if($this->isAdmin()){
			$this->commentManager->delete((int)$_POST['id']);
			Alert::addAlert(Alert::GREEN, 'Suppression du commentaire effectuée.');
			$this->redirect("show-post", ["id" => $_POST['post_id']]);
		} else {
			$this->redirect("main-home");
		}
	}
	
	public function hide()
	{
		if($this->isAdmin()){
			$this->commentManager->hide((int)$_POST['id']);
			$this->redirect("show-post", ["id" => $_POST['post_id']]);
		} else {
			$this->redirect("main-home");
		}
	}
	
	public function show()
	{
		if($this->isAdmin()){
			$this->commentManager->show((int)$_POST['id']);
			$this->redirect("show-post", ["id" => $_POST['post_id']]);
		} else {
			$this->redirect("main-home");
		}
	}
	
	public function updateForm()
	{
		if($this->isAdmin()){
			$post_id = (int)$_POST['post_id'];
			$commentToUpdateId = (int)$_POST['id'];
			$post = $this->postManager->find($post_id);
			$comments = $this->commentManager->findByPostId($post_id);
			$dataPage = [
				"pageDescription" => "Page d'affichage de l'Article n°" . $post_id,
				"pageTitle" => "Article " . $post_id,
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
		if($this->isAdmin()){
			$this->commentManager->update((string)$_POST['content'], (int)$_POST['id']);
			Alert::addAlert(Alert::GREEN, 'Modification du commentaire effectuée.');
		    $this->redirect("show-post", ["id" => (int)$_POST['post_id']]);
		} else {
			$this->redirect("main-home");
		}
	}

}