<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="description" content="Jakub Janek's blog">
	<meta name="author" content="Jakub Janek">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="/cdn/style.css">
	<title>Janek.xyz</title>
</head>
<body>
<?php include 'app/view/page/header.tpl.php' ?>
<main>
	<form method="post">
		<label for="password"><?= t("Heslo") ?></label>
		<input type="password" name="password">
		<label for="login"><?= t("Login") ?></label>
		<input type="submit" name="login">
	</form>
</main>
<?php include 'app/view/page/footer.tpl.php' ?>
</body>
</html>
