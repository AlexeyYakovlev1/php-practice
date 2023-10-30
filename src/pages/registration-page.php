<?php
$auth = isset($_COOKIE["token"]);
$page_title = "Registration";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $page_title ?></title>
	<link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
	<div class="alert"></div>
	<?php if ($auth): ?>
	<div>
		<h1>Вы уже вошли</h1>
		<a href="./home-page.php">Перейти на главную страницу</a>
	</div>
	<?php else: ?>
	<div class="content">
		<h2>Добро пожаловать</h2>
		<form class="form">
			<input type="text" name="name" placeholder="Имя"/>
			<input type="email" name="email" placeholder="Почта"/>
			<input type="password" name="password" placeholder="Пароль"/>
			<button id="submit">Отправить</button>

			<div class="form__footer">
				<p>
					Есть аккаунт? <a href="./login-page.php">войти</a>
				</p>
			</div>
		</form>
		<p class="loader hidden">Отправка данных...</p>
	</div>
	<?php endif; ?>
	<?php if (!$auth): ?>
	<script src="../scripts/auth/registration.js" type="module"></script>
	<?php endif; ?>
</body>
</html>