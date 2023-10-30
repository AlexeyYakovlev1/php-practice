<?php
require __DIR__ . '/../../../vendor/autoload.php';
use Vudev\JsonWebToken\JWT;
require_once("../classes/ConnectionDB.php");

$pdo = new ConnectionDB();
$pdo = $pdo->connect();

$body = json_decode(file_get_contents("php://input"), true);
$email = $body["email"];
$password = $body["password"];

$sql_for_find_user = "SELECT email FROM users WHERE email = :email";
$state_find_user = $pdo->prepare($sql_for_find_user);

$err = false;

try {
	$state_find_user->execute(["email" => $email]);

	$err = !((bool) $state_find_user->fetch(PDO::FETCH_ASSOC));
} catch (PDOException $exception) {
	$payload = [
		"success" => false,
		"message" => "Ошибка при поиске пользователя: <strong>{$exception->getMessage()}</strong>"
	];

	echo json_encode($payload);
}

if (!$err) {
	$sql_for_select_user = "SELECT * FROM users WHERE email = :email";
	$state_select_user = $pdo->prepare($sql_for_select_user);

	try {
		$state_select_user->execute(["email" => $email]);
		$res = $state_select_user->fetch(PDO::FETCH_ASSOC);

		$check_password = base64_decode($res["password"]) === $password;

		if ($check_password) {
			$payload = ["password" => $res["password"]];

			$secret_key = "NWPnXk>l^{TVhaU"; // $_ENV["SECRET_JWT"]

			$jwt = new JWT([
				"payload" => [
					"user_id" => $res["id"],
					"email" => $res["email"],
					"expiresIn" => "60min"
				],
				"secret" => $secret_key
			]);
			$token = $jwt->createToken();

			$payload = [
				"success" => true,
				"message" => "Успешный вход",
				"token" => $token
			];

			echo json_encode($payload);
		} else {
			$payload = [
				"success" => false,
				"message" => "Данные неверны"
			];

			echo json_encode($payload);
		}
	} catch (PDOException $exception) {
		$payload = [
			"success" => false,
			"message" => "Ошибка при поиске пользователя: <strong>{$exception->getMessage()}</strong>"
		];

		echo json_encode($payload);
	}
} else {
	$payload = [
		"success" => false,
		"message" => "Пользователь по такой почте <strong>$email</strong> не найден"
	];

	echo json_encode($payload);
}