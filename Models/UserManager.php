<?php

namespace App\Models;

use \PDO;
use App\Models\User;
use App\Models\CoreModel;

final class UserManager extends CoreModel
{
	protected $table = 'user';
	protected $className = User::class;

	public function update(string $email, string $username, bool $admin, bool $active, int $id)
	{
		$query = $this->getDB()->prepare("UPDATE user SET 
			email = :email,
			username = :username,
			admin = :admin,
			active = :active
			WHERE id = :id");
		$query->bindValue(":email", $email, PDO::PARAM_STR);
		$query->bindValue(":username", $username, PDO::PARAM_STR);
		$query->bindValue(":admin",$admin,PDO::PARAM_BOOL);
		$query->bindValue(":active",$active,PDO::PARAM_BOOL);
		$query->bindValue(":id", $id, PDO::PARAM_INT);
		$query->execute();

	}

	public function findByUsername(string $username)
	{
		$query = $this->getDB()->prepare("SELECT * FROM user WHERE username = :username");
		$query->bindValue(":username", $username, PDO::PARAM_STR);
		$query->execute();
		$user = $query->fetchObject($this->className);
		return $user;
	}

	public function findByEmail(string $email)
	{
		$query = $this->getDB()->prepare("SELECT * FROM user WHERE email = :email");
		$query->bindValue(":email", $email, PDO::PARAM_STR);
		$query->execute();
		$user = $query->fetchObject($this->className);
		return $user;
	}

	public function insert(String $email, String $username, String $password, string $token)
	{
		$query = $this->getDB()->prepare("INSERT INTO user SET 
			email = :email,
			username = :username,
			password = :password,
			admin = 0,
			active = 0,
			token = :token,
			token_date = NOW()");

		$query->bindValue(":email",$email,PDO::PARAM_STR);
		$query->bindValue(":username",$username,PDO::PARAM_STR);
		$query->bindValue(":password",$password,PDO::PARAM_STR);
		$query->bindValue(":token",$token,PDO::PARAM_STR);
		$query->execute();
		return $this->getDB()->lastInsertId();

	}
	public function setActive(bool $active, int $id)
	{
		$query = $this->getDB()->prepare("UPDATE user SET 
			active = :active
			WHERE id = :id");
		$query->bindValue(":active",$active,PDO::PARAM_BOOL);
		$query->bindValue(":id", $id, PDO::PARAM_INT);
		$query->execute();

	}

	public function isAdmin(int $id)
	{
		
	}

}