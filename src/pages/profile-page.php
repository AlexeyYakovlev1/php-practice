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
	<title>Document</title>
	<link rel="stylesheet" href="../styles/profile.css">
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

	<div class="content">
		<img src="" alt="" id="avatar" />
		<span id="name">Loading...</span>
		<span id="email"></span>
		<p id="description"></p>
		
		<div class="user-do">
			<a href="http://sqlwork/src/pages/settings-page.php">Настройки</a>
		</div>
	</div>

	<?php if ($auth): ?>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc"></script>
	<script src="../scripts/getUserData.js"></script>
	<script src="../scripts/auth/logout.js"></script>
	<?php endif ?>
</body>
</html>