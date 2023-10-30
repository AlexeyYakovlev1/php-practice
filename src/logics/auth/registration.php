<?php
require __DIR__ . "/../../../vendor/autoload.php";

require_once("../classes/ConnectionDB.php");
require_once("../classes/Utils.php");

$pdo = new ConnectionDB();
$pdo = $pdo->connect();

$body = json_decode(file_get_contents("php://input"), true);
$email = $body["email"];

$sql_for_find_user = "SELECT email FROM users WHERE email = :email";
$state_for_find = $pdo->prepare($sql_for_find_user);

$err = false;

// Находим пользователя по email
try {
	$res = (bool)$state_for_find->fetch(PDO::FETCH_ASSOC);

	// Если пользователь найден, то выдаем ошибку
	if ($res) {
		$payload = [
			"success" => false,
			"message" => "Пользователь с такой почтой уже существует"
		];

		echo json_encode($payload);
		$err = true;
	}
} catch(PDOException $exception) {
	$payload = [
		"success" => false,
		"message" => "Ошибка при поиске пользователя: <strong>{$exception->getMessage()}</strong>"
	];

	echo json_encode($payload);
}

if (!$err) {
	$sql_for_insert_user = "INSERT INTO users(id,name,email,password)
		VALUES(:id, :name, :email, :password)";
	$state_for_insert_user = $pdo->prepare($sql_for_insert_user);

	$id = Utils::generateRandomString(); // Генерируем идентификатор
	$name = $body["name"];
	$hash_password = base64_encode($body["password"]); // Хешируем пароль

	try {
		$state_for_insert_user->execute([
			"id" => $id,
			"name" => $name,
			"email" => $email,
			"password" => $hash_password
		]);

		$payload = [
			"success" => true,
			"message" => "Пользователь по умени $name успешно создан!"
		];

		echo json_encode($payload);
	} catch(PDOException $exception) {
		$payload = [
			"success" => false,
			"message" => "Ошибка при создании пользователя: <strong>{$exception->getMessage()}</strong>"
		];

		echo json_encode($payload);
	}	
}