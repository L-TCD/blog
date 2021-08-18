<?php

namespace App\Models;

use \PDO;

abstract class CoreModel
{
	private static $pdo;
	protected $table;
	protected $className;

	private static function setDB()
	{
		self::$pdo = new PDO("mysql:host=localhost;dbname=blog;charset=utf8","root","root", [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		]);
	}

	protected function getDB()
	{
		if(self::$pdo === null){
			self::setDB();
		}
		return self::$pdo;
	}

	public function findAll(?string $orderBy = "")
	{	
		$sql = "SELECT * FROM {$this->table}";
		if($orderBy) $sql.=" ORDER BY $orderBy";
		$query = $this->getDB()->prepare($sql);
		$query->execute();
		$items = $query->fetchAll(PDO::FETCH_CLASS, $this->className);
		return $items;
	}

	public function find(int $id)
	{
		$query = $this->getDB()->prepare("SELECT * FROM post WHERE id = :id");
		$query->execute([
			":id" => $id
		]);
		$item = $query->fetchObject($this->className);
		return $item;
	}

		public function delete(int $id)
	{
		$query = $this->getDB()->prepare("DELETE FROM {$this->table} WHERE id = :id");
		$query->execute([
			":id" => $id
		]);
	}
}
