<?php
$auth = isset($_COOKIE["token"]);
$page_title = "Login";
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
		<h2>С возвращением</h2>
		<form class="form">
			<input type="email" name="email" placeholder="Почта"/>
			<input type="password" name="password" placeholder="Пароль"/>
			<button id="submit">Войти</button>

			<div class="form__footer">
				<p>
					Нет аккаунта? <a href="./registration-page.php">зарегистрироваться</a>
				</p>
			</div>
		</form>
		<p class="loader hidden">Отправка данных...</p>
	</div>
	<?php endif; ?>
	<?php if (!$auth): ?>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc"></script>
	<script src="../scripts/auth/login.js" type="module"></script>
	<?php endif; ?>
</body>
</html>