<?php

namespace App\Models;

use \PDO;

abstract class CoreModel
{
	private static $pdo;
	protected $table;
	protected $className;

	protected static function setDB()
{
    // Récupération des données du fichier de config
    // la fonction parse_ini_file parse le fichier et retourne un array associatif
    $configData = parse_ini_file(__DIR__ . '/../config.ini');
    
    // dsn = Data source name
    $dsn = "mysql:host={$configData['DB_HOST']};dbname={$configData['DB_NAME']};charset=utf8";
    
    self::$pdo = new PDO(
	    $dsn,
	    $configData['DB_USERNAME'],
	    $configData['DB_PASSWORD'],
	    [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	    ]
    );
		
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
		$query = $this->getDB()->prepare("SELECT * FROM {$this->table} WHERE id = :id");
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
