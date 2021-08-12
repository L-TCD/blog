<?php
namespace App\Models;

use DateTime;

class Comment
{	
	private $id;
	private $content;
	private $created_at;
	private $valid;
	private $rejected;
	private $user_id;
	private $username;
	private $post_id;
	
	public function getId()
	{
		return $this->id;
	}
	public function getContent()
	{
		return $this->content;
	}
	public function getCreatedAt() : DateTime
	{
		return new DateTime($this->created_at);
	}
	public function getUsername()
	{
		return $this->username;
	}

}