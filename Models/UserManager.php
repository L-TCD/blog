<?php

namespace App\Models;

use \PDO;
use App\Models\User;
use App\Models\CoreModel;

final class UserManager extends CoreModel
{
	protected $table = 'user';
	protected $className = User::class;

	public function update(string $email, string $username, bool $admin, int $id)
	{
		$query = $this->getDB()->prepare("UPDATE user SET 
			email = :email,
			username = :username,
			admin = :admin
			WHERE id = :id");
		$query->bindValue(":email", $email, PDO::PARAM_STR);
		$query->bindValue(":username", $username, PDO::PARAM_STR);
		$query->bindValue(":admin",$admin,PDO::PARAM_BOOL);
		$query->bindValue(":id", $id, PDO::PARAM_INT);
		$query->execute();
	
	}

}