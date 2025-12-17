<?php

namespace Models;

use Exception;
use PDO;

class User extends Database
{
	private $id;
	private $firstname;
	private $name;
	private $email;
	private $password;
	private $iban;

	public function getFirstname()
	{
		return $this->firstname;
	}

	public function setFirstname($value)
	{
		if (empty($value))
			throw new Exception('Firstname is required');
		if (strlen($value) < 3 || strlen($value) > 10)
			throw new Exception('Firstname must be between 3 and 10 characters');
		if (!preg_match('/^[a-zA-ZÀ-ÿ]+$/', $value))
			throw new Exception('Firstname can only contain letters and accentuated letters');

		$this->firstname = htmlspecialchars($value);
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($value)
	{
		if (empty($value))
			throw new Exception('Name is required');
		if (strlen($value) < 3 || strlen($value) > 20)
			throw new Exception('Name must be between 3 and 20 characters');
		if (
			!preg_match('/^[a-zA-ZÀ-ÿ]+$/', $value)
		)
			throw new Exception('Name can only contain letters and accentuated letters');

		$this->name = htmlspecialchars($value);
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($value)
	{
		if (empty($value))
			throw new Exception('Email is required');
		if (!filter_var($value, FILTER_VALIDATE_EMAIL))
			throw new Exception('Invalid email address');

		$this->email = htmlspecialchars($value);
	}

	public function setPassword($value)
	{
		if (empty($value))
			throw new Exception('Password is required');
		if (strlen($value) < 3)
			throw new Exception('Password must be at least 3 characters');

		$this->password = password_hash($value, PASSWORD_DEFAULT);
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getIban()
	{
		return $this->iban;
	}

	public function setIban($value)
	{
		if (empty($value))
			throw new Exception('IBAN is required');

		$cleanIban = str_replace(' ', '', $value);

		if (strlen($cleanIban) < 15 || strlen($cleanIban) > 34)
			throw new Exception('IBAN must be between 15 and 34 characters');
		if (!preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]+$/', $cleanIban))
			throw new Exception('Invalid IBAN format');

		$this->iban = htmlspecialchars($value);
	}

	public function register($firstname, $name, $password, $email, $iban)
	{
		$queryExecute = $this->db->prepare("INSERT INTO `users`(`firstname`,`name`,`password`, `email`, `iban`) 
		VALUES (:firstname, :name, :password, :email, :iban)");

		$queryExecute->bindValue(':firstname', $firstname, PDO::PARAM_STR);
		$queryExecute->bindValue(':name', $name, PDO::PARAM_STR);
		$queryExecute->bindValue(':password', $password, PDO::PARAM_STR);
		$queryExecute->bindValue(':email', $email, PDO::PARAM_STR);
		$queryExecute->bindValue(':iban', $iban, PDO::PARAM_STR);

		if ($queryExecute->execute()) {
			return $this->db->lastInsertId();
		}

		return false;
	}

	public function getUserByEmail($email)
	{
		$queryExecute = $this->db->prepare("SELECT `id`, `firstname`, `name`, `email`, `iban`, `password` FROM `users` WHERE `email` = :email");
		$queryExecute->bindValue(':email', $email, PDO::PARAM_STR);
		$queryExecute->execute();

		return $queryExecute->fetch(PDO::FETCH_ASSOC);
	}

	public function deleteUserById($id)
	{
		$queryExecute = $this->db->prepare("DELETE FROM `users` WHERE `id` = :id");
		$queryExecute->bindValue(':id', $id, PDO::PARAM_INT);

		return $queryExecute->execute();
	}

	public function getUserById($id)
	{
		$queryExecute = $this->db->prepare("SELECT `id`, `firstname`, `name`, `password`, `email`, `iban` FROM `users` WHERE `id` = :id");
		$queryExecute->bindValue(':id', $id, PDO::PARAM_INT);
		$queryExecute->execute();

		return $queryExecute->fetch(PDO::FETCH_ASSOC);
	}

	public function updateUser($id, $firstname, $name, $email, $iban)
	{
		$queryExecute = $this->db->prepare("UPDATE `users` SET `firstname` = :firstname, `name` = :name, `email` = :email, `iban` = :iban WHERE `id` = :id");

		$queryExecute->bindValue(':id', $id, PDO::PARAM_INT);
		$queryExecute->bindValue(':firstname', $firstname, PDO::PARAM_STR);
		$queryExecute->bindValue(':name', $name, PDO::PARAM_STR);
		$queryExecute->bindValue(':email', $email, PDO::PARAM_STR);
		$queryExecute->bindValue(':iban', $iban, PDO::PARAM_STR);

		return $queryExecute->execute();
	}

	public function updatePassword($id, $password)
	{
		$queryExecute = $this->db->prepare("UPDATE `users` SET `password` = :password WHERE `id` = :id");

		$queryExecute->bindValue(':id', $id, PDO::PARAM_INT);
		$queryExecute->bindValue(':password', $password, PDO::PARAM_STR);

		return $queryExecute->execute();
	}


}