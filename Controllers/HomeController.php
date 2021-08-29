<?php

namespace App\Controllers;

use App\Controllers\CoreController;
use App\Utils\Alert;
use App\Utils\Validator;

final class HomeController extends CoreController
{

	private $validator;

	public function __construct()
	{
		$this->validator = new Validator;
	}
	public function home()
	{
		$dataPage = [
			"pageDescription" => "Page d'accueil du blog !",
			"pageTitle" => "Page d'accueil du blog",
			"view" => PATH_VIEW . "/home.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}

	public function contact()
	{	
		$configData = parse_ini_file(__DIR__ . '/../config.ini');
		$to = $configData['CONTACT_EMAIL'];

		$email = $this->escape($_POST['email']);
		$object = $this->escape($_POST['object']);
		$message = $this->escape($_POST['message']);
		$firstName = $this->escape($_POST['firstName']);
		$lastName = $this->escape($_POST['lastName']);

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
				Alert::addAlert(Alert::GREEN, 'Message envoyé, merci.');
				$email = "";
				$object = "";
				$message = "";
				$firstName = "";
				$lastName = "";
			} else{
				Alert::addAlert(Alert::RED, "Problème avec l'envoi de l'email.");
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