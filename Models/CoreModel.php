<?php

abstract class CoreModel
{
	private static $pdo;

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
}
