<?php
class PostController extends CoreController
{
	public function show($params = [])
	{
		$dataPage = [
			"params" => $params,
			"pageDescription" => "Page d'affichage de l'article n°" . $params['postId'],
			"pageTitle" => "Article " . $params['postId'],
			"view" => PATH_VIEW . "/post.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}
}