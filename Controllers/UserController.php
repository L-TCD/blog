<?php

namespace App\Controllers;

use App\Models\UserManager;
use App\Controllers\CoreController;
use App\Utils\Alert;
use \DateTime;

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
			(bool)$_POST['active'],
			(int)$_POST['id']
		);
		$_SESSION['alert'][] = [
			"type" => "alert-success",
			"text" => "Modification de l'utilisateur effectuée."
		];
		header('location: /admin/utilisateurs');
	}

	public function delete()
	{
		$this->userManager->delete((int)$_POST['id']);
		$_SESSION['alert'][] = [
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
				$_SESSION['alert'][] = [
					"type" => "alert-danger",
					"text" => "Identifiant ou mot de passe incorrect."
				];
				header('location: /connexion');
			}

			if(password_verify((string)$_POST['password'],$user->getPassword())){
				$_SESSION['auth'] = $user->getId();
				$_SESSION['alert'][] = [
					"type" => "alert-success",
					"text" => "Connexion effectuée."
				];
				header('location: /');
			} else {
				$_SESSION['alert'][] = [
					"type" => "alert-danger",
					"text" => "Identifiant ou mot de passe incorrect."
				];
				header('location: /connexion');
			}


		}

	}

	public function insert()
	{	
		$email = (string)$_POST['email'];
		$userWanted2 = $this->userManager->findByEmail($email);
		if($userWanted2 && $email === $userWanted2->getEmail()){
			$_SESSION['alert'][] = [
				"type" => "alert-danger",
				"text" => "Un compte existe déjà pour cet email."
			];
		};

		$username = (string)$_POST['username'];
		$userWanted = $this->userManager->findByUsername($username);
		if($userWanted && $username === $userWanted->getUsername()){
			$_SESSION['alert'][] = [
				"type" => "alert-danger",
				"text" => "Nom d'utilisateur déjà pris."
			];
		};

		$password = (string)$_POST['password'];
		if(strlen($password) < 4 || strlen($password) > 10){
			$_SESSION['alert'][] = [
				"type" => "alert-danger",
				"text" => "La longueur du mot de passe doit être comprise entre 4 et 10 caractères."
			];
		};

		if(!empty($_SESSION['alert'])){
			$this->redirect('user-insert-form');
		} else {
			$token = (string)($username.time());
			$tokenCrypt = crypt($token, 'rl');
			
			$userId = $this->userManager->insert($email, $username, $password, $tokenCrypt);
			$subject = 'Lien de validation';

			$message = '<h1>Bienvenue !</h1>';
			$message .= '<p>Pour valider votre inscription sur le blog, <a href="http://localhost:8000/confirm/'.$userId.'/'.$tokenCrypt.'">Cliquez ici</a>.</p>';
			$message .= '<p> A très vite !</p><br>';

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			if(mail($email, $subject, $message, $headers)){
				$_SESSION['alert'][] = [
					"type" => "alert-success",
					"text" => "Vous allez recevoir un email automatique avec un lien pour valider votre inscription (valable seulement 24h)."
				];
			} else{
				$_SESSION['alert'][] = [
					"type" => "alert-danger",
					"text" => "Problème d'envoi d'email."
				];
			}
			$this->redirect('main-home');
		}
	}

	public function confirm($params = [])
	{	
		$userId = (int)$params['userId'];
		$tokenCrypt = $params['token'];
		$user = $this->userManager->find($userId);
		if($user !== false) {
			$token = $user->getToken();
			$now = new DateTime("now");
			$interval = $user->getTokenDate()->diff($now);
			$days = $interval->format('%a');
		}

		if($user === false){
			Alert::addAlert(Alert::RED, 'Utilisateur inconnu.');

		} elseif($user->getActive() === true){
			Alert::addAlert(Alert::RED, 'Compte utilisateur déjà validé');

		} elseif($user->getActive() === false && $token == $tokenCrypt && $days >= 1){
			$this->userManager->delete($userId);
			Alert::addAlert(Alert::RED, "Le lien de validation n'est plus valide, il faut recommencer l'inscription");

		} elseif($token == $tokenCrypt && $days < 1){ 
			$this->userManager->setActive(true, $userId);
			$_SESSION['auth'] = $userId;
			Alert::addAlert(Alert::GREEN, 'Validation compte utilisateur effectuée');

		} else {
			Alert::addAlert(Alert::RED, 'Lien de validation incorrect');
		}

		$this->redirect("main-home");
	}


}