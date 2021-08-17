<?php

namespace App\Models;

use \PDO;
use App\Models\Post;
use App\Models\CoreModel;

final class PostManager extends CoreModel
{
	protected $table = 'post';
	protected $className = Post::class;

	public function update(String $title, String $slug, String $content, String $description, String $author, Int $id)
	{
		$query = $this->getDB()->prepare("UPDATE post SET 
			title = :title,
			slug = :slug,
			content = :content,
			description = :description,
			update_at = NOW(),
			author = :author
			WHERE id = :id");

		$query->bindValue(":title",$title,PDO::PARAM_STR);
		$query->bindValue(":slug",$slug,PDO::PARAM_STR);
		$query->bindValue(":content",$content,PDO::PARAM_STR);
		$query->bindValue(":description",$description,PDO::PARAM_STR);
		$query->bindValue(":author",$author,PDO::PARAM_STR);
		$query->bindValue(":id",$id,PDO::PARAM_INT);
		$query->execute();
		//confirm
	}

	public function insert(String $title, String $slug, String $content, String $description, String $author)
	{
		$query = $this->getDB()->prepare("INSERT INTO post SET 
			title = :title,
			slug = :slug,
			content = :content,
			description = :description,
			created_at = NOW(),
			author = :author");

		$query->bindValue(":title",$title,PDO::PARAM_STR);
		$query->bindValue(":slug",$slug,PDO::PARAM_STR);
		$query->bindValue(":content",$content,PDO::PARAM_STR);
		$query->bindValue(":description",$description,PDO::PARAM_STR);
		$query->bindValue(":author",$author,PDO::PARAM_STR);
		$query->execute();
		//confirm
	}

}