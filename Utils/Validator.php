<?php

namespace App\Utils;

class Validator
{

	public static function verifMail($emailAdress) : bool
	{
		if (filter_var ($emailAdress, FILTER_VALIDATE_EMAIL) === false) {
			return false;
		} else {
			return true;
		}
	}

	// test + alert en cas d'erreur et redirect si présence d'une Alerte

}