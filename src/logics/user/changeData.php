<?php
require_once("../classes/ConnectionDB.php");
require_once("../classes/Utils.php");

$conn = new ConnectionDB();
$conn = $conn->connect();

$body = json_decode(file_get_contents("php://input"), true);
$token = $body["token"];

$utils = new Utils();
$payload = $utils->getDataFromToken($token);
$id = $payload["payload"]["user_id"];
$current_email = $payload["payload"]["email"];

$sql_for_find_user = "SELECT avatar,email,name,description,id FROM users WHERE id = :id";
$sql_for_change_user = "UPDATE users SET avatar = :avatar, description = :description, name = :name, email = :email WHERE id = :id";

if (isset($body["email"]) && $body["email"] !== $current_email) {
	$sql_for_find_by_new_email = "SELECT id FROM users WHERE email = :email";
	$state_for_find_by_new_email = $conn->prepare($sql_for_find_by_new_email);

	try {
		$state_for_find_by_new_email->execute(["email" => $body["email"]]);

		if ($state_for_find_by_new_email->rowCount() > 0) {
			echo json_encode([
				"success" => false,
				"message" => "Пользователь с такой почтой уже существует"
			]);
			
			exit;
		}
	} catch(\Exception $exception) {
		echo json_encode([
			"success" => false,
			"message" => "Ошибка сервера: <strong>{$exception->getMessage()}</strong>"
		]);
	}
}

$state_for_find_user = $conn->prepare($sql_for_find_user);
$state_for_change_user = $conn->prepare($sql_for_change_user);

try {
	$state_for_find_user->execute(["id" => $id]);
	$find_user = $state_for_find_user->fetch(PDO::FETCH_ASSOC);
	
	if (!$find_user) {
		echo json_encode([
			"success" => false,
			"message" => "Пользователя с таким идентификатором не существует"
		]);

		exit;
	}

	$state_for_change_user->execute([
		"avatar" => $body["avatar"] ? $body["avatar"] : $find_user["avatar"],
		"description" => $body["description"] ? $body["description"] : $find_user["description"],
		"name" =>  $body["name"] ? $body["name"] : $find_user["name"],
		"email" => $body["email"] ? $body["email"] : $find_user["email"],
		"id" => $id
	]);
	$update_user = $state_for_change_user->fetch(PDO::FETCH_ASSOC);

	echo json_encode([
		"success" => true,
		"message" => "Пользователь успешно обновлен",
		"updated_user" => $update_user
	]);
} catch(\Exception $exception) {
	$payload = [
		"status" => false,
		"message" => "Ошибка сервера: <strong>{$exception->getMessage()}</strong>"
	];

	echo json_encode($payload);
}