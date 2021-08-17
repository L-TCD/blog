<?php

namespace App\Models;

use DateTime;

final class Comment
{	
	private int $id;
	private string $content;
	private string $created_at;
	private ?bool $valid;
	private ?bool $rejected;
	private int $user_id;
	private string $username;
	private int $post_id;
	
	public function getId() : int
	{
		return $this->id;
	}

	public function getContent() : string
	{
		return $this->content;
	}

	public function getCreatedAt() : DateTime
	{
		return new DateTime($this->created_at);
	}

	public function getValid() : ?bool
	{
		return $this->valid;
	}

	public function getRejected() : ?bool
	{
		return $this->rejected;
	}

	public function getUserId() : int
	{
		return $this->user_id;
	}

	public function getUsername() : string
	{
		return $this->username;
	}

	public function getPostId() : int
	{
		return $this->post_id;
	}

}