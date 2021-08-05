<?php

class Post
{	
	private $id;
	private $title;
	private $slug;
	private $content;
	private $description;
	private $publication_date;
	private $update_date;
	private $user_id;

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

	public function getPublicationDate()
	{
		return $this->publication_date;
	}

	public function getUpdateDate()
	{
		return $this->update_date;
	}

	public function getUserId()
	{
		return $this->user_id;
	}

	private function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	private function setSlug($slug)
	{
		$this->slug = $slug;
		return $this;
	}

	private function setContent($content)
	{
		$this->content = $content;
		return $this;
	}

	private function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	private function setPublicationDate($publication_date)
	{
		$this->publication_date = $publication_date;
		return $this;
	}

	private function setUpdateDate($update_date)
	{
		$this->update_date = $update_date;
		return $this;
	}

	private function setUserId($user_id)
	{
		$this->user_id = $user_id;
		return $this;
	}
	

}