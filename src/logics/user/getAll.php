<?php
require __DIR__ . "/../../../vendor/autoload.php";

require_once("../classes/Utils.php");
require_once("../classes/ConnectionDB.php");

$conn = new ConnectionDB();
$conn = $conn->connect();

$sql_for_find_all = "SELECT * FROM users";
$state_for_users = $conn->prepare($sql_for_find_all);

try {
	$state_for_users->execute();

	echo json_encode($state_for_users->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOEXception $exception) {
	$payload = [
		"success" => false,
		"message" => "При поиске пользователей произошла ошибка: <strong>{$exception->getMessage()}</strong>"
	];

	echo json_encode($payload);
}