<?php

namespace App\Models;

final class User
{	
	private int $id;
	private string $email;
	private string $username;
	private string $password;
	private ?bool $admin;

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

	public function getAdmin() : ?bool
	{
		return $this->admin;
	}
}