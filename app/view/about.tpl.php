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
	<?php if (isset($_COOKIE['lang']) && $_COOKIE['lang'] === 'sk') {
		echo t(<<<TEXT
	Študent, programátor, elektronik, zaoberám sa zrýchlením webu, baremetal programovaniu mikrokontrolerov.")
	Momentálne študujem strednú priemyselnú školu Jozefa Murgaša v Banskej Bystrici 
	a pracujem ako web developer v nemenovanej firme. Rád varím, hrám na klavíri napriek tomu, že mám doma 2 gitary a basu.
TEXT
		);
	} else {
		echo t(<<<TEXT
	Student, coder, electronic hobbyist, baremetal coder. Currently studying at SPŠ Jozefa Murgaša in Banská Bystrica, Slovakia.
	Working as web developer. I like cooking, playing on piano (I have 2 guitars). 
TEXT
		);
	}
	?>
</main>
<?php include 'app/view/page/footer.tpl.php' ?>
</body>
</html>
