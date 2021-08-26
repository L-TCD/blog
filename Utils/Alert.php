<?php

namespace App\Utils;

class Alert
{
	public const RED = "alert-danger";
	public const GREEN = "alert-success";

	public static function addAlert(string $type, string $text)
	{
		$_SESSION['alert'][] = [
			"type" => $type,
			"text" => $text
		];
	}
}