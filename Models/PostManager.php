<?php
namespace App\Models;

use \PDO;
use App\Models\Post;
use App\Models\CoreModel;

class PostManager extends CoreModel
{
	public function findAll()
	{
		$query = $this->getDB()->prepare("SELECT * FROM post ORDER BY id DESC");
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
			":id" => $id
		]);

		$datas = $query->fetchObject(Post::class);
		return $datas;
	}

	public function updatePost($title, $slug, $content, $description, $id)
	{
		$query = $this->getDB()->prepare("UPDATE post SET 
			title = :title,
			slug = :slug,
			content = :content,
			description = :description,
			update_at = NOW()
			WHERE id = :id");

		$query->bindValue(":title",$title,PDO::PARAM_STR);
		$query->bindValue(":slug",$slug,PDO::PARAM_STR);
		$query->bindValue(":content",$content,PDO::PARAM_STR);
		$query->bindValue(":description",$description,PDO::PARAM_STR);
		$query->bindValue(":id",$id,PDO::PARAM_INT);
		$query->execute();
		//confirm
	}

	public function deletePost($id)
	{
		$query = $this->getDB()->prepare("DELETE FROM post WHERE id = :id");
		$query->execute([
			":id" => $id
		]);
		//confirm
	}

	public function addPost(String $title, String $slug, String $content, String $description)
	{
		$query = $this->getDB()->prepare("INSERT INTO post SET 
			title = :title,
			slug = :slug,
			content = :content,
			description = :description,
			created_at = NOW(),
			user_id = 1");

		$query->bindValue(":title",$title,PDO::PARAM_STR);
		$query->bindValue(":slug",$slug,PDO::PARAM_STR);
		$query->bindValue(":content",$content,PDO::PARAM_STR);
		$query->bindValue(":description",$description,PDO::PARAM_STR);
		$query->execute();
		//confirm
	}

}