<?php

namespace App\Controllers;

use App\Models\CommentManager;
use App\Controllers\CoreController;

final class CommentController extends CoreController
{
	private $commentManager;

	public function __construct()
	{
		$this->commentManager = new CommentManager();
	}

	public function insert()
	{
		$this->commentManager->insert($_POST['content'], $_POST['post_id']);
		// alert success
		header('location: /articles/'.$_POST['post_id']);
	}
	public function delete()
	{
		$this->commentManager->delete($_POST['id']);
		// alert success
		header('location: /articles/'.$_POST['post_id']);
	}

}