<?php
require_once("../classes/Utils.php");
require_once("../classes/ConnectionDB.php");

$utils = new Utils();

$conn = new ConnectionDB();
$conn = $conn->connect();

$body = json_decode(file_get_contents("php://input"), true);
$token = $body["token"];

$dataFromToken = $utils->getDataFromToken($token);
$id = $dataFromToken["payload"]["user_id"];

$sql_for_select_user = "SELECT * FROM users WHERE id = :id";
$state_for_user = $conn->prepare($sql_for_select_user);

try {
	$state_for_user->execute(["id" => $id]);

	echo json_encode($state_for_user->fetch(PDO::FETCH_ASSOC));
} catch(PDOEXception $exception) {
	$payload = [
		"success" => false,
		"message" => "При поиске пользователя произошла ошибка: <strong>{$exception->getMessage()}</strong>"
	];

	echo json_encode($payload);
}