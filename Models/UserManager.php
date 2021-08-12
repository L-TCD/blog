<?php
namespace App\Models;

use \PDO;
use App\Models\User;
use App\Models\CoreModel;

class UserManager extends CoreModel
{
	public function findAll()
	{
		$query = $this->getDB()->prepare("SELECT * FROM user");
		$query->execute();
		$datas = $query->fetchAll(PDO::FETCH_CLASS, User::class);
		return $datas;
	}

	public function find($id)
	{
		$query = $this->getDB()->prepare("SELECT * FROM user WHERE id = :id");
		$query->execute([
			":id" => $id
		]);

		$datas = $query->fetchObject(User::class);
		return $datas;
	}

}