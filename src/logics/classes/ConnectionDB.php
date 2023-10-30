<?php
class ConnectionDB {
	public $host = "localhost";
	public $username = "root";
	public $password = "";
	public $dbname = "pdo";

	public function connect() {
		try {
			$pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};", $this->username, $this->password);
			
			return $pdo;
		} catch(PDOException $exception) {
			echo "При подключении к базе данных произошла ошибка: <strong>{$exception->getMessage()}<strong/>";
		}
	}
}