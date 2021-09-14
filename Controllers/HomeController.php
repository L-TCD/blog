<?php

namespace App\Controllers;

use App\Controllers\CoreController;
use App\Utils\SessionAlert;
use App\Utils\Validator;

final class HomeController extends CoreController
{
	private $validator;
	private $sessionAlert;

	public function __construct()
	{
		$this->validator = new Validator;
		$this->sessionAlert = new SessionAlert;
	}

	/**
	 * show the homepage
	 */
	public function home(): void
	{
		$dataPage = [
			"pageDescription" => "Page d'accueil du blog !",
			"pageTitle" => "Page d'accueil du blog",
			"view" => PATH_VIEW . "/home.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	/**
	 * send a message to the blog owner
	 */
	public function contact(): void
	{	
		$configData = parse_ini_file(__DIR__ . '/../config.ini');
		$to = $configData['CONTACT_EMAIL'];

		$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
		$object = filter_input(INPUT_POST, 'object',FILTER_SANITIZE_STRING);
		$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
		$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
		$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: ". $email . "\r\n";
		$headers .= "Reply-To: ". $email . "\r\n";

		$this->validator->checkInputText($firstName, "du Prénom", 1, 60);
		$this->validator->checkInputText($lastName, "du Nom", 1, 60);
		$this->validator->checkInputEmail($email);
		$this->validator->checkInputText($object, "de l'objet", 3, 60);
		$this->validator->checkInputText($message, "du message", 3, 2000);

		$emailContent = "Message de la part de <strong>$firstName $lastName</strong> :<br><br>";
		$emailContent .= $message;

		if(empty($_SESSION['alert'])){
			if(mail($to, $object, $emailContent, $headers)){
				$this->sessionAlert->addAlert(sessionAlert::GREEN, 'Message envoyé, merci.');
				$email = "";
				$object = "";
				$message = "";
				$firstName = "";
				$lastName = "";
			} else{
				$this->sessionAlert->addAlert(sessionAlert::RED, "Problème avec l'envoi de l'email.");
			}
		}

		$dataPage = [
			"pageDescription" => "Page d'accueil du blog !",
			"pageTitle" => "Page d'accueil du blog",
			"email" => $email,
			"object" => $object,
			"message" => $message,
			"firstName" => $firstName,
			"lastName" => $lastName,
			"view" => PATH_VIEW . "/home.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}
}