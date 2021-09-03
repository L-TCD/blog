<?php

namespace App\Utils;

use App\Utils\Alert;

class Validator
{
/**
 * Return true if email is valid and return false with an alert if it's not.
 */
	public function checkInputEmail($emailAdress) : bool
	{
		if (filter_var ($emailAdress, FILTER_VALIDATE_EMAIL) === false) {
			$this->sessionAlert->addAlert(SessionAlert::RED, "Le format de l'adresse email est invalide.");
			return false;
		} else {
			return true;
		}
	}

	public function checkInputText($input, $name, $min, $max) : bool
	{
		if (strlen($input) < $min || strlen($input) > $max) {
			$this->sessionAlert->addAlert(SessionAlert::RED, "La longueur $name doit être comprise entre $min et $max caractères");
			return false;
		} else {
			return true;
		}
	}	

}
