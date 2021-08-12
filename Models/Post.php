<?php
namespace App\Models;

use DateTime;

class Post
{	
	private $id;
	private $title;
	private $slug;
	private $content;
	private $description;
	private $created_at;
	private $update_at;
	private $user_id;
	private $username;

	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getSlug()
	{
		return $this->slug;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getCreatedAt() : DateTime
	{
		return new DateTime($this->created_at);
	}

	public function getUpdateAt()
	{
		return $this->update_at;
	}

	public function getUserId()
	{
		return $this->user_id;
	}

	public function getusername()
	{
		return $this->username;
	}

}