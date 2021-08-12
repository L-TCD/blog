<?php
namespace App\Models;

use \PDO;
use App\Models\Comment;
use App\Models\CoreModel;

class CommentManager extends CoreModel
{
	public function findAllByPostId($id)
	{
		$query = $this->getDB()->prepare("SELECT
			c.id AS id,
			c.content AS content,
			c.created_at AS created_at,
			c.valid AS valid,
			c.rejected AS rejected,
			c.user_id AS user_id,
			u.username as username,
			c.post_id AS post_id
		FROM comment c
		INNER JOIN user u ON c.user_id = u.id
		WHERE post_id = :id");
		$query->execute([
			"id" => $id
		]);
		$datas = $query->fetchAll(PDO::FETCH_CLASS, Comment::class);
		return $datas;
	}

	public function find($id)
	{
		$query = $this->getDB()->prepare("SELECT * FROM comment WHERE id = :id");
		$query->execute([
			":id" => $id
		]);

		$datas = $query->fetchObject(Comment::class);
		return $datas;
	}

}