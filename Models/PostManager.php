<?php
require_once '../Models/CoreModel.php';

class PostManager extends CoreModel
{
	public function findAll()
	{
		$query = $this->getDB()->prepare("SELECT * FROM post");
		$query->execute();
		$datas = $query->fetchAll(PDO::FETCH_OBJ);
		return $datas;
	}

}