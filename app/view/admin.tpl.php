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
	<table>
		<thead>
		<tr>
			<th>Bid</th>
			<th><?= t("Titulka") ?></th>
			<th><?= t("Editovať") ?></th>
			<th><?= t("Preložiť") ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($this->blog_posts as $blog_post): ?>
		<tr>
			<td><?= $blog_post->bid ?></td>
			<td><?= $blog_post->title ?></td>
			<td><a href="/admin/blog/sk/<?= $blog_post->bid ?>"><?= t("Editovať") ?></a></td>
			<td><a href="/admin/blog/en/<?= $blog_post->bid ?>"><?= t("Preložiť") ?></a></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<a href="/admin/blog/sk"><?= t("Nový článok") ?></a>
</main>
<?php include 'app/view/page/footer.tpl.php' ?>
</body>
</html>
