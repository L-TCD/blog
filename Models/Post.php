<?php

namespace App\Models;

use DateTime;

final class Post
{	
	private int $id;
	private string $title;
	private string $content;
	private string $description;
	private string $created_at;
	private ?string $update_at;
	private string $author;
	private bool $commentToValid = false;

	public function getId() : int
	{
		return $this->id;
	}

	public function getTitle() : string
	{
		return $this->title;
	}

	public function getContent() : string
	{
		return $this->content;
	}

	public function getDescription() : string
	{
		return $this->description;
	}

	public function getCreatedAt() : DateTime
	{
		return new DateTime($this->created_at);
	}

	public function getUpdateAt() : ?DateTime
	{
		if($this->update_at !== null){
			return new DateTime($this->update_at);
		} return null;
	}

	public function getAuthor() : string
	{
		return $this->author;
	}

	public function getCommentToValid() : bool
	{
		return $this->commentToValid;
	}

	public function setCommentToValid(bool $bool) : void
	{
		$this->commentToValid = $bool;
	}

}