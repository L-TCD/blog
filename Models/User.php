<?php
namespace App\Models;
class User
{	
	private $id;
	private $email;
	private $username;
	private $password;
	private $admin;

	public function getId()
	{
		return $this->id;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getAdmin()
	{
		return $this->admin;
	}

}