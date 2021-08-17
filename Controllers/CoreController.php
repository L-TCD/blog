<?php

namespace App\Controllers;

abstract class CoreController
{
	protected function generatePage($data)
	{
		extract($data);
		ob_start();
		$router = $GLOBALS['router'];
		require_once($view);
		$pageContent = ob_get_clean();
		require_once($template);
	}

	public function pageError($msg)
	{
		$dataPage = [
			"pageDescription" => "Page de gestion d'erreur",
			"pageTitle" => "Page d'erreur",
			"msg" => $msg,
			"view" => PATH_VIEW . "/error.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}
}