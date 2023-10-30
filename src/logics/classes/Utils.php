<?php
require __DIR__ . "/../../../vendor/autoload.php";

use Vudev\JsonWebToken\JWT;

class Utils {
	// Генерация идентификатора
	public static function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		
		return $randomString;
	}

	// Получение данных из jwt токена
	public static function getDataFromToken($token) {
		$jwt = new JWT;
		$dataFromToken = $jwt->json($token);
		
		return $dataFromToken;
	}
}