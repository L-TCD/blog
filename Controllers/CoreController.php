<?php

namespace App\Controllers;

abstract class CoreController
{
	protected $userManager;
	protected $sessionAuth;

	public function isLogged() : bool
	{
		if(!empty($this->sessionAuth->getFirst())){
			return true;
		}
		return false;
	}

	public function isAdmin() : bool
	{
		if($this->isLogged()){
			$user = $this->userManager->find($this->sessionAuth->getFirst());
			return $user->getAdmin();
		}
		return false;
	}

	public function redirect(string $name, array $params = [])
	{
		$router = $GLOBALS['router'];
		header('location: '. $router->generate($name, $params));
	}

	public function generatePage($data)
	{
		extract($data);
		ob_start();
		$router = $GLOBALS['router'];
		require_once $view;
		$pageContent = ob_get_clean();
		require_once $template;
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