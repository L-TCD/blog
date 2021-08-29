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
		$to = $configData['DEV_EMAIL'];
		$email = (string)$_POST['email'];
		$object = (string)$_POST['object'];
		$message = (string)$_POST['message'];

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: ". $email . "\r\n";
		$headers .= "Reply-To: ". $email . "\r\n";

		$this->validator->checkInputEmail($email);
		$this->validator->checkInputText($object, "de l'objet", 3, 60);
		$this->validator->checkInputText($object, "du message", 3, 2000);

		if(empty($_SESSION['alert'])){
			if(mail($to, $object, $message, $headers)){
				Alert::addAlert(Alert::GREEN, 'Message envoyé, merci.');
				$email = "";
				$object = "";
				$message = "";
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
			"view" => PATH_VIEW . "/home.view.php",
			"template" => PATH_VIEW . "/common/template.php"
		];
		$this->generatePage($dataPage);
	}
}