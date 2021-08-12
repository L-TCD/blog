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
		$query = $this->getDB()->prepare("SELECT
			p.id AS id,
			p.title AS title,
			p.slug AS slug,
			p.content AS content,
			p.description AS description,
			p.created_at AS created_at,
			p.update_at AS update_at,
			p.user_id AS user_id,
			u.username AS username
		FROM post p
		INNER JOIN user u ON p.user_id = u.id
		WHERE p.id = :id");
		$query->execute([
			"id" => $id
			]);

		$datas = $query->fetchObject(Post::class);
		return $datas;
	}

}