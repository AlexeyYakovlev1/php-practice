<?php
$auth = isset($_COOKIE["token"]);
$page_title = "Users list";

if (!$auth) {
	header("Location: http://sqlwork/src/pages/login-page.php");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Настройки пользователя</title>
	<link rel="stylesheet" href="../styles/settings.css">
</head>
<body>
	<header>
		<nav>
			<ul>
				<li>
					<a href="http://sqlwork/src/pages/home-page.php">Home</a>
				</li>
				<li>
					<a href="http://sqlwork/src/pages/profile-page.php">Profile</a>
				</li>
				<li>
					<a href="http://sqlwork/src/pages/settings-page.php">Settings</a>
				</li>
			</ul>
		</nav>
	</header>

	<button class="logout">Выйти</button>

	<div class="alert"></div>

	<form class="form">
		<img class="img-avatar" src="" alt="user avatar" />
		<input class="form__avatar" type="text" name="avatar" placeholder="Аватар" />
		<input class="form__name" type="text" name="name" placeholder="Логин" />
		<input class="form__email" type="email" name="email" placeholder="Почта" />
		<textarea class="form__description" type="text" name="description" placeholder="Описание"></textarea>

		<button>Изменить</button>
	</form>

	<?php if ($auth): ?>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc"></script>
	<script src="../scripts/settings.js"></script>
	<script src="../scripts/auth/logout.js"></script>
	<?php endif ?>
</body>
</html>