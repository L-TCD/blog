<?php

namespace App\Controllers;

use \DateTime;
use App\Utils\SessionAlert;
use App\Utils\Validator;
use App\Utils\SessionAuth;
use App\Models\UserManager;
use App\Utils\SessionAdminNav;
use App\Controllers\CoreController;

final class UserController extends CoreController
{
	private $validator;
	private $sessionAlert;
	private $sessionAdminNav;

	public function __construct()
	{
		$this->userManager = new UserManager();
		$this->validator = new Validator;
		$this->sessionAlert = new SessionAlert;
		$this->sessionAdminNav = new SessionAdminNav;
		$this->sessionAuth = new SessionAuth;
	}

	/**
	 * show all users for administrator
	 */
	public function showAll(): void
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

	/**
	 * show the user update form
	 * 
	 * @param array $params
	 */
	public function adminUpdateForm($params = []): void
	{
		if($this->isAdmin()){
			$userToUpdateId = (int)$params['id'];
			$users = $this->userManager->findAll("");
			$dataPage = [
				"pageDescription" => "Page d'affichage de la liste des Utilisateurs",
				"pageTitle" => "Modification utilisateur ".$userToUpdateId,
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

	/**
	 * update the user 
	 */
	public function update(): void
	{
		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		$username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
		$admin = filter_input(INPUT_POST, 'admin', FILTER_VALIDATE_BOOL) ?? false;
		$active = filter_input(INPUT_POST, 'active', FILTER_VALIDATE_BOOL) ?? false;
		$userId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

		if(
			$this->isAdmin() &&
			$this->validator->checkInputEmail($email) &&
			$this->validator->checkInputText($username, "du nom d'utilisateur", 3, 20) &&
			!empty($userId) && 
			$this->userManager->find($userId)
		){
			$this->userManager->update($email, $username, $admin, $active, $userId);
			$this->sessionAlert->addAlert(sessionAlert::GREEN, "Modification de l'utilisateur effectuée.");
			$this->redirect("admin-users");
		} else {
			$this->sessionAlert->addAlert(sessionAlert::RED, "Modification utilisateur abandonnée.");
			$this->redirect("main-home");
		}
	}

	/**
	 * delete the user
	 */
	public function delete(): void
	{
		$userId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		if(
			$this->isAdmin() &&
			!empty($userId) && 
			$this->userManager->find($userId)
		){
			$this->userManager->delete($userId);
			$this->sessionAlert->addAlert(sessionAlert::GREEN, "Suppression de l'utilisateur effectuée.");
			$this->redirect("admin-users");
		} else {
			$this->sessionAlert->addAlert(sessionAlert::RED, "Suppression utilisateur abandonnée.");
			$this->redirect("main-home");
		}
	}

	/**
	 * show the registration page
	 */
	public function insertForm(): void
	{
		$dataPage = [
			"pageDescription" => "Page d'inscription",
			"pageTitle" => "", "Inscription",
			"view" => PATH_VIEW . "/registration.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	/**
	 * show the loggin page
	 */
	public function logInForm(): void
	{
		$dataPage = [
			"pageDescription" => "Page de connexion",
			"pageTitle" => "", "Connexion",
			"view" => PATH_VIEW . "/login.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	/**
	 * log user in
	 */
	public function logIn(): void
	{
		$username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);

		if($username && $password){
			$user = $this->userManager->findByUsername($username);
			if($user === false) {
				$this->sessionAlert->addAlert(sessionAlert::RED, "Identifiant ou mot de passe incorrect.");
				$this->redirect("log-in-form");
			}elseif((password_verify($password, $user->getPassword())) && ($user->getActive() === false)){
				$this->sessionAlert->addAlert(sessionAlert::RED, "Validation de l'email absente, voir email automatique reçu lors de l'inscription");
				$this->redirect("main-home");
			}elseif((password_verify($password, $user->getPassword())) && ($user->getActive() === true)){
				$this->sessionAuth->put($user->getId());
				$this->sessionAdminNav->put($user->getAdmin());
				$this->sessionAlert->addAlert(sessionAlert::GREEN, "Bienvenue <strong>$username</strong> !");
				$this->redirect("main-home");
			}else {
				$this->sessionAlert->addAlert(sessionAlert::RED, "Identifiant ou mot de passe incorrect.");
				$this->redirect("log-in-form");
			}
		}
	}

	/**
	 * log user out
	 */
	public function logOut(): void
	{
		if($this->isLogged()){
			$this->sessionAdminNav->forget();
			$this->sessionAuth->forget();
		}
		$this->redirect("main-home");
	}

	/**
	 * add a new user
	 */
	public function insert(): void
	{	
		$configData = parse_ini_file(__DIR__ . '/../config.ini');
		$url = $configData['WEBSITE_URL'];

		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		$username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);
		$passwordCrypt = password_hash($password, PASSWORD_BCRYPT);

		if($this->validator->checkInputEmail($email)){
			$userWanted2 = $this->userManager->findByEmail($email);
			if($userWanted2 && $email === $userWanted2->getEmail()){
				$this->sessionAlert->addAlert(sessionAlert::RED, "Un compte existe déjà pour cet email.");
			};
		}

		if($this->validator->checkInputText($username, "du nom d'utilisateur", 3, 20)){
			$userWanted = $this->userManager->findByUsername($username);
			if($userWanted && $username === $userWanted->getUsername()){
				$this->sessionAlert->addAlert(sessionAlert::RED, "Nom d'utilisateur déjà pris.");
			};
		}

		$this->validator->checkInputText($password, "du mot de passe", 4, 20);

		if(!($this->sessionAlert->getAll())){
			$token = (string)($username.time());
			$tokenCrypt = crypt($token, 'rl');
			
			$userId = $this->userManager->insert($email, $username, $passwordCrypt, $tokenCrypt);
			$subject = 'Lien de validation';

			$message = '<h1>Bienvenue !</h1>';
			$message .= '<p>Pour valider votre inscription sur le blog, <a href='.$url.'/'.'confirm/'.$userId.'/'.$tokenCrypt.'>Cliquez ici</a>.</p>';
			$message .= '<p> A très vite !</p><br>';

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			if(mail($email, $subject, $message, $headers)){
				$this->sessionAlert->addAlert(sessionAlert::GREEN, 'Vous allez recevoir un email automatique avec un lien pour valider votre inscription (valable seulement 24h).');
			} else{
				$this->sessionAlert->addAlert(sessionAlert::RED, "Problème d'envoi d'email.");
			}
			$this->redirect('main-home');
		} else {
			$this->redirect('user-insert-form');
		}
	}

	/**
	 * confirm the user email and valid the registration
	 * 
	 * @param array $params
	 */
	public function confirm($params = []): void
	{	
		$userId = filter_var ($params['userId'], FILTER_VALIDATE_INT);
		$tokenCrypt = filter_var($params['token'], FILTER_SANITIZE_STRING);
		$user = $this->userManager->find($userId);
		if($user !== false) {
			$token = $user->getToken();
			$now = new DateTime("now");
			$interval = $user->getTokenDate()->diff($now);
			$days = $interval->format('%a');
		}

		if($user === false){
			$this->sessionAlert->addAlert(sessionAlert::RED, 'Utilisateur inconnu.');

		} elseif($user->getActive() === true){
			$this->sessionAlert->addAlert(sessionAlert::RED, 'Compte utilisateur déjà validé');

		} elseif($user->getActive() === false && $token == $tokenCrypt && $days >= 1){
			$this->userManager->delete($userId);
			$this->sessionAlert->addAlert(sessionAlert::RED, "Le lien de validation n'est plus valide, il faut recommencer l'inscription");

		} elseif($token == $tokenCrypt && $days < 1){ 
			$this->userManager->setActive(true, $userId);

			$sessionAuth = new SessionAuth;
			$sessionAuth->put($user->getId());

			$this->sessionAlert->addAlert(sessionAlert::GREEN, 'Validation compte utilisateur effectuée');
			$this->sessionAlert->addAlert(sessionAlert::GREEN, "Bienvenue <strong>".$user->getUsername()."</strong> !");
		} else {
			$this->sessionAlert->addAlert(sessionAlert::RED, 'Lien de validation incorrect');
		}
		
		$this->redirect("main-home");
	}
}