<?php

namespace App\Controllers;

abstract class CoreController
{
	protected $userManager;
	protected $sessionAuth;

	/**
	 * Test if the user is logged. 
	 */
	public function isLogged(): bool
	{
		if(!empty($this->sessionAuth->getFirst())){
			return true;
		}
		return false;
	}

	/**
	 *  Test if the user is administrtator. 
	 */
	public function isAdmin(): bool
	{
		if($this->isLogged()){
			$user = $this->userManager->find($this->sessionAuth->getFirst());
			return $user->getAdmin();
		}
		return false;
	}

	/**
	 * redirect with the router
	 * 
	 * @param string $name is the route
	 * @param array $params named parameters to the request url.
	 */
	public function redirect(string $name, array $params = []): void
	{
		$router = $GLOBALS['router'];
		header('location: '. $router->generate($name, $params));
	}

	/**
	 * show view from @param array $data
	 */
	public function generatePage(array $data): void
	{
		extract($data);
		ob_start();
		$router = $GLOBALS['router'];
		require_once $view;
		$pageContent = ob_get_clean();
		require_once $template;
	}

	/**
	 * show the error page with the message @param string $msg
	 */
	public function pageError(string $msg): void
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