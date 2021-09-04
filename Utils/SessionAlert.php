<?php

namespace App\Utils;

use App\Utils\Session;

class SessionAlert extends Session
{
	protected $key = 'alert';

	public const RED = "alert-danger";
	public const GREEN = "alert-success";

	public function addAlert(string $type, string $message)
	{
		$this->put(["type" => $type, "text" => $message]);
	}
}