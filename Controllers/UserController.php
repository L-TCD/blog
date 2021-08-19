<?php

namespace App\Controllers;

use App\Models\UserManager;
use App\Controllers\CoreController;
use App\Models\User;

final class UserController extends CoreController
{
	private $userManager;

	public function __construct()
	{
		$this->userManager = new UserManager();	
	}

	public function showAll()
	{
		$users = $this->userManager->findAll("");
		$dataPage = [
			"pageDescription" => "Page d'affichage de la liste des Utilisateurs",
			"pageTitle" => "Liste des Utilisateurs",
			"users" => $users,
			"userToUpdateId" => NULL,
			"view" => PATH_VIEW . "/admin/users.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function adminUpdateForm($params = [])
	{
		$userToUpdateId = $params['id'];
		$users = $this->userManager->findAll("");
		$dataPage = [
			"pageDescription" => "Page d'affichage de la liste des Utilisateurs",
			"pageTitle" => "Modification utilisateur ".$params['id'],
			"users" => $users,
			"userToUpdateId" => $userToUpdateId,
			"view" => PATH_VIEW . "/admin/users.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function update()
	{
		$this->userManager->update(
			(string)$_POST['email'],
			(string)$_POST['username'],
			(bool)$_POST['admin'],
			(int)$_POST['id']
		);
		$_SESSION['alert'] = [
			"type" => "alert-success",
			"text" => "Modification de l'utilisateur effectuée."
		];
		header('location: /admin/utilisateurs');
	}

	public function delete()
	{
		$this->userManager->delete((int)$_POST['id']);
		$_SESSION['alert'] = [
			"type" => "alert-success",
			"text" => "Suppression de l'utilisateur effectuée."
		];
		header('location: /admin/utilisateurs');
	}

	public function insertForm()
	{
		$dataPage = [
			"pageDescription" => "Page d'inscription",
			"pageTitle" => "", "Inscription",
			"view" => PATH_VIEW . "/registration.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function insert()
	{
		// $this->userManager->insert();
	}

	public function logInForm()
	{
		$dataPage = [
			"pageDescription" => "Page de connexion",
			"pageTitle" => "", "Connexion",
			"view" => PATH_VIEW . "/login.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function logIn()
	{
		if(!empty($_POST['username']) && !empty($_POST['password'])){
			$user = $this->userManager->findByUsername((string)$_POST['username']);
			if($user === false) {
				$_SESSION['alert'] = [
					"type" => "alert-danger",
					"text" => "Identifiant ou mot de passe incorrect."
				];
				header('location: /connexion');
			}

			if(password_verify((string)$_POST['password'],$user->getPassword())){
				$_SESSION['auth'] = $user->getId();
				$_SESSION['alert'] = [
					"type" => "alert-success",
					"text" => "Connexion effectuée."
				];
				header('location: /');
			} else {
				$_SESSION['alert'] = [
					"type" => "alert-danger",
					"text" => "Identifiant ou mot de passe incorrect."
				];
				header('location: /connexion');
			}


		}

	}
}