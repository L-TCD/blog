<?php

namespace App\Controllers;

use App\Controllers\CoreController;
use App\Utils\Alert;
use App\Utils\Validator;

final class HomeController extends CoreController
{
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

		if(
			!Validator::verifMail($email) ||
			(strlen($object) < 3 || strlen($object) > 60) ||
			(strlen($message) < 3 || strlen($message) > 2000)	
		){
			if(!Validator::verifMail($email)){Alert::addAlert(Alert::RED, "Le format de l'adresse email est invalide.");}
			if(strlen($object) < 3 || strlen($object) > 60){Alert::addAlert(Alert::RED, "La longueur de l'objet doit être comprise entre 3 et 60 caractères");}
			if(strlen($message) < 3 || strlen($message) > 2000){Alert::addAlert(Alert::RED, "La longueur du message doit être comprise entre 3 et 2000 caractères");}
		} else {
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