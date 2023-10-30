<?php
require_once("../classes/Utils.php");
require_once("../classes/ConnectionDB.php");

$conn = new ConnectionDB();
$conn = $conn->connect();

$body = json_decode(file_get_contents("php://input"), true);
$token = $body["token"];
$utils = new Utils();

try {
	$payload = $utils->getDataFromToken($token)["payload"];
	$id = $payload["user_id"];

	$removed_id = $body["removed_id"];

	if (!isset($id)) {
		$payload = [
			"success" => false,
			"message" => "Нет доступа"
		];

		echo json_encode($payload);
		exit;
	}

	$sql_for_remove_user = "DELETE FROM users WHERE id = :id";
	$state_for_remove_user = $conn->prepare($sql_for_remove_user);

	$state_for_remove_user->execute(["id" => $removed_id]);

	if ($id === $removed_id) {
		echo json_encode(["success" => true, "redirect" => true]);
		exit;		
	}

	echo json_encode(["success" => true, "message" => "User has been deleted"]);
} catch(\Exception $exception) {
	$payload = [
		"success" => false,
		"message" => "Ошибка сервера: <strong>{$exception->getMessage()}</strong>"
	];
}