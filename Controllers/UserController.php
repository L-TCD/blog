<?php

namespace App\Controllers;

use App\Models\UserManager;
use App\Controllers\CoreController;
use App\Utils\Alert;
use App\Utils\Validator;
use \DateTime;

final class UserController extends CoreController
{
	private $validator;

	public function __construct()
	{
		$this->userManager = new UserManager();
		$this->validator = new Validator;
	}

	public function showAll()
	{
		if($this->isAdmin()){
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
		} else {
			$this->redirect("main-home");
		}

	}

	public function adminUpdateForm($params = [])
	{
		if($this->isAdmin()){
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
		} else {
			$this->redirect("main-home");
		}
	}

	public function update()
	{
		if($this->isAdmin()){
			$this->userManager->update(
				(string)$_POST['email'],
				(string)$_POST['username'],
				(bool)$_POST['admin'],
				(bool)$_POST['active'],
				(int)$_POST['id']
			);
			Alert::addAlert(Alert::GREEN, "Modification de l'utilisateur effectuée.");
			$this->redirect("admin-users");
		} else {
			$this->redirect("main-home");
		}
	}

	public function delete()
	{
		if($this->isAdmin()){
			$this->userManager->delete((int)$_POST['id']);
			Alert::addAlert(Alert::GREEN, "Suppression de l'utilisateur effectuée.");
			$this->redirect("admin-users");
		} else {
			$this->redirect("main-home");
		}
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
				Alert::addAlert(Alert::RED, "Identifiant ou mot de passe incorrect.");
				$this->redirect("log-in");

			}elseif(password_verify((string)$_POST['password'],$user->getPassword())){
				$_SESSION['auth'] = $user->getId();
				Alert::addAlert(Alert::GREEN, "Connexion effectuée.");
				$this->redirect("main-home");

			} else {
				Alert::addAlert(Alert::RED, "Identifiant ou mot de passe incorrect.");
				$this->redirect("log-in");
			}
		}
	}

	public function logOut()
	{
		if($this->isLogged()){
			session_destroy();
		}
		$this->redirect("main-home");
	}

	public function insert()
	{	
		$email = (string)$_POST['email'];
		if($this->validator->checkInputEmail($email)){
			$userWanted2 = $this->userManager->findByEmail($email);
			if($userWanted2 && $email === $userWanted2->getEmail()){
				Alert::addAlert(Alert::RED, "Un compte existe déjà pour cet email.");
			};
		}

		$username = (string)$_POST['username'];
		if($this->validator->checkInputText($username, "du nom d'utilisateur", 3, 20)){
			$userWanted = $this->userManager->findByUsername($username);
			if($userWanted && $username === $userWanted->getUsername()){
				Alert::addAlert(Alert::RED, "Nom d'utilisateur déjà pris.");
			};
		}

		$password = (string)$_POST['password'];
		$this->validator->checkInputText($password, "du mot de passe", 4, 20);

		if(empty($_SESSION['alert'])){
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
				Alert::addAlert(Alert::GREEN, 'Vous allez recevoir un email automatique avec un lien pour valider votre inscription (valable seulement 24h).');
			} else{
				Alert::addAlert(Alert::RED, "Problème d'envoi d'email.");
			}
			$this->redirect('main-home');
		} else {
			$this->redirect('user-insert-form');
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