<?php

namespace App\Utils;

use App\Utils\Session;

class Alert
{
	public const RED = "alert-danger";
	public const GREEN = "alert-success";

	public static function addAlert(string $type, string $text)
	{
		Session::put('alert',[
			"type" => $type,
			"text" => $text
		]);
		// $_SESSION['alert'][] = [
		// 	"type" => $type,
		// 	"text" => $text
		// ];
	}
}