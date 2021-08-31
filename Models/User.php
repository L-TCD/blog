<?php

namespace App\Models;

use DateTime;

final class User
{	
	private int $id;
	private string $email;
	private string $username;
	private string $password;
	private bool $admin;
	private bool $active;
	private ?string $token;
	private ?string $token_date;
	

	public function getId() : int
	{
		return $this->id;
	}

	public function getEmail() : string
	{
		return $this->email;
	}

	public function getUsername() : string
	{
		return $this->username;
	}

	public function getPassword() : string
	{
		return $this->password;
	}

	public function getAdmin() : bool
	{
		return $this->admin;
	}

	public function getActive() : bool
	{
		return $this->active;
	}

	public function getToken() : ?string
	{
		return $this->token;
	}

	public function getTokenDate() : DateTime
	{
		return new DateTime($this->token_date);
	}
}