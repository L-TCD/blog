<?php
namespace App\Models;

use \PDO;
use App\Models\Post;
use App\Models\CoreModel;

class PostManager extends CoreModel
{
	public function findAll()
	{
		$query = $this->getDB()->prepare("SELECT * FROM post");
		$query->execute();
		$datas = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
		return $datas;
	}

	public function find($id)
	{
		$query = $this->getDB()->prepare("SELECT * FROM post WHERE id = :id");
		$query->execute([
			":id" => $id
			]);

		$datas = $query->fetchObject(Post::class);
		return $datas;
	}

}