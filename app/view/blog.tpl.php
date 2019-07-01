<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="/cdn/style.css">
	<title>Janek.xyz</title>
</head>
<body>
<?php include 'app/view/page/header.tpl.php' ?>
<main>
	<article>
		<h1><?= $this->blog->title ?></h1>
		<i><?= date(t('d.m.Y'), strtotime($this->blog->created)) ?></i>
		<?= $this->converter->convertToHtml($this->blog->markdown) ?>
	</article>
</main>
<?php include 'app/view/page/footer.tpl.php' ?>
</body>
</html>
