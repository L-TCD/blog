<?php

namespace App\Utils;

abstract class Session
{
	protected $key;

    public function put($value)
	{
        $_SESSION[$this->key][] = $value;
    }

    public function getFirst()
	{
        return (isset($_SESSION[$this->key]) ? $_SESSION[$this->key][0] : null);
    }

	public function getAll() : array
	{
        return (isset($_SESSION[$this->key]) ? $_SESSION[$this->key] : null);
    }

    public function forget()
	{
        unset($_SESSION[$this->key]);
    }
}